<?php

namespace App\Http\Middleware\Administrators\SocialWorks;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\BillingPeriodRepositoryInterface; 

use Lang;

class VerifyPaymentDateSocialWork
{
    /** @var \App\Laboratory\Repositories\BillingPeriods\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    /**
     * VerifyPaymentDateSocialWork constructor.
     *
     * @param BillingPeriodRepositoryInterface $billingPeriodRepository
     */
    public function __construct(BillingPeriodRepositoryInterface $billingPeriodRepository) 
    {
        $this->billingPeriodRepository = $billingPeriodRepository;
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

        $billing_period = $this->billingPeriodRepository->findOrFail($request->billing_period_id);

        if ($billing_period->end_date > $request->payment_date) 
        {
            return back()->withInput($request->all())->withErrors(Lang::get('payment_social_works.payment_before_billing_period'));
        }

        return $next($request);
    }
}
