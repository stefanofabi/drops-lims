<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OurProtocol;
use App\Models\SocialWork;
use App\Models\Practice;

use Lang;

class StatisticsController extends Controller
{
    //

    public function index()
    {
        $social_works = SocialWork::all();
        $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        $ended_date = date('Y-m-d');

        return view('administrators/statistics/index')->with('social_works', $social_works)->with('initial_date', $initial_date)->with('ended_date', $ended_date);
    }

    public function annual_collection_social_work(Request $request)
    {

        $social_works = SocialWork::all();
        $social_work = $request->social_work;
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $anual_report = OurProtocol::select(DB::raw("MONTH(protocols.completion_date) as month"), DB::raw("YEAR(protocols.completion_date) as year"), DB::raw('SUM(practices.amount) as total'))
            ->protocol()
            ->plan()
            ->social_work()
            ->practices()
            ->where('social_works.id', $social_work)
            ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
            ->groupBy(DB::raw("MONTH(protocols.completion_date)"), DB::raw("YEAR(protocols.completion_date)"))
            ->orderBy('protocols.completion_date', 'asc')
            ->get()
            ->toArray();

        $new_array = $this->generate_array_per_month($anual_report, $initial_date, $ended_date);

        return view('administrators/statistics/annual_collection_social_work')->with('social_works', $social_works)->with('social_work', $social_work)->with('initial_date', $initial_date)->with('ended_date', $ended_date)->with('data', $new_array);
    }

    public function patient_flow_per_month(Request $request)
    {

        $social_works = SocialWork::all();
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $patient_flow = OurProtocol::select(DB::raw("MONTH(protocols.completion_date) as month"), DB::raw("YEAR(protocols.completion_date) as year"), DB::raw('COUNT(*) as total'))->protocol()->whereBetween('protocols.completion_date', [
            $initial_date,
            $ended_date,
        ])->groupBy(DB::raw("MONTH(protocols.completion_date)"), DB::raw("YEAR(protocols.completion_date)"))->orderBy('protocols.completion_date', 'asc')->get();

        $new_array = $this->generate_array_per_month($patient_flow, $initial_date, $ended_date);

        return view('administrators/statistics/patient_flow_per_month')->with('social_works', $social_works)->with('initial_date', $initial_date)->with('ended_date', $ended_date)->with('data', $new_array);
    }

    public function track_income(Request $request)
    {
        $social_works = SocialWork::all();
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $track_income = Practice::select(DB::raw("MONTH(protocols.completion_date) as month"), DB::raw("YEAR(protocols.completion_date) as year"), DB::raw('SUM(practices.amount) as total'))->protocol()->whereBetween('protocols.completion_date', [
            $initial_date,
            $ended_date,
        ])->groupBy(DB::raw("MONTH(protocols.completion_date)"), DB::raw("YEAR(protocols.completion_date)"), 'practices.amount')->orderBy('protocols.completion_date', 'asc')->get();

        $new_array = $this->generate_array_per_month($track_income, $initial_date, $ended_date);

        return view('administrators/statistics/track_income')->with('social_works', $social_works)->with('initial_date', $initial_date)->with('ended_date', $ended_date)->with('data', $new_array);
    }

    public function generate_array_per_month($array, $initial_date, $ended_date)
    {
        /*
        It is the only solution I found without having to create a temporary table to be able to group all the months one by one
        */

        $new_array = [];
        $count = count($array);
        $pos = 0;
        $date = $initial_date;

        $month = intval(date('m', strtotime($initial_date)));
        $year = intval(date('Y', strtotime($initial_date)));

        $month_end = intval(date('m', strtotime($ended_date)));
        $year_end = intval(date('Y', strtotime($ended_date)));

        while ($month <= $month_end && $year <= $year_end) {

            if ($pos < $count && $month == intval($array[$pos]['month']) && $year == intval($array[$pos]['year'])) {
                $m = intval($array[$pos]['month']);
                $y = intval($array[$pos]['year']);
                $value = $this->get_month($m)." ".$y;
                $total_amount = intval($array[$pos]['total']);

                $new_array[] = [
                    'value' => $value,
                    'total' => $total_amount,
                ];

                $pos++;
            } else {
                $new_array[] = [
                    'value' => $this->get_month($month)." ".$year,
                    'total' => 0,
                ];
            }

            $date = date('Y-m-d', strtotime($date."+ 1 month"));
            $month = intval(date('m', strtotime($date)));
            $year = intval(date('Y', strtotime($date)));
        }

        return $new_array;
    }

    public function get_month($month)
    {

        switch ($month) {
            case 1:
            {
                $month_value = \Lang::get('months.january');
                break;
            }

            case 2:
            {
                $month_value = \Lang::get('months.february');
                break;
            }

            case 3:
            {
                $month_value = \Lang::get('months.march');
                break;
            }

            case 4:
            {
                $month_value = \Lang::get('months.april');
                break;
            }

            case 5:
            {
                $month_value = \Lang::get('months.may');
                break;
            }

            case 6:
            {
                $month_value = \Lang::get('months.june');
                break;
            }

            case 7:
            {
                $month_value = \Lang::get('months.july');
                break;
            }

            case 8:
            {
                $month_value = \Lang::get('months.august');
                break;
            }

            case 9:
            {
                $month_value = \Lang::get('months.september');
                break;
            }

            case 10:
            {
                $month_value = \Lang::get('months.october');
                break;
            }

            case 11:
            {
                $month_value = Lang::get('months.november');
                break;
            }

            case 12:
            {
                $month_value = \Lang::get('months.december');
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
