<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;

use Lang;

class UserPatientController extends Controller
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;    

    public function __construct (ProtocolRepositoryInterface $protocolRepository)
    {
        $this->protocolRepository = $protocolRepository;
    }

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

        return view('patients/index')
            ->with('family_members', $family_members)
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
        $request->validate([
            'initial_date' => 'required|date',
            'ended_date' => 'required|date',
            'patient_id' => 'required|numeric|min:1',
        ]);

        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;
        $user = auth()->user();
        $patient_id = $request->patient_id;

        $family_members = $user->family_members;

        $protocols = $this->protocolRepository->getProtocolsInDatesRange($initial_date, $ended_date, $patient_id);

        return view('patients/results')
            ->with('protocols', $protocols)
            ->with('patient', $patient_id)
            ->with('family_members', $family_members)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date);
    }
}
