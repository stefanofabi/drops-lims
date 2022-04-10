<?php

namespace App\Http\Middleware\Patients;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

use Lang;

class VerifyPartialReportRelation
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository,
        FamilyMemberRepositoryInterface $familyMemberRepository
    ) {
        $this->protocolRepository = $protocolRepository;
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
        $user_id = auth()->user()->id;
        $filter_practices = $request->filter_practices;

        if (! is_array($filter_practices))
        {
            die(Lang::get('protocols.select_practices_to_print'));
        }

        $family_members = $this->familyMemberRepository->getFamilyMembers(auth()->user()->id);
     
        // Verify that the selected practices belong to the same protocol and that the patient is linked
        if (! $this->protocolRepository->verifyPractices($filter_practices, $family_members)) 
        {
            die(Lang::get('errors.practice_error_protocol'));
        }

        return $next($request);
    }
}
