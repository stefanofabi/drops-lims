<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Contracts\Repository\PatientRepositoryInterface;
use App\Contracts\Repository\EmailRepositoryInterface;

use Lang;

class EmailController extends Controller
{

    private const ATTRIBUTES = [
        'patient_id',
        'email',
    ];

    /** @var \App\Contracts\Repository\PatientRepositoryInterface */
    private $patientRepository;

    /** @var \App\Contracts\Repository\EmailRepositoryInterface */
    private $emailRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository,
        EmailRepositoryInterface $emailRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->emailRepository = $emailRepository;
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

        return view('administrators/patients/emails/create')
            ->with('patient', $this->patientRepository->findOrFail($patient_id));
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
            'email' => 'required|email',
        ]);
          
        if (! $this->emailRepository->create($request->only(self::ATTRIBUTES))) {
            return back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
        }
      
        return redirect()->action([PatientController::class,'edit'], ['id' => $request->patient_id]);
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
            $email = $this->emailRepository->findOrFail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => Lang::get('errors.not_found')], 404);
        }

        return response()->json([
            'id' => $email->id,
            'email' => $email->email,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            if (! $this->emailRepository->update($request->only(self::ATTRIBUTES), $request->id)) {
                return response(['message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (QueryException $exception) {
            return response()->json(['message' => Lang::get('errors.error_processing_transaction')], 500);
        }

        return response(['message' => Lang::get('forms.successful_transaction')], 200);
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

        if (! $this->emailRepository->delete($request->id)) {
            return response(['message' => Lang::get('forms.failed_transaction')], 500);
        }
     
        return response(['message' => Lang::get('forms.successful_transaction')], 200);
    }
}
