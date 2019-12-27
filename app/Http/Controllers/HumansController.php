<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Shunt;
use App\Patient;
use App\Human;

class HumansController extends Controller
{

	const RETRIES = 5;

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
    public function create()
    {
        //
        $shunts = Shunt::all();

        return view('patients/humans/create')->with('shunts', $shunts);      
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
            $shunt = $request->shunt;
            $name = $request['name'];

			$patient = Patient::insertGetId([
                    'name' => $name, 
                    'shunt_id' => $shunt
            ]);


            // other data for humans
            $dni = $request['dni'];
            $surname = $request['surname'];
            
            $home_address = $request['home_address'];
            $city = $request['city'];

            $sex = $request['sex'];
            $birth_date = $request['birth_date'];

			Human::insert([
                    'patient_id' => $patient, 
                    'dni' => $dni,
                    'surname' => $surname,
                    'sex' => $sex,
                    'birth_date' => $birth_date,
                    'city' => $city,
                    'home_address' => $home_address
			]);

            return $patient;
		}, self::RETRIES);

        
        return redirect('pacientes/'.$id);
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
