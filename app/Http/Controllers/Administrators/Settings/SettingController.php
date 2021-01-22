<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use App\Models\Protocol;
use Illuminate\Http\Request;

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
     * Display a end day view
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_reports()
    {
        //

        return view('administrators/settings/generate_reports');
    }

    /**
     * Display a end day view
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
     * Display a end day view
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
}
