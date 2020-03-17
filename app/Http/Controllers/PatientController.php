<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Patient;
use App\Email;
use App\Phone;
use App\SocialWork;
use App\Affiliate;

class PatientController extends Controller
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
    public function index()
    {
        //
        return view('patients/patients');
    }

    /**
	* Load patients
    * @param   \Illuminate\Http\Request  $request
    * @return View $view
    */
    public function load(Request $request) {
        
        // Request
        $patient_type = $request['type'];
        $filter = $request['filter'];
        $page = $request['page'];

        $offset = ($page - 1) * self::PER_PAGE;
        $query_patients = Patient::index($filter, $offset, self::PER_PAGE, $patient_type);

        // Pagination
        $count_rows = Patient::count_index($filter, $patient_type);
        $total_pages = ceil($count_rows / self::PER_PAGE);

        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);
        
        switch($patient_type) {
            case 'animal': {
            	$view = view('patients/animals/index')
                ->with('request', $request->all())
                ->with('data', $query_patients)
                ->with('paginate', $paginate);
                break;
            }

            case 'human': {
                $view = view('patients/humans/index')
                ->with('request', $request->all())
                ->with('data', $query_patients)
                ->with('paginate', $paginate);
                break;
            }
            
            case 'industrial': {
                $view = view('patients/industrials/index')
                ->with('request', $request->all())
                ->with('data', $query_patients)
                ->with('paginate', $paginate);
                break;
            }

            default: { 
                $view = view('patients/patients');
                break;
            }
        }


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
        return view('patients/create');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $patient = Patient::findOrFail($id);

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);

        $affiliates = Affiliate::get_social_works($id);

        $patient_type = $patient->type;

        switch($patient_type) {
            case 'animal': {
                $view = view('patients/animals/show')
                ->with('animal', $patient)
                ->with('emails', $emails)
                ->with('phones', $phones)
                ->with('affiliates', $affiliates);
                break;
            }

            case 'human': {
                $view = view('patients/humans/show')
                ->with('human', $patient)
                ->with('emails', $emails)
                ->with('phones', $phones)
                ->with('affiliates', $affiliates);
                break;
            }
            
            case 'industrial': {
                $view = view('patients/industrials/show')
                ->with('industrial', $patient)
                ->with('emails', $emails)
                ->with('phones', $phones)
                ->with('affiliates', $affiliates);
                break;
            }

            default: { 
                $view = view('patients/patients');
                break;
            }
        }

        return $view;
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
        $patient = Patient::findOrFail($id);

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);

        $social_works = SocialWork::all();

        $affiliates = Affiliate::get_social_works($id);


        $patient_type = $patient->type;

        switch($patient_type) {
            case 'animal': {
            	$view = view('patients/animals/edit')
	        	->with('id', $id)
		        ->with('animal', $patient)
		        ->with('emails', $emails)
		        ->with('phones', $phones)
		        ->with('social_works', $social_works)
		        ->with('affiliates', $affiliates);
                break;
            }

            case 'human': {
                $view = view('patients/humans/edit')
		        ->with('id', $id)
		        ->with('human', $patient)
		        ->with('emails', $emails)
		        ->with('phones', $phones)
		        ->with('social_works', $social_works)
		        ->with('affiliates', $affiliates);
                break;
            }
            
            case 'industrial': {
                $view = view('patients/industrials/edit')
		        ->with('id', $id)
		        ->with('industrial', $patient)
		        ->with('emails', $emails)
		        ->with('phones', $phones)
		        ->with('social_works', $social_works)
		        ->with('affiliates', $affiliates);
                break;
            }

            default: { 
                $view = view('patients/patients');
                break;
            }
        }

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

           $result_human = Patient::where('id', '=', $id)
           ->update(
               [
                'full_name' => $request->full_name,
                'key' => $request->key,
                'address' => $request->address,
                'city' => $request->city,
                'sex' => $request->sex,
                'birth_date' => $request->birth_date,

                // for animals
                'owner' => $request->owner,

                // for industrials
                'business_name' => $request->business_name,
                'tax_condition' => $request->tax_condition,
                'start_activity' => $request->start_activity,   
            ]);

       }, self::RETRIES);


        return redirect()->action('PatientController@show', ['id' => $id]);
    }


     /**
     * Show the form for creating a new animal patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_animal()
    {
        //

        return view('patients/animals/create');
    }   

    /**
     * Show the form for creating a new human patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_human()
    {
        //

        return view('patients/humans/create');      
    }

    /**
     * Show the form for creating a new industrial patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_industrial()
    {
        //

        return view('patients/industrials/create');
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
           
            $full_name = $request['full_name'];
            $key = $request['key'];
            $address = $request['address'];
            $city = $request['city'];
            $sex = $request['sex'];
            $birth_date = $request['birth_date'];
            $type = $request['type'];

            // for animals
            $owner = $request['owner'];

            // for industrials
            $business_name = $request['business_name'];
            $start_activity = $request['start_activity'];
            $tax_condition = $request['tax_condition'];

            $patient = Patient::insertGetId(
                [
                    'key' => $key,
                    'full_name' => $full_name,
                    'sex' => $sex,
                    'birth_date' => $birth_date,
                    'city' => $city,
                    'address' => $address,
                    'type' => $type,
                    'owner' => $owner,
                    'business_name' => $business_name,
                    'start_activity' => $start_activity,
                    'tax_condition' => $tax_condition,
                ]
            );

            return $patient;
        }, self::RETRIES);


        return redirect()->action('PatientController@show', ['id' => $id]);
    }

}
