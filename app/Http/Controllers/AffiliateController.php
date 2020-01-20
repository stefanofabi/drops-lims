<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\SocialWork;
use App\Affiliate;

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
    public function create($id)
    {
        //
    	$social_works = SocialWork::all();

    	return view('patients/social_works/affiliates/create')
    	->with('id', $id)
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

            // data for affiliates
    		$patient_id = $request['patient_id'];
    		$plan_id = $request['plan'];
    		$social_work_id = $request['social_work'];
    		$affiliate_number = $request['affiliate_number'];
    		$expiration_date = $request['expiration_date'];
    		$security_code = $request['security_code'];

    		$prescriber = Affiliate::insert([
    			'patient_id' => $patient_id,
    			'plan_id' => $plan_id,
    			'social_work_id' => $social_work_id,
    			'affiliate_number' => $affiliate_number,
    			'expiration_date' => $expiration_date,
    			'security_code' => $security_code,
    		]);

    	}, self::RETRIES);


    	return redirect()->action('PatientController@show', ['id' => $request['patient_id']]);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        
        return Affiliate::select('affiliates.id as id', 'plans.id as plan_id', 'social_works.id as social_work_id', 'affiliates.affiliate_number as affiliate_number', 'affiliates.security_code as security_code', 'affiliates.expiration_date as expiration_date')
        ->join('plans', 'affiliates.plan_id', '=', 'plans.id')
        ->join('social_works', 'plans.social_work_id', '=', 'social_works.id')
        ->where('affiliates.id', $request->id)
        ->get()
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
                    'social_work_id' => $request->social_work_id,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
