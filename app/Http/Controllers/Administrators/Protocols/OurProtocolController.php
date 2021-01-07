<?php

namespace App\Http\Controllers\Administrators\Protocols;

use App\Http\Controllers\Controller;

use App\Laboratory\Prints\Protocols\Our\PrintProtocolContext;
use App\Laboratory\Prints\Worksheets\PrintWorksheetContext;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Patient;
use App\Models\Protocol;
use App\Models\OurProtocol;
use App\Models\Prescriber;

use Lang;

class OurProtocolController extends Controller
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
    public function create(Request $request)
    {
        //
        $patient_id = $request->patient_id;
        $patient = Patient::find($patient_id);

        if ($patient) {
            $affiliates = $patient->affiliates;
        } else {
            $affiliates = [];
        }

        return view('administrators/protocols/our/create')->with('patient', $patient)->with('affiliates', $affiliates);
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
            'completion_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $protocol = new Protocol($request->all());

            if ($protocol->save()) {
                $our_protocol = new OurProtocol($request->all());
                $our_protocol->protocol_id = $protocol->id;
                $our_protocol->save();
            }

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([OurProtocolController::class, 'show'], ['id' => $protocol->id]);
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

        $protocol = OurProtocol::findOrFail($id);

        return view('administrators/protocols/our/show')->with('protocol', $protocol);
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

        $protocol = OurProtocol::findOrFail($id);

        return view('administrators/protocols/our/edit')->with('protocol', $protocol);
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

        $request->validate([
            'completion_date' => 'required|date',
        ]);

        $our_protocol = OurProtocol::findOrFail($id);

        DB::beginTransaction();

        try {

            $our_protocol->update($request->all());

            $our_protocol->protocol->update($request->all());

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            return redirect()->back()->withInput($request->all())->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return redirect()->action([OurProtocolController::class, 'show'], ['id' => $id]);
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
     * Returns a list of filtered patients
     *
     * @return \Illuminate\Http\Response
     */
    public function load_patients(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $patients = Patient::select('full_name as label', 'id')->where(function ($query) use ($filter) {
            if (! empty($filter)) {
                $query->orWhere("full_name", "like", "%$filter%")->orWhere("key", "like", "$filter%")->orWhere("owner", "like", "%$filter%");
            }
        })->whereNull('deleted_at')->get()->toJson();

        return $patients;
    }

    /**
     * Returns a list of filtered prescribers
     *
     * @return \Illuminate\Http\Response
     */
    public function load_prescribers(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $prescribers = Prescriber::select('full_name as label', 'id')->where(function ($query) use ($filter) {
            if (! empty($filter)) {
                $query->orWhere("full_name", "like", "%$filter%")->orWhere("provincial_enrollment", "like", "$filter%")->orWhere("national_enrollment", "like", "$filter%");
            }
        })->whereNull('deleted_at')->get()->toJson();

        return $prescribers;
    }

    /**
     * Returns a view for add practices
     *
     * @return \Illuminate\Http\Response
     */
    public function add_practices($protocol_id)
    {
        $our_protocol = OurProtocol::findOrFail($protocol_id);

        return view('administrators/protocols/our/add_practices')->with('protocol', $our_protocol);
    }

    /**
     * Returns a list of practices for a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public static function get_practices($protocol_id)
    {
        $protocol = OurProtocol::findOrFail($protocol_id)->protocol;

        return $protocol->practices;
    }

    /**
     * Returns a protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_protocol($protocol_id, $filter_practices = [])
    {
        $strategy = 'modern_style';
        $strategyClass = PrintProtocolContext::STRATEGIES[$strategy];

        return (new $strategyClass)->print($protocol_id, $filter_practices);
    }

    /**
     * Returns a worksheet of protocol in pdf
     *
     * @return \Illuminate\Http\Response
     */
    public function print_worksheet($protocol_id, $filter_practices = [])
    {
        $strategy = 'simple_style';
        $strategyClass = PrintWorksheetContext::STRATEGIES[$strategy];

        return (new $strategyClass)->print($protocol_id, $filter_practices);
    }
}
