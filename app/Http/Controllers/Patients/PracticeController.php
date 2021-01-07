<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\Practice;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    //
    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = auth()->user()->id;

        $practice = Practice::findOrFail($id);
        $protocol = $practice->protocol;

        $patient = $protocol->our_protocol->patient;

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        return view('patients/protocols/practices/show')->with('practice', $practice);
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
        $protocol = $practice->protocol->our_protocol;

        $patient = $protocol->patient;
        $user_id = auth()->user()->id;

        $count = FamilyMember::check_relation($user_id, $patient->id);

        if ($count == 0) {
            return $this->index();
        }

        return $practice->results->toJson();
    }
}
