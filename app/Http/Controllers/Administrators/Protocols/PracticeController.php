<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

use App\Contracts\Repository\PracticeRepositoryInterface;
use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\ReportRepositoryInterface;
use App\Contracts\Repository\ResultRepositoryInterface;
use App\Contracts\Repository\SignPracticeRepositoryInterface;

use Lang;
use Throwable;

class PracticeController extends Controller
{

    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\ReportRepositoryInterface */
    private $reportRepository;

    /** @var \App\Contracts\Repository\ResultRepositoryInterface */
    private $resultRepository;

    /** @var \App\Contracts\Repository\SignPracticeRepositoryInterface */
    private $signPracticeRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository,
        ReportRepositoryInterface $reportRepository,
        PracticeRepositoryInterface $practiceRepository,
        ResultRepositoryInterface $resultRepository,
        SignPracticeRepositoryInterface $signPracticeRepository
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->reportRepository = $reportRepository;
        $this->practiceRepository = $practiceRepository;
        $this->resultRepository = $resultRepository;
        $this->signPracticeRepository = $signPracticeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $protocol = $this->protocolRepository->findOrFail($request->protocol_id);

        switch ($protocol->type)
        {
            case 'our': {
                $view = view('administrators/protocols/our/practices/index')
                    ->with('protocol', $protocol);

                break;
            }

            case 'derived': {
                new \Exception("Path for derived protocols not implemented");

                break;
            }
        }

        return $view;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        try  {

            $report = $this->reportRepository->findOrFail($request->report_id);

            $protocol = $this->protocolRepository->findOrFail($request->protocol_id);

            $amount = $this->practiceRepository->getPracticePrice($report, $protocol);

            if (! $this->practiceRepository->create([
                'report_id' => $report->id,
                'protocol_id' => $protocol->id,
                'amount' => $amount,
            ])) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => Lang::get('errors.not_found')], 404);
        } catch (QueryException $exception) {
            return response()->json(['message' => Lang::get('errors.error_processing_transaction')], 500);
        }
        
        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
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

        $practice = $this->practiceRepository->findOrFail($id);

        switch ($practice->protocol->type)
        {
            case 'our': {
                $view = view('administrators/protocols/our/practices/edit');

                break;
            }

            case 'derived': {
                new \Exception("Path for derived protocols not implemented");

                break;
            }
        }

        return $view
            ->with('practice', $practice);
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
    }

    /**
     * Sign the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sign(Request $request, $id)
    {
        //

        try {
            if (! $this->signPracticeRepository->create(['practice_id' => $id, 'user_id' => auth()->user()->id])) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $exception) {
            // the user had already signed the practice

            return response()->json(['message' => Lang::get('protocols.already_signed')], 200);
        }

        return response()->json(['message' => Lang::get('protocols.success_signed')], 200);
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
        
        $protocol = $this->practiceRepository->findOrFail($id)->protocol;

        if (! $this->practiceRepository->delete($id)) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([PracticeController::class, 'index'], ['protocol_id' => $protocol->id]);
    }

    /**
     * Returns a list of practice reports available according to the nomenclator of social work
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function loadPractices(Request $request)
    {
        //

        $request->validate([
            'nomenclator_id' => 'required|numeric|min:1',
            'filter' => 'required|string',
        ]);

        return $this->reportRepository->getReportsFromNomenclator($request->nomenclator_id, $request->filter);
    }

    /**
     * Returns the results for a practice
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getResults(Request $request)
    {
        //
        
        $practice = $this->practiceRepository->findOrFail($request->practice_id);

        return $practice->results->toArray();
    }

    /**
     * Inform the results of a practice
     *
     * @param \Illuminate\Http\Request $request
     * @param int $practice_id
     * @return \Illuminate\Http\Response
     */
    public function informResults(Request $request, $practice_id)
    {
        
        DB::beginTransaction();
        
        try {
            $this->signPracticeRepository->deleteAllSignatures($practice_id);
            
            $this->resultRepository->deleteAllResults($practice_id);

            // AJAX dont send empty arrays
            if (is_array($request->data)) {
                foreach ($request->data as $result) {
                    $this->resultRepository->create(['practice_id' => $practice_id, 'result' => $result]);
                }
            }

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            
            return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
        }

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
    }
}
