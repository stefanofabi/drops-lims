<?php

namespace App\Http\Middleware\Administrators\BillingPeriods;

use Closure;
use Illuminate\Http\Request;

use Lang;
use DateTime;

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
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $start_date = new DateTime($request->start_date);
        $end_date = new DateTime($request->end_date);

        if ($start_date > $end_date) 
        {
            return back()->withInput($request->all())->withErrors(Lang::get('billing_periods.start_date_after_end_date'));
        }

        return $next($request);
    }
}
