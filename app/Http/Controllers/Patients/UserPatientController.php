<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\FamilyMember;
use App\Models\OurProtocol;

use Lang;

class UserPatientController extends Controller
{
    /**
     * Displays a list of patient results
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        $ended_date = date('Y-m-d');

        $user = auth()->user();

        $family_members = $user->family_members;

        return view('patients/index')->with('family_members', $family_members)->with('initial_date', $initial_date)->with('ended_date', $ended_date);
    }

    /**
     * Returns all protocols for a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function get_protocols(Request $request)
    {
        //
        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
            'patient_id' => 'required|numeric|min:1',
        ]);

        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $user = auth()->user();
        $patient_id = $request->patient_id;

        $count = FamilyMember::check_relation($user->id, $patient_id);

        // we check if the user really has a related family member
        if (! $count) {
            return redirect()->back()->withErrors(Lang::get('errors.not_found'));
        }

        $family_members = $user->family_members;

        $protocols = OurProtocol::select('protocols.id', DB::raw('DATE_FORMAT(protocols.completion_date, "%d/%m/%Y") as completion_date'), 'patients.full_name as patient', 'prescribers.full_name as prescriber')->protocol()->patient()->prescriber()->where('patient_id', $patient_id)->whereBetween('protocols.completion_date', [
            $initial_date,
            $ended_date,
        ])->orderBy('protocols.completion_date', 'desc')->get();

        return view('patients/results')->with('protocols', $protocols)->with('patient', $patient_id)->with('family_members', $family_members)->with('initial_date', $initial_date)->with('ended_date', $ended_date);
    }
}
