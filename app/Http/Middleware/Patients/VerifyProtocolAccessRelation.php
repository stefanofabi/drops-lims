<?php

namespace App\Http\Middleware\Patients;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

class VerifyProtocolAccessRelation
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    public function __construct (InternalProtocolRepositoryInterface $internalProtocolRepository, FamilyMemberRepositoryInterface $familyMemberRepository)
    {
        $this->internalProtocolRepository = $internalProtocolRepository;
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
        $id = $request->id ?? $request->internal_protocol_id;

        $protocol = $this->internalProtocolRepository->findOrFail($id);

        $this->familyMemberRepository->findFamilyMemberRelationOrFail(auth()->user()->id, $protocol->internal_patient_id);

        return $next($request);
    }
}
