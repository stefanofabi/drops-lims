<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Contracts\Repository\ProtocolRepositoryInterface;

use App\Models\Practice;
use App\Models\Report;
use App\Models\Result;
use App\Models\SignPractice;

use Lang;

class PracticeController extends Controller
{
    /** @var \App\Laboratory\Repositories\Protocols\ProtocolRepositoryInterface */
    private $protocolRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository
    ) {
        $this->protocolRepository = $protocolRepository;
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

        $request->validate([
            'type' => 'in:our,derived',
        ]);

        DB::beginTransaction();

        try {

            $report_id = $request->report_id;
            $report = Report::findOrFail($report_id);
            $determination = $report->determination;
            $biochemical_unit = $determination->biochemical_unit;
            $protocol_id = $request->protocol_id;
            $type = $request->type;

            switch ($type) {
                case 'our':
                {
                    $protocol = $this->protocolRepository->findOrFail($protocol_id);
                    $plan = $protocol->plan;
                    $nbu_price = $plan->nbu_price;
                    $amount = $nbu_price * $biochemical_unit;

                    break;
                }

                case 'derived':
                {

                }
            }

            $practice = new Practice([
                'protocol_id' => $protocol_id,
                'report_id' => $report_id,
                'amount' => $amount,
            ]);

            if (! $practice->save()) {
                return response()->json(['status' => 500, 'message' => Lang::get('forms.failed_transaction')], 500);
            }

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => Lang::get('errors.error_processing_transaction'),
            ], 500);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();

            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], 500);
        }

        return response()->json(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
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

        $practice = Practice::findOrFail($id);

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
        $nomenclator_id = $request->nomenclator_id;
        $filter = $request->filter;

        $reports = DB::table('reports')
            ->select('reports.id', DB::raw("CONCAT(determinations.name, ' - ', reports.name) as label"))
            ->join('determinations', 'determinations.id', '=', 'reports.determination_id')
            ->where('determinations.nomenclator_id', $nomenclator_id)
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("determinations.name", "like", "%$filter%")
                        ->orWhere("determinations.code", "like", "$filter%")
                        ->orWhere("reports.name", "like", "%$filter%");
                }
            })
            ->get()
            ->toJson();

        return $reports;
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
        $practice = Practice::findOrFail($practice_id);

        return $practice->results->toArray();
    }
}
