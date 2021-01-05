<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Laboratory\Prints\Protocols\Our\PrintProtocolContext;
use App\Models\FamilyMember;
use App\Models\OurProtocol;
use App\Models\Practice;
use App\Models\Protocol;
use Illuminate\Http\Request;

class ProtocolController extends Controller
{
    //
    /**
     * Shows the protocol of a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();

        $our_protocol = OurProtocol::findOrFail($id);
        $patient = $our_protocol->patient;

        $count = FamilyMember::check_relation($user->id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        return view('patients/protocols/show')->with('our_protocol', $our_protocol);
    }

    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function print_protocol($id)
    {
        $user_id = auth()->user()->id;

        $our_protocol = OurProtocol::findOrFail($id);
        $patient = $our_protocol->patient;

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        $strategy = 'modern_style';
        $strategyClass = PrintProtocolContext::STRATEGIES[$strategy];

        return (new $strategyClass)->print($id, []);
    }

    /**
     * Returns a protocol partially in pdf format
     *
     * @return \Illuminate\Http\Response
     */
    public function print_partial_report(Request $request)
    {
        if (! isset($request->to_print)) {
            return Lang::get('errors.no_data');
        }

        $user_id = auth()->user()->id;
        $filter_practices = $request->to_print;

        $family = FamilyMember::select('patient_id')->where('user_id', $user_id)->get()->toArray();

        // Verify that the selected practices belong to the same protocol and that the patient is linked
        $protocol = Protocol::select('protocols.id as id')->ourProtocol()->patient()->practices()->whereIn('practices.id', $filter_practices)->whereIn('patients.id', $family)->groupBy('protocols.id')->get();

        if ($protocol->count() != 1) {
            return Lang::get('errors.practice_error_protocol');
        }

        $strategy = 'modern_style';
        $strategyClass = PrintProtocolContext::STRATEGIES[$strategy];

        return (new $strategyClass)->print($protocol->first()->id, $filter_practices);
    }
}
