<?php

namespace App\Http\Controllers;

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
     * @param  \Illuminate\Http\Request  $request
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
                $redirect = redirect()->action('PatientController@edit', [$request->patient_id])
                ->with('success', [
                    Lang::get('social_works.success_saving_affiliate')
                ]);
            } else {
                $redirect = back()->withInput($request->all())
                ->withErrors(
                    Lang::get('social_works.error_saving_affiliate')
                );
            }
        } catch (QueryException $e) {
            $redirect = back()->withInput($request->all())
                ->withErrors(
                    Lang::get('errors.error_processing_transaction')
                );
        } 

    	return $redirect;        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //

        return Affiliate::select('affiliates.id', 'plans.id as plan_id', 'social_works.id as social_work_id', 'affiliates.affiliate_number', 'affiliates.security_code', 'affiliates.expiration_date')
            ->plan()
            ->socialWork()
            ->findOrFail($request->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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

        $affiliate = Affiliate::findOrFail($request->id);

        if (!$affiliate->update($request->all())) {
            return response([], 500);
        } 

        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $affiliate = Affiliate::findOrFail($request->id);

        if (!$affiliate->delete()) {
            return response([], 500);
        }

        return response([], 200);
    }

}
