<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Models\Report;

use Lang;

class ReportController extends Controller
{

    /** @var \App\Laboratory\Repositories\Determinations\DeterminationRepositoryInterface */
    private $determinationRepository;

    public function __construct(DeterminationRepositoryInterface $determinationRepository)
    {
        $this->determinationRepository = $determinationRepository;
    }

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
    public function create($determination_id)
    {
        //

        $determination = $this->determinationRepository->findOrFail($determination_id);

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

        $report = new Report($request->all());

        if (!$report->save()) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([ReportController::class, 'show'], ['id' => $report->id]);
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

        return view('administrators/determinations/reports/show')->with('report', $report);
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

        return view('administrators/determinations/reports/edit')->with('report', $report);
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

        $report = Report::findOrFail($id);

        if (!$report->update($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([ReportController::class, 'show'], ['id' => $id]);
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
        
        $view = view('administrators/determinations/edit');
        
        if ($report->delete()) {
            $view->with('success', [Lang::get('reports.success_destroy')]);
        } else {
            $view->withErrors(Lang::get('reports.danger_destroy'));
        }


        return $view->with('determination', $determination);
    }
}
