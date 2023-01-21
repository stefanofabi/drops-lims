<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;

class SocialWorkCompositionController extends Controller
{
    //

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    public function __construct (SocialWorkRepositoryInterface $socialWorkRepository) 
    {
        $this->socialWorkRepository = $socialWorkRepository;
    }

    public function index()
    {
        return view('administrators.statistics.social_work_composition');
    }

    public function generateChart(Request $request)
    {

        $social_work_composition = $this->socialWorkRepository->getSocialWorkComposition();

        return view('administrators.statistics.social_work_composition')
            ->with('social_work_composition', $social_work_composition);
    }
}
