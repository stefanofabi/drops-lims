<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Patient;
use App\Affiliate;
use App\Protocol;
use App\OurProtocol;

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
        $social_works = Affiliate::select('social_works.id as id', 'social_works.name as name', 'affiliate_number', 'expiration_date')
        ->join('social_works', 'affiliates.social_work_id', '=', 'social_works.id')
        ->where('patient_id', $patient_id)->get();

        return view('protocols/our/create')
        ->with('social_works', $social_works)
        ->with('patient', $patient);
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
        $id = DB::transaction(function () use ($request) {

            $protocol = Protocol::insertGetId([
                'completion_date' => $request->completion_date, 
                'observations' => $request->observations,
            ]);

            OurProtocol::insert([
            	'protocol_id' => $protocol,
                'patient_id' => $request->patient_id, 
                'social_work_id' => $request->social_work_id,
                'quantity_orders' => $request->quantity_orders,
                'diagnostic' => $request->diagnostic,
            ]);

            return $protocol;
        }, self::RETRIES);


        return redirect()->action('OurProtocolController@show', ['id' => $id]);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
