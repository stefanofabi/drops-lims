<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\FamilyMember;
use App\OurProtocol;

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Displays a list of patient results
     *
     * @return \Illuminate\Http\Response
     */
    public function index_results()
    {
        //

        $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        $ended_date = date('Y-m-d');

        $user_id = auth()->user()->id;

        $family = $this->get_family($user_id);

        return view('patients/index')
            ->with('family', $family)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date);
    }

    /**
     * Returns all protocols for a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function get_protocols(Request $request)
    {
        //
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $user_id = auth()->user()->id;
        $patient_id = $request->patient;

        $count = FamilyMember::where('user_id', $user_id)
            ->where('patient_id', $patient_id)
            ->count();

        // we check if the user really has a related family member
        if ($count > 0) {

            $family = $this->get_family($user_id);

            $protocols = OurProtocol::select('protocols.id', DB::raw('DATE_FORMAT(protocols.completion_date, "%d/%m/%Y") as completion_date'), 'patients.full_name as patient', 'prescribers.full_name as prescriber')
                ->protocol()
                ->patient()
                ->prescriber()
                ->where('patient_id', $patient_id)
                ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
                ->get();

            $view = view('patients/results')
                ->with('protocols', $protocols)
                ->with('patient', $patient_id);
        } else {
            $view = view('patients/index');
        }

        return $view
            ->with('family', $family)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date);
    }

    public function get_family($id)
    {
        return FamilyMember::select('family_members.patient_id', 'patients.full_name')
            ->join('patients', 'family_members.patient_id', '=', 'patients.id')
            ->where('family_members.user_id', $id)
            ->get();
    }

}
