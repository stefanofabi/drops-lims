<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\PatientRepositoryInterface;

use Lang;

class CheckIfLoadedPatientEmail
{
    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    public function __construct (PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
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
        $id = (isset($request->id)) ? $request->id : $request->patient_id;

        $patient = $this->patientRepository->findOrFail($id);

        if (empty($patient->email))
        {
            return redirect()->back()->withErrors(Lang::get('patients.patient_have_not_email')); 
        }

        return $next($request);
    }
}
