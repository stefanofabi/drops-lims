<?php

namespace App\Http\Middleware\Patients;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use Lang;

class VerifySecurityCode
{
    /** @var \App\Contracts\Repository\SecurityCodeRepositoryInterface */
    private $securityCodeRepository;

    public function __construct (SecurityCodeRepositoryInterface $securityCodeRepository)
    {
        $this->securityCodeRepository = $securityCodeRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $security_code = $this->securityCodeRepository->getSecurityCodeAssociate($request->internal_patient_id);

        if (! $security_code) {
            return redirect()->back()->withInput($request->except('security_code'))->withErrors(Lang::get('errors.invalid_security_code'));
        }

        if (! Hash::check($request->security_code, $security_code->security_code)) {
            // Security code not match
            return redirect()->back()->withInput($request->except('security_code'))->withErrors(Lang::get('errors.invalid_security_code'));
        }

        if (! is_null($security_code->used_at)) {
            // The security code was used
            return redirect()->back()->withInput($request->except('security_code'))->withErrors(Lang::get('errors.security_code_already_used', ['day' => $security_code->used_at]));
        }

        if ($security_code->expiration_date < date('Y-m-d')) {
            // Security code has expired
            return redirect()->back()->withInput($request->except('security_code'))->withErrors(Lang::get('errors.security_code_expired', ['day' => $security_code->expiration_date]));
        }

        return $next($request);
    }
}
