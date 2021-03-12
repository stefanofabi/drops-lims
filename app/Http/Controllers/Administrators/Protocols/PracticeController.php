<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\ReportRepositoryInterface;
use App\Contracts\Repository\PracticeRepositoryInterface;

use App\Models\Result;
use App\Models\SignPractice;

use Lang;

class PracticeController extends Controller
{

    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\ReportRepositoryInterface */
    private $reportRepository;

    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository,
        ReportRepositoryInterface $reportRepository,
        PracticeRepositoryInterface $practiceRepository
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->reportRepository = $reportRepository;
        $this->practiceRepository = $practiceRepository;
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

        return view('administrators/protocols/practices/edit')->with('practice', $practice);
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

        DB::beginTransaction();

        try {

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

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['status' => 500, 'message' => Lang::get('forms.failed_transaction')], 500);
        }

        return response()->json(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
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

            $signed = new SignPractice([
                'practice_id' => $id,
                'user_id' => auth()->user()->id,
            ]);

            if (! $signed->save()) {
                return response()->json(['status' => 500, 'message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $e) {
            // the user had already signed the practice

            return response()->json(['status' => 200, 'message' => Lang::get('protocols.already_signed')], 200);
        }

        return response()->json(['status' => 200, 'message' => Lang::get('protocols.success_signed')], 200);
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
    }

    /**
     * Returns a list of practice reports available according to the nomenclator of social work
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function load_practices(Request $request)
    {
        //

        return $this->reportRepository->getReportsFromNomenclator($request->nomenclator_id, $request->filter);
    }

    /**
     * Returns the results for a practice
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function get_results(Request $request)
    {
        //
        $practice_id = $request->practice_id;
        $practice = $this->practiceRepository->findOrFail($practice_id);

        return $practice->results->toArray();
    }
}
