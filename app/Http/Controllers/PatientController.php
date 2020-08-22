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

use Lang;

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
        return view('administrators/patients/patients');
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
            	$view = view('administrators/patients/animals/index')
                ->with('request', $request->all())
                ->with('data', $query_patients)
                ->with('paginate', $paginate);
                break;
            }

            case 'human': {
                $view = view('administrators/patients/humans/index')
                ->with('request', $request->all())
                ->with('data', $query_patients)
                ->with('paginate', $paginate);
                break;
            }

            case 'industrial': {
                $view = view('administrators/patients/industrials/index')
                ->with('request', $request->all())
                ->with('data', $query_patients)
                ->with('paginate', $paginate);
                break;
            }

            default: {
                $view = view('administrators/patients/patients');
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
        return view('administrators/patients/create');
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
                $view = view('administrators/patients/animals/show');
                break;
            }

            case 'human': {
                $view = view('administrators/patients/humans/show');
                break;
            }

            case 'industrial': {
                $view = view('administrators/patients/industrials/show');
                break;
            }

            default: {
                $view = view('administrators/patients/patients');
                break;
            }
        }

        return $view
        ->with('patient', $patient)
        ->with('emails', $emails)
        ->with('phones', $phones)
        ->with('affiliates', $affiliates);
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
            	$view = view('administrators/patients/animals/edit');
                break;
            }

            case 'human': {
                $view = view('administrators/patients/humans/edit');
                break;
            }

            case 'industrial': {
                $view = view('administrators/patients/industrials/edit');
                break;
            }
        }

        return $view
		 ->with('patient', $patient)
		 ->with('emails', $emails)
		 ->with('phones', $phones)
		 ->with('social_works', $social_works)
		 ->with('affiliates', $affiliates);
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

        return view('administrators/patients/animals/create');
    }

    /**
     * Show the form for creating a new human patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_human()
    {
        //

        return view('administrators/patients/humans/create');
    }

    /**
     * Show the form for creating a new industrial patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_industrial()
    {
        //

        return view('administrators/patients/industrials/create');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $patient = Patient::find($id);

        if (!$patient) {
        	// patient not exists
        	return view('administrators/patients/patients')
        	->with('errors', array(
        		Lang::get('patients.error_destroy_patient')
        	));
        }

        $view = view('administrators/patients/destroy');

        if ($patient->delete()) {
            $view->with('patient_id', $id)->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //

        $patient = Patient::onlyTrashed()->find($id);

        if (!$patient) {
        	// patient not removed
        	return view('administrators/patients/patients')
        	->with('errors', array(
        		Lang::get('patients.error_restore_patient')
        	));
        }

        $view = view('administrators/patients/restore')->with('patient_id', $id);

        if ($patient->restore()) {
            $view->with('type', 'success');
        } else {
            $view->with('type', 'danger');
        }

        return $view;
    }
}
