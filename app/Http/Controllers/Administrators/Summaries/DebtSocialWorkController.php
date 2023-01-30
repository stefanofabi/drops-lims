<?php

namespace App\Http\Controllers\Administrators\Summaries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;

use PDF;

class DebtSocialWorkController extends Controller
{
    //
 
    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    public function __construct (BillingPeriodRepositoryInterface $billingPeriodRepository, SocialWorkRepositoryInterface $socialWorkRepository) 
    {
        $this->billingPeriodRepository = $billingPeriodRepository;
        $this->socialWorkRepository = $socialWorkRepository;
    }

    public function index()
    {
        $social_works = $this->socialWorkRepository->all();

        return view('administrators.summaries.debt_social_works')
            ->with('social_works', $social_works);
    }
    
    /**
     * Generate a summary on the debt of social works
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateSummary(Request $request)
    {
        //

        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);
        $social_work = $this->socialWorkRepository->findOrFail($request->social_work_id);

        $billing_periods = $this->billingPeriodRepository->getAmountBilledByPeriod($social_work->id, $start_billing_period->start_date, $end_billing_period->end_date);

        $pdf = PDF::loadView('pdf/summaries/debt_social_works', [
            'billing_periods' => $billing_periods,
            'social_work' => $social_work,
            'start_date' => $start_billing_period->start_date,
            'end_date' => $end_billing_period->end_date,
        ]);

        return $pdf->stream('debt_social_works');
    }
}