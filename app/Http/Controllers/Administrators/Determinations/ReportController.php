<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Determination;
use App\Models\Report;

use Lang;

class ReportController extends Controller
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
    public function create($id)
    {
        //

        $determination = Determination::findOrFail($id);

        return view('administrators/determinations/reports/create')->with('determination', $determination);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'string|nullable',
            'report' => 'string|nullable',
            'determination_id' => 'required|numeric|min:1',
        ]);

        try {
            $report = new Report($request->all());

            if ($report->save()) {
                $redirect = redirect()->action([ReportController::class, 'show'], [$report]);
            } else {
                $redirect = back()->withInput($request->all())->withErrors(Lang::get('determinations.error_saving_report'));
            }
        } catch (QueryException $e) {
            $redirect = back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return $redirect;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $report = Report::findOrFail($id);
        $determination = $report->determination;

        return view('administrators/determinations/reports/show')->with('report', $report)->with('determination', $determination);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $report = Report::findOrFail($id);
        $determination = $report->determination;

        return view('administrators/determinations/reports/edit')->with('report', $report)->with('determination', $determination);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        try {
            $report = Report::findOrFail($id);

            /* To maintain the integrity in the printing of the protocols I will apply it in a transaction */
            DB::beginTransaction();

            if ($report->update($request->all())) {
                $redirect = redirect()->action([ReportController::class, 'show'], [$id]);
            } else {
                $redirect = back()->withInput($request->all())->withErrors(Lang::get('determinations.error_updating_determination'));
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            $redirect = back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $report = Report::findOrFail($id);
        $determination = $report->determination;
        $nomenclator = $determination->nomenclator;

        $view = view('administrators/determinations/edit')->with('determination', $determination)->with('nomenclator', $nomenclator);

        if ($report->delete()) {
            $view->with('success', [Lang::get('reports.success_destroy')]);
        } else {
            $view->withErrors(Lang::get('reports.danger_destroy'));
        }

        $reports = $determination->reports;

        return $view->with('reports', $reports);
    }
}
