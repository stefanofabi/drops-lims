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
        PracticeRepositoryInterface $practiceRepository
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->familyMemberRepository = $familyMemberRepository;
        $this->practiceRepository = $practiceRepository;
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

        return (new $strategyClass)->printProtocol($id, []);
    }

    /**
     * Returns a protocol partially in pdf format
     *
     * @return \Illuminate\Http\Response
     */
    public function printPartialReport(Request $request)
    {
        if (! is_array($request->to_print)) 
        {
            return Lang::get('errors.no_data');
        }

        $protocol = $this->practiceRepository->findOrFail($request->to_print[0])->protocol;

        $strategy = 'modern_style';
        $strategyClass = PrintOurProtocolContext::STRATEGIES[$strategy];
      
        return (new $strategyClass)->printProtocol($protocol->id, $request->to_print);
    }
}
