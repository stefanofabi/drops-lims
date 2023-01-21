<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;

class TrackIncomeController extends Controller
{
    //

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct(BillingPeriodRepositoryInterface $billingPeriodRepository) 
    {
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    public function index()
    {
        return view('administrators.statistics.track_income');
    }

    public function generateChart(Request $request)
    {
        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);
     
        $track_income = $this->billingPeriodRepository->getTrackIncome($start_billing_period->start_date, $end_billing_period->end_date);

        return view('administrators.statistics.track_income')
            ->with('start_billing_period', $start_billing_period)
            ->with('end_billing_period', $end_billing_period)
            ->with('track_income', $track_income);
    }
}
