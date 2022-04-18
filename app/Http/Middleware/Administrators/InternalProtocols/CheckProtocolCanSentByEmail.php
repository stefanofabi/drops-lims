<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;

use Lang;

class CheckProtocolCanSentByEmail
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
        $protocol = $this->internalProtocolRepository->findOrFail($request->id);

        $patient = $protocol->internalPatient;

        if (empty($patient->email))
        {
            return redirect()->back()->withErrors(Lang::get('patients.patient_have_not_email')); 
        }

        return $next($request);
    }
}
