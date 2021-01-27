<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use App\Models\Protocol;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
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

        $billing_periods = DB::table('social_works')
            ->select('billing_periods.name', 'billing_periods.start_date', 'billing_periods.end_date', 'social_works.name as social_work', DB::raw('SUM(practices.amount) as total_amount'))
            ->join('plans', 'social_works.id', '=', 'plans.social_work_id')
            ->join('our_protocols', 'plans.id', 'our_protocols.plan_id')
            ->join('protocols', 'our_protocols.protocol_id', '=', 'protocols.id')
            ->join('practices', 'protocols.id', '=', 'practices.protocol_id')
            ->join('billing_periods', 'our_protocols.billing_period_id', '=', 'billing_periods.id')
            ->where('billing_periods.start_date', '>=', $start_date)
            ->where('billing_periods.end_date', '<=', $end_date)
            ->groupBy('billing_periods.id', 'billing_periods.name', 'billing_periods.start_date', 'billing_periods.end_date', 'social_works.id', 'social_works.name')
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
