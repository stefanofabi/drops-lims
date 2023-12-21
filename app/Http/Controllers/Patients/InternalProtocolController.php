<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;
use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use PDF; 
use Lang;

class InternalProtocolController extends Controller
{
    private const INTERNAL_PROTOCOLS_DIRECTORY = "app/internal_protocols/";
    
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $practiceRepository;

    public function __construct (
        InternalProtocolRepositoryInterface $internalProtocolRepository,
        InternalPracticeRepositoryInterface $internalPracticeRepository,
        FamilyMemberRepositoryInterface $familyMemberRepository
    ) {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->internalPracticeRepository = $internalPracticeRepository;
        $this->familyMemberRepository = $familyMemberRepository;
    }

    /**
     * Displays a list of patient results
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        
        $request->validate([
            'initial_date' => 'date|nullable',
            'ended_date' => 'date|nullable',
            'internal_patient_id' => 'numeric|min:1|nullable',
        ]);
        
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $protocols = $this->internalProtocolRepository->getProtocolsForPatient($initial_date, $ended_date, $request->internal_patient_id);
        
        $user = auth()->user();

        $family_members = $user->family_members;
        
        return view('patients/protocols/index')
            ->with('family_members', $family_members)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date)
            ->with('protocols', $protocols)
            ->with('patient', $request->internal_patient_id);
    }
    
    //
    /**
     * Shows the protocol of a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $protocol = $this->internalProtocolRepository->findOrFail($id);

        return view('patients/protocols/show')
            ->with('protocol', $protocol);
    }

    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function generateProtocol($id)
    {
        $protocol = $this->internalProtocolRepository->findOrFail($id);

        $practices = $protocol->internalPractices;

        if (! empty($request->filter_practices)) {
            $practices = $practices->whereIn('id', $request->filter_practices);
        }
     
        $pdf = PDF::loadView('pdf.internal_protocols.modern_style', [
            'protocol' => $protocol,
            'practices' => $practices,
        ]);
        
        $protocol_path = storage_path(self::INTERNAL_PROTOCOLS_DIRECTORY."protocol_$protocol->id.pdf");
        $pdf->save($protocol_path);
       
        return $pdf->stream("protocol_$protocol->id");
    }
}
