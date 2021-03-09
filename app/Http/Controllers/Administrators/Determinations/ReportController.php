<?php

namespace App\Http\Controllers\Administrators\Determinations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\DeterminationRepositoryInterface;
use App\Contracts\Repository\ReportRepositoryInterface;

use Lang;

class ReportController extends Controller
{

    /** @var \App\Laboratory\Repositories\Determinations\DeterminationRepositoryInterface */
    private $determinationRepository;

    /** @var \App\Laboratory\Repositories\Determinations\ReportRepositoryInterface */
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

        if (! $report = $this->reportRepository->create($request->all())) {
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

        $report = $this->reportRepository->findOrFail($id);

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

        if (! $this->reportRepository->update($request->except(['_token', '_method']), $id)) {
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

        $report = $this->reportRepository->findOrFail($id);
        $determination = $report->determination;
        
        if (!$report->delete($id)) {
            return back()->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([DeterminationController::class, 'edit'], ['id' => $determination->id]);
    }
}
