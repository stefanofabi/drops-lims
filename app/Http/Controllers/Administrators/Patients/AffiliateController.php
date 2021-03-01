<?php

namespace App\Http\Controllers\Administrators\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\SocialWork;
use App\Models\Affiliate;
use App\Models\Patient;

use Lang;

class AffiliateController extends Controller
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

        $social_works = SocialWork::all();

        return view('administrators/patients/social_works/affiliates/create')
            ->with('patient', $patient)
            ->with('social_works', $social_works);
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
            'affiliate_number' => 'string|nullable',
            'expiration_date' => 'date|nullable',
            'security_code' => 'numeric|nullable|min:0|max:999',
        ]);

        try {
            $affiliate = new Affiliate($request->all());

            if ($affiliate->save()) {
                $redirect = redirect()->action([PatientController::class, 'edit'], ['id' => $request->patient_id]);
            } else {
                $redirect = back()->withInput($request->all())->withErrors(Lang::get('forms.failed_transaction'));
            }
        } catch (QueryException $exception) {
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
            $affiliate = Affiliate::findOrFail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], '500');
        }

        return response()->json([
            'id' => $affiliate->id,
            'plan_id' => $affiliate->plan->id,
            'social_work_id' => $affiliate->plan->social_work->id,
            'affiliate_number' => $affiliate->affiliate_number,
            'security_code' => $affiliate->security_code,
            'expiration_date' => $affiliate->expiration_date,
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
            'affiliate_number' => 'string|nullable',
            'expiration_date' => 'date|nullable',
            'security_code' => 'numeric|nullable|min:0|max:999',
        ]);

        try {
            $affiliate = Affiliate::findOrFail($request->id);

            if (! $affiliate->update($request->all())) {
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
            $affiliate = Affiliate::findOrFail($request->id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 500, 'message' => Lang::get('errors.not_found')], 500);
        }

        if (!$affiliate->delete()) {
            return response()->json([
                'status' => 500,
                'message' => Lang::get('forms.failed_transaction'),
            ], 500);
        }

        return response()->json(['status' => 200, 'message' => Lang::get('forms.successful_transaction')], 200);
    }
}