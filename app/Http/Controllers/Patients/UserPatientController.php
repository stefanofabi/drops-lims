<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Laboratory\Print\Protocol\PrintProtocol;

use App\Models\FamilyMember;
use App\Models\OurProtocol;
use App\Models\Practice;
use App\Models\Protocol;

use Lang;

class UserPatientController extends Controller
{
    use PrintProtocol;

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

    /**
     * Shows the protocol of a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function show_protocol($id)
    {
        $user = auth()->user();

        $our_protocol = OurProtocol::findOrFail($id);
        $patient = $our_protocol->patient;

        $count = FamilyMember::check_relation($user->id, $patient->id);

        if ($count > 0) {
            $view = view('patients/protocols/show')->with('our_protocol', $our_protocol);
        } else {
            $view = $this->index();
        }

        return $view;
    }

    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function print_protocol($id)
    {
        $user_id = auth()->user()->id;

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $patient = $protocol->patient()->first();

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        $this->print($id, []);
    }

    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function show_practice($id)
    {
        $user_id = auth()->user()->id;

        $practice = Practice::findOrFail($id);
        $protocol = $practice->protocol()->first();

        $protocol = OurProtocol::protocol()->findOrFail($protocol->id);
        $patient = $protocol->patient()->first();

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        $report = $practice->report()->first();
        $determination = $report->determination()->first();

        return view('patients/protocols/practices/show')->with('practice', $practice)->with('protocol', $protocol)->with('report', $report)->with('determination', $determination);
    }

    /**
     * Returns the results of a practice
     *
     * @return \Illuminate\Http\Response
     */
    public function get_results(Request $request)
    {

        $practice_id = $request->practice_id;

        $practice = Practice::findOrFail($practice_id);
        $protocol = $practice->protocol()->first();

        $protocol = OurProtocol::protocol()->findOrFail($protocol->id);
        $patient = $protocol->patient()->first();
        $user_id = auth()->user()->id;

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        return $practice->results->toArray();
    }

    /**
     * Returns a protocol partially in pdf format
     *
     * @return \Illuminate\Http\Response
     */
    public function print_partial_report(Request $request)
    {
        if (isset($request->to_print)) {
            $user_id = auth()->user()->id;
            $filter_practices = $request->to_print;

            $family = FamilyMember::select('patient_id')->where('user_id', $user_id)->get()->toArray();

            $protocol = Protocol::select('protocols.id as id')->ourProtocol()->patient()->practices()->whereIn('practices.id', $filter_practices)->whereIn('patients.id', $family)->groupBy('protocols.id')->get();

            if ($protocol->count() == 1) {
                $this->print($protocol->first()->id, $filter_practices);
            } else {
                echo Lang::get('errors.practice_error_protocol');
            }
        } else {
            echo Lang::get('errors.no_data');
        }
    }
}
