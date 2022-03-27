<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Contracts\Repository\ReportRepositoryInterface;

use Lang;
use Session; 

class ReportController extends Controller
{

    /** @var \App\Contracts\Repository\DeterminationRepositoryInterface */
    private $determinationRepository;

    /** @var \App\Contracts\Repository\ReportRepositoryInterface */
    private $reportRepository;

    public function __construct(
        DeterminationRepositoryInterface $determinationRepository,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->determinationRepository = $determinationRepository;
        $this->reportRepository = $reportRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $determination = $this->determinationRepository->findOrFail($request->determination_id);

        $reports = $determination->reports;

        return view('administrators/determinations/reports/index')
            ->with('determination', $determination)
            ->with('reports', $reports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $determination = $this->determinationRepository->findOrFail($request->determination_id);

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
            'name' => 'required|string|nullable',
            'report' => 'string|nullable',
            'determination_id' => 'required|numeric|min:1',
        ]);

        if (! $report = $this->reportRepository->create($request->all())) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([ReportController::class, 'edit'], ['id' => $report->id]);
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

        $report = $this->reportRepository->findOrFail($id);

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

        if (! $this->reportRepository->update($request->all(), $id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([ReportController::class, 'edit'], ['id' => $id]);
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

        $determination_id = $this->reportRepository->findOrFail($id)->determination_id;
        
        if (! $this->reportRepository->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        Session::flash('success', [Lang::get('reports.success_destroy')]);

        return redirect()->action([ReportController::class, 'index'], ['determination_id' => $determination_id]);
    }
}
