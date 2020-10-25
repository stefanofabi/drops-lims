<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\SocialWork;
use App\Models\Affiliate;

use Lang;
use Session;

class AffiliateController extends Controller
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
    	$social_works = SocialWork::all();

    	return view('administrators/patients/social_works/affiliates/create')
    	->with('id', $request->id)
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
    	DB::transaction(function () use ($request) {

    		$prescriber = Affiliate::insert([
    			'patient_id' => $request->patient_id,
    			'plan_id' => $request->plan_id,
    			'affiliate_number' => $request->affiliate_number,
    			'expiration_date' => $request->expiration_date,
    			'security_code' => $request->security_code,
    		]);

    	}, self::RETRIES);

        Session::flash('success', [Lang::get('social_works.success_saving_affiliate')]);

    	return redirect()->action('PatientController@edit', [$request->patient_id]);
        
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
        ->where('affiliates.id', $request->id)
        ->first();
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

        DB::transaction(function () use ($request) {
           Affiliate::where('id', '=', $request->id)
            ->update(
                [
                    'plan_id' => $request->plan_id,
                    'affiliate_number' => $request->affiliate_number,
                    'security_code' => $request->security_code,
                    'expiration_date' => $request->expiration_date,
                ]);
        }, self::RETRIES);
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

        $id = $request->id;

        $affiliate = Affiliate::findOrFail($id);

        if (!$affiliate->delete()) {
            return response([], 500);
        }

        return response([], 200);
    }

}
