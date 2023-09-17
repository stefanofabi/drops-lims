<?php

namespace App\Http\Middleware\Administrators\BillingPeriods;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use Lang;

class CheckOverlapDates
{

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct(BillingPeriodRepositoryInterface $billingPeriodRepository) 
    {
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if (! $this->billingPeriodRepository->checkOverlapDates($request->start_date, $request->end_date, $request->id))
        {
            return back()->withInput($request->all())->withErrors(Lang::get('billing_periods.overlap_dates'));
        }

        return $next($request);
    }
}
