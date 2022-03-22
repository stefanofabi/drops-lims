<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;

use Lang;

class VerifyFamilyMemberRelation
{
    /** @var \App\Contracts\Repository\FamilyMemberRepositoryInterface */
    private $familyMemberRepository;

    public function __construct (FamilyMemberRepositoryInterface $familyMemberRepository)
    {
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
        if (! isset($request->patient_id)) {
            return $next($request);
        }
        
        $this->familyMemberRepository->findFamilyMemberRelationOrFail(auth()->user()->id, $request->patient_id);

        return $next($request);
    }
}
