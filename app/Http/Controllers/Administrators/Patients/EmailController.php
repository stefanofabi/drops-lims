<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Email;
use App\Models\Patient;

use Lang;

class EmailController extends Controller
{
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

        $patient = Patient::findOrFail($patient_id);

        return view('administrators/patients/emails/create')->with('patient', $patient);
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

        try {
            $email = new Email($request->all());

            if ($email->save()) {
                $redirect = redirect()->action([
                    PatientController::class,
                    'edit',
                ], $request->patient_id);
            } else {
                $redirect = back()->withInput($request->all())->withErrors(Lang::get('emails.error_saving_email'));
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
            $email = Email::findOrFail($request->id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], 500);
        }

        return response()->json($email, 200);
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
            $email = Email::findOrFail($request->id);

            if (! $email->update($request->all())) {
                return response(['status' => 500, 'message' => Lang::get('forms.failed_transaction')], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 500,
                'message' => Lang::get('errors.error_processing_transaction'),
            ], 500);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => Lang::get('errors.error_processing_transaction'),
            ], 500);
        }

        return response(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
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
            $email = Email::findOrFail($request->id);

            if (! $email->delete()) {
                return response([], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 500,
                'message' => Lang::get('errors.error_processing_transaction'),
            ], 500);
        }

        return response(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
    }
}
