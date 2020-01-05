<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Industrial;
use App\TaxCondition;
use App\Patient;
use App\Email;
use App\Phone;

class IndustrialController extends Controller
{

    use Pagination;

    private const PER_PAGE = 15;
    private const ADJACENTS = 4;

    private const RETRIES = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $shunts = Shunt::all();

        // Request
        $filter = $request['filter'];
        $page = $request['page'];

        $offset = ($page - 1) * self::PER_PAGE;
        $query_patients = Industrial::index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = Industrial::count_index($filter);
        $total_pages = ceil($count_rows / self::PER_PAGE);

        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        $view = view('patients/industrials/index')
        ->with('request', $request->all())
        ->with('data', $query_patients)
        ->with('paginate', $paginate);

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $conditions = TaxCondition::all();

        return view('patients/industrials/create')
        ->with('conditions', $conditions);
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
            $name = $request['name'];

            $patient = Patient::insertGetId([
                'name' => $name, 
            ]);


            // other data for industrials
            $cuit = $request['cuit'];
            $business_name = $request['business_name'];

            $start_activity = $request['start_activity'];
            $tax_condition = $request['tax_condition'];

            $fiscal_address = $request['fiscal_address'];
            $city = $request['city'];

            Industrial::insert([
                'patient_id' => $patient, 
                'cuit' => $cuit,
                'business_name' => $business_name,
                'start_activity' => $start_activity,
                'tax_condition' => $tax_condition,
                'city' => $city,
                'fiscal_address' => $fiscal_address
            ]);

            return $patient;
        }, self::RETRIES);


        return redirect()->action('IndustrialController@show', ['id' => $id]);
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
        $industrial = Industrial::find($id);
        $patient = $industrial->patient;

        $tax_conditions = TaxCondition::all();


        $data = [
            'id' => $patient->id,
            'name' => $patient->name,
            'business_name' => $industrial->business_name,
            'cuit' => $industrial->cuit,
            'start_activity' => $industrial->start_activity,
            'tax_condition' => $industrial->tax_condition,
            'fiscal_address' => $industrial->fiscal_address,
            'city' => $industrial->city
        ];

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);

        return view('patients/industrials/show')
        ->with('industrial', $data)
        ->with('tax_conditions', $tax_conditions)
        ->with('emails', $emails)
        ->with('phones', $phones);
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
        $industrial = Industrial::find($id);
        $patient = $industrial->patient;
        $tax_conditions = TaxCondition::all();


        $data = [
            'id' => $patient->id,
            'name' => $patient->name,
            'business_name' => $industrial->business_name,
            'cuit' => $industrial->cuit,
            'start_activity' => $industrial->start_activity,
            'tax_condition' => $industrial->tax_condition,
            'fiscal_address' => $industrial->fiscal_address,
            'city' => $industrial->city
        ];

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);


        return view('patients/industrials/edit')
        ->with('industrial', $data)
        ->with('tax_conditions', $tax_conditions)
        ->with('emails', $emails)
        ->with('phones', $phones);
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

        DB::transaction(function () use ($request, $id) {

            $result_patient = Patient::where('id', '=', $id)
            ->update(['name' => $request->name]);

            $result_industrial = Industrial::where('patient_id', '=', $id)
            ->update(
             [
                'business_name' => $request->business_name,
                'cuit' => $request->cuit,
                'tax_condition' => $request->tax_condition,
                'fiscal_address' => $request->fiscal_address,
                'city' => $request->city,
                'start_activity' => $request->start_activity,
            ]);

        }, self::RETRIES);


        return redirect()->action('IndustrialController@show', ['id' => $id]);

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
