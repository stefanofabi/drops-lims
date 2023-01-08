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

    /**
     * Generate a summary on the created protocols
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getProtocolsSummary(Request $request)
    {
        //

        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);

        $protocols = $this->internalProtocolRepository->getProtocolsInDatesRange($request->initial_date, $request->ended_date);

        $pdf = PDF::loadView('pdf/generate_reports/protocols_report', [
            'protocols' => $protocols,
            'initial_date' => $request->initial_date,
            'ended_date' => $request->ended_date, 
        ]);

        return $pdf->stream('protocols_report');
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

        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);
        
        $protocols = $this->internalProtocolRepository->getProtocolsInDatesRange($request->initial_date, $request->ended_date);

        $pdf = PDF::loadView('pdf/generate_reports/patients_flow', [
            'protocols' => $protocols,
            'initial_date' => $request->initial_date,
            'ended_date' => $request->ended_date,
        ]);

        return $pdf->stream('patient_flow');
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

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        
        $billing_periods = $this->billingPeriodRepository->getAmountBilledByPeriod($request->start_date, $request->end_date);

        $pdf = PDF::loadView('pdf/generate_reports/debt_social_works', [
            'billing_periods' => $billing_periods,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $pdf->stream('debt_social_works');
    }
}
