<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\BillingPeriodRepositoryInterface;

class PatientFlowController extends Controller
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
        return view('administrators.statistics.patient_flow');
    }

    public function generateChart(Request $request)
    {

        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);
        
        $patient_flow = $this->billingPeriodRepository->getPatientFlow($start_billing_period->start_date, $end_billing_period->end_date);
        
        return view('administrators.statistics.patient_flow')
            ->with('start_billing_period', $start_billing_period)
            ->with('end_billing_period', $end_billing_period)
            ->with('patient_flow', $patient_flow);
    }
}
