<?php

namespace App\Http\Middleware\Administrators\InternalPatients;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalPatientRepositoryInterface;

use Lang;

class CheckIfLoadedPatientEmail
{
    /** @var \App\Contracts\Repository\InternalPatientRepositoryInterface */
    private $internalPatientRepository;

    public function __construct (InternalPatientRepositoryInterface $internalPatientRepository)
    {
        $this->internalPatientRepository = $internalPatientRepository;
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
        $id = (isset($request->id)) ? $request->id : $request->internal_patient_id;

        $patient = $this->internalPatientRepository->findOrFail($id);

        if (empty($patient->email))
        {
            return redirect()->back()->withErrors(Lang::get('patients.patient_have_not_email')); 
        }

        return $next($request);
    }
}
