<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Contracts\Repository\SocialWorkRepositoryInterface;
use App\Contracts\Repository\ProtocolRepositoryInterface;

use Lang;
use DateTime;

class StatisticsController extends Controller
{
    //

    /** @var \App\Contracts\Repository\SocialWorkRepositoryInterface */
    private $socialWorkRepository;

    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    public function __construct(
        SocialWorkRepositoryInterface $socialWorkRepository,
        ProtocolRepositoryInterface $protocolRepository

    ) {
        $this->socialWorkRepository = $socialWorkRepository;
        $this->protocolRepository = $protocolRepository;
    }

    public function index()
    {
        $social_works = $this->socialWorkRepository->all();
        $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        $ended_date = date('Y-m-d');

        return view('administrators.settings.statistics.index')
            ->with('social_works', $social_works)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date);
    }

    public function getAnnualCollectionSocialWork(Request $request)
    {

        $social_works = $this->socialWorkRepository->all();

        $anual_report = $this->protocolRepository->getCollectionSocialWork($request->social_work, $request->initial_date, $request->ended_date);
        
        $new_array = $this->generate_array_per_month($anual_report, $request->initial_date, $request->ended_date);
       
        return view('administrators.settings.statistics.annual_collection_social_work')
            ->with('social_works', $social_works)
            ->with('social_work', $request->social_work)
            ->with('initial_date', $request->initial_date)
            ->with('ended_date', $request->ended_date)
            ->with('data', $new_array);
    }

    public function getPatientFlowPerMonth(Request $request)
    {

        $social_works = $this->socialWorkRepository->all();

        $patient_flow = $this->protocolRepository->getPatientFlow($request->initial_date, $request->ended_date);

        $new_array = $this->generate_array_per_month($patient_flow, $request->initial_date, $request->ended_date);

        return view('administrators.settings.statistics.patient_flow_per_month')
            ->with('social_works', $social_works)
            ->with('initial_date', $request->initial_date)
            ->with('ended_date', $request->ended_date)
            ->with('data', $new_array);
    }

    public function getTrackIncome(Request $request)
    {
        $social_works = $this->socialWorkRepository->all();

        $track_income = $this->protocolRepository->getTrackIncome($request->initial_date, $request->ended_date);

        $new_array = $this->generate_array_per_month($track_income, $request->initial_date, $request->ended_date);

        return view('administrators.settings.statistics.track_income')
            ->with('social_works', $social_works)
            ->with('initial_date', $request->initial_date)
            ->with('ended_date', $request->ended_date)
            ->with('data', $new_array);
    }

    private function generate_array_per_month($array, $start_date, $end_date)
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

        switch ($month) {
            case 1:
            {
                $month_value = Lang::get('months.january');
                break;
            }

            case 2:
            {
                $month_value = Lang::get('months.february');
                break;
            }

            case 3:
            {
                $month_value = Lang::get('months.march');
                break;
            }

            case 4:
            {
                $month_value = Lang::get('months.april');
                break;
            }

            case 5:
            {
                $month_value = Lang::get('months.may');
                break;
            }

            case 6:
            {
                $month_value = Lang::get('months.june');
                break;
            }

            case 7:
            {
                $month_value = Lang::get('months.july');
                break;
            }

            case 8:
            {
                $month_value = Lang::get('months.august');
                break;
            }

            case 9:
            {
                $month_value = Lang::get('months.september');
                break;
            }

            case 10:
            {
                $month_value = Lang::get('months.october');
                break;
            }

            case 11:
            {
                $month_value = Lang::get('months.november');
                break;
            }

            case 12:
            {
                $month_value = Lang::get('months.december');
                break;
            }

            default:
            {
                $month_value = "Error";
                break;
            }
        }

        return $month_value;
    }
}
