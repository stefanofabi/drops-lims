<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\PhoneRepositoryInterface;

use Lang;

class PhoneController extends Controller
{
    private const ATTRIBUTES = [
        'patient_id',
        'phone',
        'type',
    ];

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $phoneRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository,
        PhoneRepositoryInterface $phoneRepository,
    ) {
        $this->patientRepository = $patientRepository;
        $this->phoneRepository = $phoneRepository;
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

        if (! $this->phoneRepository->create($request->only(self::ATTRIBUTES))) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }

        return redirect()->action([PatientController::class, 'edit'], ['id' => $request->patient_id]);
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
            $phone = $this->phoneRepository->findOrFail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => Lang::get('errors.not_found')], 404);
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
            if (! $this->phoneRepository->update($request->only(self::ATTRIBUTES), $request->id)) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $exception) {
            return response()->json(['message' => Lang::get('errors.error_processing_transaction')], 500);
        }

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
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
            if (! $this->phoneRepository->delete($request->id)) {
                return response()->json(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $exception) {
            return response()->json(['message' => Lang::get('errors.error_processing_transaction')], 500);
        }

        return response()->json(['message' => Lang::get('forms.successful_transaction')], 200);
    }
}
