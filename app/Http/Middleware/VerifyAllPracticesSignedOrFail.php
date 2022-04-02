<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;

use Lang;

class VerifyAllPracticesSignedOrFail
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

        $protocol = $this->protocolRepository->findOrFail($request->id);

        foreach ($protocol->practices as $practice) 
        {   
            if ($practice->signs->isEmpty()) 
            {
                die(Lang::get('protocols.cannot_print_protocol_with_unsigned_practices'));
            }
        }

        return $next($request);
    }
}
