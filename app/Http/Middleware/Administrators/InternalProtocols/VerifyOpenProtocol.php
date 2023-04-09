<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;

use Lang;

class VerifyOpenProtocol
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    public function __construct (InternalProtocolRepositoryInterface $internalProtocolRepository)
    {
        $this->internalProtocolRepository = $internalProtocolRepository;
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
        $id = isset($request->id) ? $request->id : $request->internal_protocol_id;
    
        $protocol = $this->internalProtocolRepository->findOrFail($id);

        if ($protocol->isClosed()) 
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
