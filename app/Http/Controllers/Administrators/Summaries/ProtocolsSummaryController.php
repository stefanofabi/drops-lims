<?php

namespace App\Http\Controllers\Administrators\Summaries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use PDF;

class ProtocolsSummaryController extends Controller
{
    //

    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct (InternalProtocolRepositoryInterface $internalProtocolRepository, BillingPeriodRepositoryInterface $billingPeriodRepository) 
    {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
    }


    public function index() 
    {
        return view('administrators.summaries.protocols_summary');
    }

    /**
     * Generate a summary on the created protocols
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateSummary(Request $request)
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
}
