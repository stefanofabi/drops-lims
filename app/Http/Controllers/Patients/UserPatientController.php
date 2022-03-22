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
    public function index(Request $request)
    {
        //

        if (isset($request->initial_date)) 
        {
            $initial_date = $request->initial_date;
        } else 
        {
            $initial_date = date('Y-m-d', strtotime(date('Y-m-d')."- 30 days"));
        }

        if (isset($request->ended_date)) 
        {
            $ended_date = $request->ended_date;
        } else 
        {
            $ended_date = date('Y-m-d');
        }

        if (isset($request->patient_id)) 
        {
            $protocols = $this->protocolRepository->getProtocolsInDatesRange($initial_date, $ended_date, $request->patient_id);
        } else 
        {
            $protocols = array();
        }
        
        $user = auth()->user();

        $family_members = $user->family_members;
        
        return view('patients/index')
            ->with('family_members', $family_members)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date)
            ->with('protocols', $protocols)
            ->with('patient', $request->patient_id);
    }
}
