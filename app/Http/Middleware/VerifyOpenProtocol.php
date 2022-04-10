<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;

use Lang;

class VerifyOpenProtocol
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
        $id = isset($request->id) ? $request->id : $request->protocol_id;
    
        $protocol = $this->protocolRepository->findOrFail($id);

        if (! empty($protocol->closed)) 
        {
            if ($request->ajax())
            {
                return response()->json(['message' => Lang::get('protocols.protocol_closed_message')], 500);
            } else 
            {
                return redirect()->back()->withErrors(Lang::get('protocols.protocol_closed_message'));
            }
        }

        return $next($request);
    }
}