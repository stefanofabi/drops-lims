<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\FamilyMember;
use App\Models\SecurityCode;

class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = auth()->user()->id;
        $family_members = FamilyMember::get_family($user_id);

        return view('patients/family_members/index')
            ->with('family_members', $family_members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('patients/family_members/create');
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
        $user_id = auth()->user()->id;
        $patient_id = $request->patient_id;
        $security_code = $request->security_code;

        $codes = SecurityCode::where('patient_id', $patient_id)
          //  ->where('security_code', Hash::make($security_code))
            ->where('expiration_date', '>', date('Y-m-d'))
            ->get();

        $response = false;
        foreach ($codes as $code) {
            if (Hash::check($security_code, $code->security_code)) {
                $response = true;
                break;
            }
        }

        if ($response) {
            $exists = FamilyMember::where('user_id', $user_id)->where('patient_id', $patient_id)->count();

            if ($exists == 0) {
                DB::transaction(function () use ($user_id, $patient_id) {
                    FamilyMember::insert([
                        'user_id' => $user_id,
                        'patient_id' => $patient_id,
                    ]);
                }, 3);
            }
        }

        return $this->index();
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
