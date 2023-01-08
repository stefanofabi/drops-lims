<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\InternalProtocolRepositoryInterface;

use Lang;
use DateTime;

class StatisticsController extends Controller
{
    //

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    public function __construct(
        SocialWorkRepositoryInterface $socialWorkRepository,
        InternalProtocolRepositoryInterface $internalProtocolRepository

    ) {
        $this->socialWorkRepository = $socialWorkRepository;
        $this->internalProtocolRepository = $internalProtocolRepository;
    }

    public function index()
    {
        $social_works = $this->socialWorkRepository->all();
        $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        $ended_date = date('Y-m-d');

        return view('administrators.statistics.index')
            ->with('social_works', $social_works)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date);
    }

    public function getAnnualCollectionSocialWork(Request $request)
    {
        
        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
            'social_work' => 'required|numeric|min:1',
        ]);

        $social_works = $this->socialWorkRepository->all();

        $anual_report = $this->internalProtocolRepository->getCollectionSocialWork($request->social_work, $request->initial_date, $request->ended_date);
       
        $new_array = $this->generateArrayPerMonth($anual_report, $request->initial_date, $request->ended_date);
       
        return view('administrators.statistics.annual_collection_social_work')
            ->with('social_works', $social_works)
            ->with('social_work', $request->social_work)
            ->with('initial_date', $request->initial_date)
            ->with('ended_date', $request->ended_date)
            ->with('data', $new_array);
    }

    public function getPatientFlowPerMonth(Request $request)
    {
        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);

        $social_works = $this->socialWorkRepository->all();

        $patient_flow = $this->internalProtocolRepository->getPatientFlow($request->initial_date, $request->ended_date);

        $new_array = $this->generateArrayPerMonth($patient_flow, $request->initial_date, $request->ended_date);

        return view('administrators.statistics.patient_flow_per_month')
            ->with('social_works', $social_works)
            ->with('initial_date', $request->initial_date)
            ->with('ended_date', $request->ended_date)
            ->with('data', $new_array);
    }

    public function getTrackIncome(Request $request)
    {
        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);

        $social_works = $this->socialWorkRepository->all();

        $track_income = $this->internalProtocolRepository->getTrackIncome($request->initial_date, $request->ended_date);

        $new_array = $this->generateArrayPerMonth($track_income, $request->initial_date, $request->ended_date);

        return view('administrators.statistics.track_income')
            ->with('social_works', $social_works)
            ->with('initial_date', $request->initial_date)
            ->with('ended_date', $request->ended_date)
            ->with('data', $new_array);
    }

    private function generateArrayPerMonth($array, $start_date, $end_date)
    {
        /*
        It is the only solution I found without having to create a temporary table to be able to group all the months one by one
        */

        $new_array = [];
        $count = count($array);
        $pos = 0;
        
        $start_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);

        while ($start_date <= $end_date) {

            $month = intval($start_date->format('m'));
            $year = intval($start_date->format('Y'));

            // The month stored in the array is consecutive
            if ($pos < $count && $month == intval($array[$pos]['month']) && $year == intval($array[$pos]['year'])) {
                $m = intval($array[$pos]['month']);
                $y = intval($array[$pos]['year']);
                $value = $this->getMonth($m)." ".$y;
                $total_amount = intval($array[$pos]['total']);

                $new_array[] = [
                    'value' => $value,
                    'total' => $total_amount,
                ];

                $pos++;
            } else {
                // As no data was obtained this month we will save it with a null value
                $new_array[] = [
                    'value' => $this->getMonth($month)." ".$year,
                    'total' => 0,
                ];
            }

            // This prevents errors to the increase the month
            $start_date->modify('first day of next month');
        }

        return $new_array;
    }

    private function getMonth($month)
    {

        $months = [
            Lang::get('months.january'),
            Lang::get('months.february'),
            Lang::get('months.march'),
            Lang::get('months.april'),
            Lang::get('months.may'),
            Lang::get('months.june'),
            Lang::get('months.july'),
            Lang::get('months.august'),
            Lang::get('months.september'),
            Lang::get('months.october'),
            Lang::get('months.november'),
            Lang::get('months.december'),
            Lang::get('months.march')

        ];

        return $months[$month];
    }
}
