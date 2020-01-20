<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\Pagination;

use App\Patient;
use App\Animal;
use App\Email;
use App\Phone;
use App\SocialWork;
use App\Affiliate;

class AnimalController extends Controller
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
        $query_patients = Animal::index($filter, $offset, self::PER_PAGE);

        // Pagination
        $count_rows = Animal::count_index($filter);
        $total_pages = ceil($count_rows / self::PER_PAGE);

        $paginate = $this->paginate($page, $total_pages, self::ADJACENTS);

        $view = view('patients/animals/index')
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

        return view('patients/animals/create');
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


            // other data for animals
            $owner = $request['owner'];

            $home_address = $request['home_address'];
            $city = $request['city'];

            $sex = $request['sex'];
            $birth_date = $request['birth_date'];

            Animal::insert([
                'patient_id' => $patient, 
                'owner' => $owner,
                'sex' => $sex,
                'birth_date' => $birth_date,
                'city' => $city,
                'home_address' => $home_address
            ]);

            return $patient;
        }, self::RETRIES);


        return redirect()->action('AnimalController@show', ['id' => $id]);
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

        $animal = Animal::find($id);
        $patient = $animal->patient;

        $data = [
            'id' => $patient->id,
            'owner' => $animal->owner,
            'name' => $patient->name,
            'home_address' => $animal->home_address,
            'city' => $animal->city,
            'sex' => $animal->sex,
            'birth_date' => $animal->birth_date,
        ];

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);

        $affiliates = Affiliate::get_social_works($id);

        return view('patients/animals/show')
        ->with('animal', $data)
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
        $animal = Animal::find($id);
        $patient = $animal->patient;

        $data = [
        	'id' => $patient->id,
            'owner' => $animal->owner,
            'name' => $patient->name,
            'home_address' => $animal->home_address,
            'city' => $animal->city,
            'sex' => $animal->sex,
            'birth_date' => $animal->birth_date,
        ];

        $emails = Email::get_emails($id);

        $phones = Phone::get_phones($id);

        $social_works = SocialWork::all();

        $affiliates = Affiliate::get_social_works($id);

        return view('patients/animals/edit')
        ->with('id', $id)
        ->with('animal', $data)
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

        $result = DB::transaction(function () use ($request, $id) {

            $result_patient = Patient::where('id', '=', $id)
            ->update(['name' => $request->name]);

            $result_animal = Animal::where('patient_id', '=', $id)
            ->update(
               [
                'owner' => $request->owner,
                'home_address' => $request->home_address,
                'city' => $request->city,
                'sex' => $request->sex,
                'birth_date' => $request->birth_date,
            ]);

            $result =  $result_patient && $result_animal;

            return $result;
        }, self::RETRIES);


        return redirect()->action('AnimalController@show', ['id' => $id]);      
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
