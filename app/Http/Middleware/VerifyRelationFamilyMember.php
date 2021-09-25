<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\FamilyMemberRepositoryInterface;

use Lang;

class VerifyRelationFamilyMember
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
        $user = auth()->user();
        $patient_id = $request->patient_id;
       
        $exists = $this->familyMemberRepository->verifyRelation($user->id, $patient_id);

        // we check if the user really has a related family member
        if (! $exists) {
            return redirect()->back()->withErrors(Lang::get('errors.not_found'));
        }

        return $next($request);
    }
}
