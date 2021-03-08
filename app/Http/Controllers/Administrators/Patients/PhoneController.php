<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Laboratory\Repositories\Patients\PatientRepositoryInterface;

use App\Models\Phone;

use Lang;

class PhoneController extends Controller
{

    /** @var \App\Laboratory\Repositories\Patients\PatientRepositoryInterface */
    private $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
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
    public function create($patient_id)
    {
        //

        return view('administrators/patients/phones/create')->with('patient', $this->patientRepository->findOrFail($patient_id));
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
            'phone' => 'required|string',
            'type' => 'required|string',
        ]);

        $phone = new Phone($request->all());

        try {
            if ($phone->save()) {
                $redirect = redirect()->action([PatientController::class, 'edit'], ['id' => $request->patient_id]);
            } else {
                $redirect = redirect()->back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //

        try {
            $phone = Phone::findOrFail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], 500);
        }

        return response()->json($phone, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $request->validate([
            'phone' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            $phone = Phone::findOrFail($request->id);

            if (! $phone->update($request->all())) {
                return response()->json(['status' => 500, 'message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => Lang::get('errors.error_processing_transaction'),
            ], 500);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], 500);
        }

        return response()->json(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        try {
            $phone = Phone::findOrFail($request->id);

            if (! $phone->delete()) {
                return response()->json(['status' => 500, 'message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => Lang::get('errors.error_processing_transaction'),
            ], 500);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], 500);
        }

        return response()->json(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
    }
}
