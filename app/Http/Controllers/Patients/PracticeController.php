<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Contracts\Repository\PracticeRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

class PracticeController extends Controller
{
    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;
    
    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;
    
    public function __construct (
        PracticeRepositoryInterface $practiceRepository,
        FamilyMemberRepositoryInterface $familyMemberRepository
    ) {
        $this->practiceRepository = $practiceRepository;
        $this->familyMemberRepository = $familyMemberRepository;
    }

    //
    /**
     * Generates the report in pdf format of a protocol
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $practice = $this->practiceRepository->findOrFail($id);
        
        return view('patients/protocols/practices/show')->with('practice', $practice);
    }

    /**
     * Returns the results of a practice
     *
     * @return \Illuminate\Http\Response
     */
    public function get_results(Request $request)
    {

        $practice = $this->practiceRepository->findOrFail($request->practice_id);
        
        return $practice->results->toJson();
    }
}
