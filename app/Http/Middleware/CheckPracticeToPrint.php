<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;

class CheckPracticeToPrint
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    public function __construct (ProtocolRepositoryInterface $protocolRepository)
    {
        $this->protocolRepository = $protocolRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset($request->filter_practices) && is_array($request->filter_practices)) {
            $protocol = $this->protocolRepository->findOrFail($request->id);
         
            foreach ($request->filter_practices as $practice) 
            {
                if (! in_array($practice, $protocol->practices->toArray())) {
                    // Practice that does not belong to the protocol was detected

                    return redirect()->back()->withErrors(Lang::get('protocols.not_loaded_practices')); 
                }
            }
        } else {
            // Not filtered by practices

            $request->filter_practices = array();
        }


        return $next($request);
    }
}
