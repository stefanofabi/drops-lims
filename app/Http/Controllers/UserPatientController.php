<?php

namespace App\Http\Controllers;

use App\Http\Traits\PrintProtocol;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\FamilyMember;
use App\OurProtocol;
use App\Practice;
use App\Protocol;

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

        $user_id = auth()->user()->id;

        $family = FamilyMember::get_family($user_id);

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

        $count = FamilyMember::check_relation($user_id, $patient_id);

        // we check if the user really has a related family member
        if ($count > 0) {

            $family = FamilyMember::get_family($user_id);

            $protocols = OurProtocol::select('protocols.id', DB::raw('DATE_FORMAT(protocols.completion_date, "%d/%m/%Y") as completion_date'), 'patients.full_name as patient', 'prescribers.full_name as prescriber')
                ->protocol()
                ->patient()
                ->prescriber()
                ->where('patient_id', $patient_id)
                ->whereBetween('protocols.completion_date', [$initial_date, $ended_date])
                ->orderBy('protocols.completion_date', 'desc')
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


    /**
     * Shows the protocol of a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function show_protocol($id)
    {
        $user_id = auth()->user()->id;

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $patient = $protocol->patient()->first();

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count > 0) {
            $prescriber = $protocol->prescriber()->first();
            $plan = $protocol->plan()->first();
            $social_work = $plan->social_work()->first();
            $practices = $protocol->practices;

            $view = view('patients/protocols/show')
                ->with('protocol', $protocol)
                ->with('patient', $patient)
                ->with('prescriber', $prescriber)
                ->with('plan', $plan)
                ->with('social_work', $social_work)
                ->with('practices', $practices);
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
    public function print_protocol($id) {
        $user_id = auth()->user()->id;

        $protocol = OurProtocol::protocol()->findOrFail($id);
        $patient = $protocol->patient()->first();

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        $this->print($id, array());
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

        return view('patients/protocols/practices/show')
            ->with('practice', $practice)
            ->with('protocol', $protocol)
            ->with('report', $report)
            ->with('determination', $determination);

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

            $protocol = Protocol::select('protocols.id as id')
                ->ourProtocol()
                ->patient()
                ->practices()
                ->whereIn('practices.id', $filter_practices)
                ->whereIn('patients.id', $family)
                ->groupBy('protocols.id')
                ->get();

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
