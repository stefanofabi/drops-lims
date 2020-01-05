<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Patient;
use App\Human;
use App\Email;
use App\Phone;

class HumanController extends Controller
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

        // Request
        $filter = $request['filter'];
        $page = $request['page'];

        $offset = ($page - 1) * self::PER_PAGE;
        $query_patients = Human::index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = Human::count_index($filter);
        $total_pages = ceil($count_rows / self::PER_PAGE);

        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        $view = view('patients/humans/index')
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

    	return view('patients/humans/create');      
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


            // other data for humans
    		$dni = $request['dni'];
    		$last_name = $request['last_name'];

    		$home_address = $request['home_address'];
    		$city = $request['city'];

    		$sex = $request['sex'];
    		$birth_date = $request['birth_date'];

    		Human::insert([
    			'patient_id' => $patient, 
    			'dni' => $dni,
    			'last_name' => $last_name,
    			'sex' => $sex,
    			'birth_date' => $birth_date,
    			'city' => $city,
    			'home_address' => $home_address
    		]);

    		return $patient;
    	}, self::RETRIES);


    	return redirect()->action('HumanController@show', ['id' => $id]);
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
        $human = Human::find($id);
        $patient = $human->patient;

        $data = [
            'id' => $patient->id,
            'dni' => $human->dni,
            'last_name' => $human->last_name,
            'name' => $patient->name,
            'home_address' => $human->home_address,
            'city' => $human->city,
            'sex' => $human->sex,
            'birth_date' => $human->birth_date,
        ];

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);


        return view('patients/humans/show')
        ->with('human', $data)
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
    	$human = Human::find($id);

        $patient = $human->patient;

        $data = [
            'id' => $patient->id,
            'dni' => $human->dni,
            'last_name' => $human->last_name,
            'name' => $patient->name,
            'home_address' => $human->home_address,
            'city' => $human->city,
            'sex' => $human->sex,
            'birth_date' => $human->birth_date,
        ];

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);

        $view = view('patients/humans/edit')
        ->with('human', $data)
        ->with('emails', $emails)
        ->with('phones', $phones);
        

        return $view;
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

           $result_human = Human::where('patient_id', '=', $id)
           ->update(
               [
                'dni' => $request->dni,
                'last_name' => $request->last_name,
                'home_address' => $request->home_address,
                'city' => $request->city,
                'sex' => $request->sex,
                'birth_date' => $request->birth_date,
            ]);

       }, self::RETRIES);


        return redirect()->action('HumanController@show', ['id' => $id]);
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
