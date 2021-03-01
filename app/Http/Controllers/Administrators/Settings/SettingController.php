<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Protocol;
use App\Models\Practice;

use PDF;

class SettingController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('administrators/settings/index');
    }

    /**
     * Display a generate reports view
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_reports()
    {
        //

        return view('administrators/settings/generate_reports/generate_reports');
    }

    /**
     * Generate a report on the created protocols
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function protocols_report(Request $request)
    {
        //

        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);

        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $protocols = Protocol::whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'ASC')
            ->get();;

        $pdf = PDF::loadView('pdf/generate_reports/protocols_report', [
            'protocols' => $protocols,
            'initial_date' => $initial_date,
            'ended_date' => $ended_date,
        ]);

        return $pdf->stream('protocols_report');
    }

    /**
     * Generate a report on the patients flow
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function patients_flow(Request $request)
    {
        //

        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);

        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $protocols = Protocol::whereBetween('completion_date', [$initial_date, $ended_date])
            ->orderBy('completion_date', 'ASC')
            ->get();

        $pdf = PDF::loadView('pdf/generate_reports/patients_flow', [
            'protocols' => $protocols,
            'initial_date' => $initial_date,
            'ended_date' => $ended_date,
        ]);

        return $pdf->stream('protocols_report');
    }

    /**
     * Generate a report on the debt of social works
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function debt_social_works(Request $request)
    {
        //

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        $practices = Practice::select('protocol_id', DB::raw('SUM(amount) as total_amount'))->groupBy('protocol_id');
        
        $billing_periods = DB::table('billing_periods')
            ->select('billing_periods.name', 'billing_periods.start_date', 'billing_periods.end_date', 'social_works.name as social_work', 'practices.total_amount', DB::raw('COALESCE(SUM(payment_social_works.amount), 0.0) as total_paid'))
            ->join('our_protocols', 'billing_periods.id', 'our_protocols.billing_period_id')
            ->join('plans', 'our_protocols.plan_id', '=', 'plans.id')
            ->join('social_works', 'plans.social_work_id', '=', 'social_works.id')
            ->leftJoin('protocols', 'our_protocols.protocol_id', '=', 'protocols.id')
            ->leftJoinSub($practices, 'practices', function ($join) {
                $join->on('protocols.id', '=', 'practices.protocol_id');
            })
            ->leftJoin('payment_social_works', 'billing_periods.id', 'payment_social_works.billing_period_id')
            ->where('billing_periods.start_date', '>=', $start_date)
            ->where('billing_periods.end_date', '<=', $end_date)
            ->groupBy('billing_periods.id', 'billing_periods.name', 'billing_periods.start_date', 'billing_periods.end_date', 'social_works.name', 'practices.total_amount')
            ->orderBy('billing_periods.start_date', 'ASC')
            ->orderBy('billing_periods.end_date', 'ASC')
            ->orderBy('social_works.name', 'ASC')
            ->get();
       
        $pdf = PDF::loadView('pdf/generate_reports/debt_social_works', [
            'billing_periods' => $billing_periods,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        return $pdf->stream('protocols_report');
    }
}
