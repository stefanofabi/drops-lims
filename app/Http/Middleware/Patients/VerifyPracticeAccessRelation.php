<?php

namespace App\Http\Middleware\Patients;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

class VerifyPracticeAccessRelation
{
    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $internalPracticeRepository;
    
    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;
    
    public function __construct (
        InternalPracticeRepositoryInterface $internalPracticeRepository,
        FamilyMemberRepositoryInterface $familyMemberRepository
    ) {
        $this->internalPracticeRepository = $internalPracticeRepository;
        $this->familyMemberRepository = $familyMemberRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        $practice = $this->internalPracticeRepository->findOrFail($request->id);
       
        $protocol = $practice->internalProtocol;

        $this->familyMemberRepository->findFamilyMemberRelationOrFail(auth()->user()->id, $protocol->internal_patient_id);

        return $next($request);
    }
}
