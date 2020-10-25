<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Practice;
use App\Models\Report;
use App\Models\OurProtocol;
use App\Models\Result;

class PracticeController extends Controller
{

    private const RETRIES = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        DB::transaction(function () use ($request) {

            $report_id = $request->report_id;
            $report = Report::findOrFail($report_id);
            $determination = $report->determination;
            $biochemical_unit = $determination->biochemical_unit;
            $protocol_id = $request->protocol_id;
            $type = $request->type;

            switch ($type) {
                case 'our': {
                    $protocol = OurProtocol::findOrFail($protocol_id);
                    $plan = $protocol->plan->first();
                    $nbu_price = $plan->nbu_price;
                    $amount = $nbu_price * $biochemical_unit;
                }

                case 'derived': {

                }
            }


            Practice::insert([
                'protocol_id' => $protocol_id,
                'report_id' => $report_id,
                'amount' => $amount
            ]);

        }, self::RETRIES);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $practice = Practice::findOrFail($id);
        $report = $practice->report()->first();
        $determination = $report->determination()->first();

        return view('administrators/protocols/practices/edit')
        ->with('practice', $practice)
        ->with('report', $report)
        ->with('determination', $determination);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


         DB::transaction(function () use ($request, $id) {

            Result::where('practice_id', $id)->delete();

            if (isset($request->data)) {
            	// ajax does not send empty arrays

	            $array = $request->data;

	            foreach ($array as $data) {
	                Result::insert([
	                    'practice_id' => $id,
	                    'result' => $data,
	                ]);
	            }
            }
        }, self::RETRIES);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Returns a list of practices available according to the nomenclator of social work
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function load(Request $request)
    {
        //
        $nomenclator = $request->nomenclator_id;
        $filter = $request->filter;

        $practices = Report::select('reports.id', DB::raw("CONCAT(determinations.name, ' - ', reports.name) as label"))
        ->determination()
        ->where('determinations.nomenclator_id', $nomenclator)
        ->where(function ($query) use ($filter) {
            if (!empty($filter)) {
                $query->orWhere("determinations.name", "like", "%$filter%")
                ->orWhere("determinations.code", "like", "$filter%")
                ->orWhere("reports.name", "like", "%$filter%");
            }
        })
        ->get()
        ->toJson();

        return $practices;
    }

    /**
     * Returns the results for a practice
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_results(Request $request)
    {
        //
        $practice_id = $request->practice_id;
        $practice = Practice::findOrFail($practice_id);

        return $practice->results->toArray();
    }
}
