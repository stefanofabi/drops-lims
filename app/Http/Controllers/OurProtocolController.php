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

        $social_work = SocialWork::find($request->social_work);

        $social_works = Affiliate::select('social_works.id as id', 'social_works.name as name', 'affiliate_number', 'expiration_date')
        ->plan()
        ->socialWork()
        ->where('patient_id', $patient_id)
        ->get();

        $plans = SocialWork::get_plans($request->social_work);

        return view('protocols/our/create')
        ->with('patient', $patient)
        ->with('social_work', $social_work)
        ->with('social_works', $social_works)
        ->with('plans', $plans);
        
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
                'plan_id' => $request->plan_id,
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

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $prescriber = $protocol->prescriber()->first();
        $patient = $protocol->patient()->first();
        $plan = $protocol->plan()->first();
        $social_work = $plan->social_work()->first();

        $practices = $protocol->practices();

        return view('protocols/our/show')
        ->with('protocol', $protocol)
        ->with('patient', $patient)
        ->with('social_work', $social_work)
        ->with('prescriber', $prescriber)
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

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $prescriber = $protocol->prescriber()->first();
        $patient = $protocol->patient()->first();
        $plan = $protocol->plan()->first();
        $social_work = $plan->social_work()->first();

        $practices = $protocol->practices();

        $social_works = SocialWork::all();

        return view('protocols/our/edit')
        ->with('protocol', $protocol)
        ->with('patient', $patient)
        ->with('social_work', $social_work)
        ->with('social_works', $social_works)
        ->with('prescriber', $prescriber)
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

    /**
     * Returns a view for add practices
     *
     * @return \Illuminate\Http\Response
     */
    public function add_practices($protocol_id)
    {
            
        $protocol = OurProtocol::findOrFail($protocol_id);
        $social_work = $protocol->plan;

        return view('protocols/our/add_practice')
        ->with('protocol', $protocol)
        ->with('nomenclator', $nomenclator);
    }

}
