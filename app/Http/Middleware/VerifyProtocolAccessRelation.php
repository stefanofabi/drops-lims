<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\FamilyMemberRepositoryInterface;

class VerifyProtocolAccessRelation
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    public function __construct (ProtocolRepositoryInterface $protocolRepository, FamilyMemberRepositoryInterface $familyMemberRepository)
    {
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

        $protocol = $this->protocolRepository->findOrFail($request->id);

        $this->familyMemberRepository->findFamilyMemberRelationOrFail(auth()->user()->id, $protocol->patient->id);

        return $next($request);
    }
}
