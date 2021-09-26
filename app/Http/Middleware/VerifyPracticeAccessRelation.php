<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\PracticeRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

class VerifyPracticeAccessRelation
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

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $practice = $this->practiceRepository->findOrFail($request->id);
       
        $patient = $practice->protocol->patient;

        if (! $this->familyMemberRepository->verifyRelation(auth()->user()->id, $patient->id)) 
        {
            return redirect()->back()->withErrors(Lang::get('errors.not_found'));
        }

        return $next($request);
    }
}
