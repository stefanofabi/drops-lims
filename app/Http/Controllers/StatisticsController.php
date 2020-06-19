<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\OurProtocol;
use App\SocialWork;

use Lang;

class StatisticsController extends Controller
{
    //

    public function index() {
        $social_works = SocialWork::all();
        $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        $ended_date = date('Y-m-d');

    	return view('administrators/statistics/index')
        ->with('social_works', $social_works)
        ->with('initial_date', $initial_date)
        ->with('ended_date', $ended_date);
    }

    public function annual_collection_social_work(Request $request) {

        $social_works = SocialWork::all();
        $social_work = $request->social_work;
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

    	$anual_report = OurProtocol::select(DB::raw("month(protocols.completion_date) as month"), DB::raw("DATE_FORMAT(protocols.completion_date,'%Y') as year"), DB::raw('SUM(practices.amount) as total_amount'))
    	->protocol()
    	->plan()
    	->social_work()
    	->practices()
        ->where('social_works.id', $social_work)
        ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
    	->groupBy('social_works.id', 'social_works.name', DB::raw("DATE_FORMAT(protocols.completion_date,'%M %Y')"), DB::raw("MONTH(protocols.completion_date)"), DB::raw("DATE_FORMAT(protocols.completion_date,'%Y')"))
        ->orderBy('protocols.completion_date', 'asc')
    	->get()
    	->toArray();

    	$new_array = array();
    	$count = count($anual_report);
    	$pos = 0;
        $date = $initial_date;

        $month = intval(date('m', strtotime($initial_date)));
        $year = intval(date('Y', strtotime($initial_date)));

        $month_end = intval(date('m', strtotime($ended_date)));
        $year_end = intval(date('Y', strtotime($ended_date)));

        /*
		It is the only solution I found without having to create a temporary table to be able to group all the months one by one
        */
        
    	while ($month <= $month_end && $year <= $year_end) {

            if ($pos < $count && $month == intval($anual_report[$pos]['month']) && $year == intval($anual_report[$pos]['year'])) {
                $m = intval($anual_report[$pos]['month']);
                $y = intval($anual_report[$pos]['year']);
                $value = $this->get_month($m)." ".$y;
                $total_amount = intval($anual_report[$pos]['total_amount']);

	    		$new_array[] = array(
	    							'month' => $m,
	    							'year' => $y,
	    							'value' => $value,
	    							'total_amount' => $total_amount
	    						);	

	    		$pos++;
            } else {
	    		$new_array[] = array(
	    							'month' => $month,
	    							'year' => $year,
	    							'value' => $this->get_month($month)." ".$year,
	    							'total_amount' => 0
	    						);	
            }

            
    		$date = date('Y-m-d', strtotime($date."+ 1 month"));
    		$month = intval(date('m', strtotime($date)));
            $year = intval(date('Y', strtotime($date)));
    	}

    	
     	return view('administrators/statistics/annual_collection_social_work')
        ->with('social_works', $social_works)
        ->with('social_work', $social_work)
        ->with('initial_date', $initial_date)
        ->with('ended_date', $ended_date)
        ->with('data', $new_array);

    }

    public function patient_flow_per_month(Request $request) {

        $social_works = SocialWork::all();
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $patient_flow = OurProtocol::select(DB::raw('COUNT(*) as total_patient'), DB::raw("DATE_FORMAT(protocols.completion_date,'%M %Y') as month"))
        ->protocol()
        ->patient()
        ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
        ->groupBy(DB::raw("DATE_FORMAT(protocols.completion_date,'%M %Y')"))
        ->orderBy('protocols.completion_date', 'asc')
        ->get();

        return view('administrators/statistics/patient_flow_per_month')
        ->with('social_works', $social_works)
        ->with('initial_date', $initial_date)
        ->with('ended_date', $ended_date)
        ->with('data', $patient_flow);
    }

    public function get_month($month) {

        switch($month) {
            case 1: {
                $month_value = \Lang::get('months.january');
                break;
            }

            case 2: {
                $month_value = \Lang::get('months.february');
                break;
            }

            case 3: {
                $month_value = \Lang::get('months.march');
                break;
            }

            case 4: {
                $month_value = \Lang::get('months.april');
                break;
            }
            
            case 5: {
                $month_value = \Lang::get('months.may');
                break;
            }
            
            case 6: {
                $month_value = \Lang::get('months.june');
                break;
            }
            
            case 7: {
                $month_value = \Lang::get('months.july');
                break;
            }
            
            case 8: {
                $month_value = \Lang::get('months.august');
                break;
            }
            
            case 9: {
                $month_value = \Lang::get('months.september');
                break;
            }
            
            case 10: {
                $month_value = \Lang::get('months.october');
                break;
            }
            
            case 11: {
                $month_value = \Lang::get('months.november');
                break;
            }
            
            case 12: {
                $month_value = \Lang::get('months.december');
                break;
            }  

            default: {
                $month_value = "Error";
                break;
            }         
        }

        return $month_value;
    }

}
