<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

class InternalPracticeController extends Controller
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $internalPracticeRepository;
    
    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;
    
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
     * Displays a list of protocol practices
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $protocol = $this->internalProtocolRepository->findOrFail($request->internal_protocol_id);
        
        return view('patients/protocols/practices/index')
            ->with('protocol', $protocol);
    }

    //
    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $practice = $this->internalPracticeRepository->findOrFail($id);
        
        return view('patients.protocols.practices.show')
            ->with('practice', $practice);
    }

    /**
     * Returns the results of a practice
     *
     * @return \Illuminate\Http\Response
     */
    public function getResults(Request $request)
    {
        
        $practice = $this->internalPracticeRepository->find($request->id);
        
        return $practice->result;
    }
}
