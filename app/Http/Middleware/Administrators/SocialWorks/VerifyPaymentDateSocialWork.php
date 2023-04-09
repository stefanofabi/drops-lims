<?php

namespace App\Http\Middleware\Administrators\SocialWorks;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\BillingPeriodRepositoryInterface; 

use Lang;
use DateTime;

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
        $request->validate([
            'payment_date' => 'required|date',
        ]);

        $billing_period = $this->billingPeriodRepository->findOrFail($request->billing_period_id);

        $end_date = new DateTime($billing_period->end_date);
        $payment_date = new DateTime($request->payment_date);

        if ($end_date > $payment_date) 
        {
            return back()->withInput($request->all())->withErrors(Lang::get('payment_social_works.payment_before_billing_period'));
        }

        return $next($request);
    }
}
