<?php

namespace App\Http\Middleware\Administrators\BillingPeriods;

use Closure;
use Illuminate\Http\Request;

use Lang;

class VerifyBillingPeriodDates
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->start_date > $request->end_date) 
        {
            return back()->withInput($request->all())->withErrors(Lang::get('billing_periods.start_date_after_end_date'));
        }

        return $next($request);
    }
}
