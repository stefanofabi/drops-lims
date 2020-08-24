<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\PatientController;


use App\Phone;

class PhoneController extends Controller
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
        $id = DB::transaction(function () use ($request) {

            $phone_id = Phone::insertGetId([
                'patient_id' => $request->id,
                'phone' => $request->phone,
                'type' => $request->type,
            ]);

            return $phone_id;
        }, self::RETRIES);


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
        $id = $request['id'];
        return Phone::where('id', $id)->first();
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
        
        DB::transaction(function () use ($request) {
            Phone::where('id', '=', $request->id)->update(
                [
                    'phone' => $request->phone,
                    'type' => $request->type,
                ]);
        }, self::RETRIES);
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
