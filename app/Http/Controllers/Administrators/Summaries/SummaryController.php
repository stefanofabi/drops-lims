<?php

namespace App\Http\Controllers\Administrators\Summaries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use PDF;

class SummaryController extends Controller
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct (
        InternalProtocolRepositoryInterface $internalProtocolRepository,
        BillingPeriodRepositoryInterface $billingPeriodRepository
    ) {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    /**
     * Display a generate summaries view
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('administrators.summaries.index');
    }

    public function getProtocolsSummaryView() 
    {
        return view('administrators.summaries.protocols_summary');
    }

    /**
     * Generate a summary on the created protocols
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getProtocolsSummary(Request $request)
    {
        //

        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);

        $protocols = $this->internalProtocolRepository->getProtocolsInDatesRange($start_billing_period->start_date, $end_billing_period->end_date);

        $pdf = PDF::loadView('pdf/summaries/protocols_summary', [
            'protocols' => $protocols,
            'start_date' => $start_billing_period->start_date,
            'end_date' => $end_billing_period->end_date, 
        ]);

        return $pdf->stream('protocols_report');
    }

    public function getPatientsFlowView()
    {
        return view('administrators.summaries.patients_flow');
    }

    /**
     * Generate a summary on the patients flow
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPatientsFlow(Request $request)
    {
        //

        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);

        $protocols = $this->internalProtocolRepository->getProtocolsInDatesRange($start_billing_period->start_date, $end_billing_period->end_date);

        $pdf = PDF::loadView('pdf/summaries/patients_flow', [
            'protocols' => $protocols,
            'start_date' => $start_billing_period->start_date,
            'end_date' => $end_billing_period->end_date,
        ]);

        return $pdf->stream('patient_flow');
    }

    public function getDebtSocialWorksView()
    {
        return view('administrators.summaries.debt_social_works');
    }

    /**
     * Generate a summary on the debt of social works
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getDebtSocialWorks(Request $request)
    {
        //

        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);

        $billing_periods = $this->billingPeriodRepository->getAmountBilledByPeriod($start_billing_period->start_date, $end_billing_period->end_date);

        $pdf = PDF::loadView('pdf/summaries/debt_social_works', [
            'billing_periods' => $billing_periods,
            'start_date' => $start_billing_period->start_date,
            'end_date' => $end_billing_period->end_date,
        ]);

        return $pdf->stream('debt_social_works');
    }
}
