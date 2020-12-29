<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Phone;
use App\Models\Patient;

use Lang;

class PhoneController extends Controller
{

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
    public function create($patient_id)
    {
        //

    	$patient = Patient::findOrFail($patient_id);

        return view('administrators/patients/phones/create')
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

		$request->validate([
            'phone' => 'required|string',
            'type' => 'required|string',
        ]);

		try {

	        $phone = new Phone($request->all());

	        if ($phone->save()) {
	        	$redirect = redirect()->action('PatientController@edit', $request->patient_id)
	        		->with('success', [
	        			Lang::get('phones.success_saving_phone')
	        		]);
	        } else {
	        	$redirect = redirect()->back()
	                ->withInput($request->all())
	                ->withErrors(
	                	Lang::get('phones.error_saving_phone')
	                );
	        }
        } catch (QueryException $e) {
            $redirect = back()->withInput($request->all())
                ->withErrors(
                    Lang::get('errors.error_processing_transaction')
                );
        } 

        return $redirect;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        
        return Phone::findOrFail($request->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

		$request->validate([
            'phone' => 'required|string',
            'type' => 'required|string',
        ]);

        $phone = Phone::findOrFail($request->id);

        if (!$phone->update($request->all())) {
        	return response([], 500);
        }
        
        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $phone = Phone::findOrFail($request->id);

        if (!$phone->delete()) {
            return response([], 500);
        }

        return response([], 200);
    }
}
