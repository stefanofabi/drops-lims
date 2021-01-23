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
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
        ]);

        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $social_works = DB::table('social_works')
            ->select('social_works.name as social_work', DB::raw("MONTH(protocols.completion_date) as month"), DB::raw("YEAR(protocols.completion_date) as year"), DB::raw('SUM(practices.amount) as total_amount'))
            ->join('plans', 'social_works.id', '=', 'plans.social_work_id')
            ->join('our_protocols', 'plans.id', 'our_protocols.plan_id')
            ->join('protocols', 'our_protocols.protocol_id', '=', 'protocols.id')
            ->join('practices', 'protocols.id', '=', 'practices.protocol_id')
            ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
            ->groupBy('social_works.id', 'social_works.name', DB::raw('MONTH(protocols.completion_date)'), DB::raw('YEAR(protocols.completion_date)'))
            ->orderBy('protocols.completion_date', 'ASC')
            ->orderBy('social_works.name', 'ASC')
            ->get();

        $pdf = PDF::loadView('pdf/generate_reports/debt_social_works', [
            'social_works' => $social_works,
            'initial_date' => $initial_date,
            'ended_date' => $ended_date,
        ]);

        return $pdf->stream('protocols_report');
    }
}
