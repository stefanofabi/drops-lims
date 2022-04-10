<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;
use App\Contracts\Repository\PracticeRepositoryInterface;

use App\Laboratory\Prints\Protocols\Our\PrintOurProtocolContext;

use Lang;

class ProtocolController extends Controller
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository,
        FamilyMemberRepositoryInterface $familyMemberRepository,
        PracticeRepositoryInterface $practiceRepository,
        PrintOurProtocolContext $printOurProtocolContext
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->familyMemberRepository = $familyMemberRepository;
        $this->practiceRepository = $practiceRepository;
        $this->printOurProtocolContext = $printOurProtocolContext;
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
            'patient_id' => 'numeric|min:1|nullable',
        ]);
        
        $initial_date = $request->initial_date;
        $ended_date = $request->ended_date;

        $protocols = $this->protocolRepository->getProtocolsForPatient($initial_date, $ended_date, $request->patient_id);

        $user = auth()->user();

        $family_members = $user->family_members;
        
        return view('patients/protocols/index')
            ->with('family_members', $family_members)
            ->with('initial_date', $initial_date)
            ->with('ended_date', $ended_date)
            ->with('protocols', $protocols)
            ->with('patient', $request->patient_id);
    }
    
    //
    /**
     * Shows the protocol of a patient
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $protocol = $this->protocolRepository->findOrFail($id);

        return view('patients/protocols/show')
            ->with('protocol', $protocol);
    }

    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function printProtocol($id)
    {
        $user_id = auth()->user()->id;

        $protocol = $this->protocolRepository->findOrFail($id);

        $strategy = 'modern_style';
        $strategyClass = PrintOurProtocolContext::STRATEGIES[$strategy];

        $this->printOurProtocolContext->setStrategy(new $strategyClass($protocol, []));

        return $this->printOurProtocolContext->print();
    }

    /**
     * Returns a protocol partially in pdf format
     *
     * @return \Illuminate\Http\Response
     */
    public function printPartialReport(Request $request)
    {
        $protocol = $this->practiceRepository->findOrFail($request->to_print[0])->protocol;

        $strategy = 'modern_style';
        $strategyClass = PrintOurProtocolContext::STRATEGIES[$strategy];

        $this->printOurProtocolContext->setStrategy(new $strategyClass($protocol, $request->to_print));

        return $this->printOurProtocolContext->print();
    }
}
