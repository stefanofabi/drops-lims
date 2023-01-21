<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\BillingPeriodRepositoryInterface;

class CollectionSocialWorkController extends Controller
{
    //

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Contracts\Repository\BillingPeriodRepositoryInterface */
    private $billingPeriodRepository;

    public function __construct(
        SocialWorkRepositoryInterface $socialWorkRepository,
        BillingPeriodRepositoryInterface $billingPeriodRepository

    ) {
        $this->socialWorkRepository = $socialWorkRepository;
        $this->billingPeriodRepository = $billingPeriodRepository;
    }

    public function index()
    {
        $social_works = $this->socialWorkRepository->all();

        return view('administrators.statistics.collection_social_work')
            ->with('social_works', $social_works);
    }

    public function generateChart(Request $request)
    {
        $request->validate([
            'social_work' => 'required|numeric|min:1',
        ]);

        $social_work = $this->socialWorkRepository->findOrFail($request->social_work);
        $start_billing_period = $this->billingPeriodRepository->findOrFail($request->start_billing_period_id);
        $end_billing_period = $this->billingPeriodRepository->findOrFail($request->end_billing_period_id);

        $social_works = $this->socialWorkRepository->all();
        
        $collect_social_work = $this->billingPeriodRepository->getCollectionSocialWork($request->social_work, $start_billing_period->start_date, $end_billing_period->end_date);
    
        return view('administrators.statistics.collection_social_work')
            ->with('social_works', $social_works)
            ->with('social_work', $social_work)
            ->with('start_billing_period', $start_billing_period)
            ->with('end_billing_period', $end_billing_period)
            ->with('collect_social_work', $collect_social_work);
    }
}
