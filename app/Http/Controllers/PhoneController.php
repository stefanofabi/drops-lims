<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Phone;

use Lang;
use Session;

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
    public function create($id)
    {
        //

        return view('administrators/patients/phones/create')
        ->with('id', $id);
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

        $phone = new Phone;

        $phone->patient_id = $request->id;
        $phone->phone = $request->phone;
        $phone->type = $request->type;

        if (!$phone->save()) {
        	return redirect()->back()
                ->withInput($request->all())
                ->with('errors', [Lang::get('phones.error_saving_phone')]);
        }

        Session::flash('success', [Lang::get('phones.success_saving_phone')]);

        return redirect()->action('PatientController@edit', ['id' => $request->id]);
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
        $id = $request->id;
        return Phone::where('id', $id)->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $id = $request->id;

        $phone = Phone::findOrFail($id);

        $phone->phone = $request->phone;
        $phone->type = $request->type;

        if (!$phone->save()) {
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

        $id = $request->id;

        $phone = Phone::findOrFail($id);

        if (!$phone->delete()) {
            return response([], 500);
        }

        return response([], 200);
    }
}
