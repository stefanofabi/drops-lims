<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Patient;
use App\Affiliate;
use App\Protocol;
use App\OurProtocol;
use App\SocialWork;
use App\Prescriber;
use App\Practice;

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
                'prescriber_id' => $request->prescriber_id,
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
        $protocol = Protocol::select('protocols.id', 'patients.full_name', 'our_protocols.social_work_id', 'protocols.completion_date', 'our_protocols.quantity_orders', 'our_protocols.diagnostic', 'protocols.observations', 'prescribers.id as prescriber_id', 'prescribers.full_name as prescriber')
        ->join('our_protocols', 'our_protocols.protocol_id', '=', 'protocols.id')
        ->join('prescribers', 'prescribers.id', '=', 'our_protocols.prescriber_id')
        ->join('patients', 'patients.id', '=', 'our_protocols.patient_id')
        ->where('protocols.id', $id)
        ->first();

        $practices = Protocol::get_practices($id);
        
        $social_works = SocialWork::all();

        return view('protocols/our/show')
        ->with('protocol', $protocol)
        ->with('social_works', $social_works)
        ->with('practices', $practices);
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
        $protocol = Protocol::select('protocols.id', 'patients.full_name', 'our_protocols.social_work_id', 'protocols.completion_date', 'our_protocols.quantity_orders', 'our_protocols.diagnostic', 'protocols.observations', 'prescribers.id as prescriber_id', 'prescribers.full_name as prescriber')
        ->join('our_protocols', 'our_protocols.protocol_id', '=', 'protocols.id')
        ->join('prescribers', 'prescribers.id', '=', 'our_protocols.prescriber_id')
        ->join('patients', 'patients.id', '=', 'our_protocols.patient_id')
        ->where('protocols.id', $id)
        ->first();

        $practices = Protocol::get_practices($id);

        $social_works = SocialWork::all();

        return view('protocols/our/edit')
        ->with('protocol', $protocol)
        ->with('social_works', $social_works)
        ->with('practices', $practices); 
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

    /**
     * Returns a list of filtered patients
     *
     * @return \Illuminate\Http\Response
     */
    public function load_patients(Request $request)
    {
        // label column is required
        $filter = $request->filter;

        $patients = Patient::select('full_name as label', 'id')
        ->where(function ($query) use ($filter) {
            if (!empty($filter)) {
                $query->orWhere("full_name", "like", "%$filter%")
                ->orWhere("key", "like", "$filter%")
                ->orWhere("owner", "like", "%$filter%");
            }
        })
        ->get()
        ->toJson();

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

        $prescribers = Prescriber::select('full_name as label', 'id')
        ->where(function ($query) use ($filter) {
            if (!empty($filter)) {
                $query->orWhere("full_name", "like", "%$filter%")
                ->orWhere("provincial_enrollment", "like", "$filter%")
                ->orWhere("national_enrollment", "like", "$filter%");
            }
        })
        ->get()
        ->toJson();

        return $prescribers;
    }

}
