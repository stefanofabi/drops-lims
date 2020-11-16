<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\FamilyMember;
use App\Models\SecurityCode;

use Lang;

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

        $request->validate([
            'patient_id' => 'required|numeric|min:1',
            'security_code' => 'required|string',
        ]);

        $user_id = auth()->user()->id;

        try {

            DB::beginTransaction();

            $codes = SecurityCode::where('patient_id', $request->patient_id)
                ->where('expiration_date', '>', date('Y-m-d'))
                ->whereNull('used_at')
                ->get();

            // We verify that the security code entered is valid
            $response = false;
            foreach ($codes as $code) {
                if (Hash::check($request->security_code, $code->security_code)) {
                    $response = true;
                    break;
                }
            }

            if (!$response) {
                // No valid security codes found
                return back()->withInput($request->all())->withErrors(Lang::get('errors.invalid_security_code'));
            }

            // We verify that the user does not already have a related patient
            $exists = FamilyMember::where('user_id', $user_id)
                ->where('patient_id', $request->patient_id)
                ->count();

            if ($exists > 0) {
                return back()->withErrors(Lang::get('errors.already_family_member'));
            }

            $family_member = new FamilyMember;
            $family_member->user_id = $user_id;
            $family_member->patient_id = $request->patient_id;
            $family_member->save();

            $code->used_at = now();
            $code->save();

            DB::commit();

            // We take the user to the main view
            $redirect = redirect()->action([FamilyMemberController::class, 'index']);

        } catch (\Exception $e) {
            DB::rollBack();

            $redirect = back()->withErrors(Lang::get('errors.error_processing_transaction'));
        }

        return $redirect;;
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
