<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\PlanRepositoryInterface;

use Lang;

class CheckNomenclatorWhenUpdatingInternalProtocol
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\PlanRepositoryInterface */
    private $planRepository;

    public function __construct (InternalProtocolRepositoryInterface $internalProtocolRepository, PlanRepositoryInterface $planRepository)
    {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->planRepository = $planRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $protocol = $this->internalProtocolRepository->findOrFail($request->id);

        $new_plan = $this->planRepository->findOrFail($request->plan_id);

        // it is necessary to verify that the nomenclator is the same to avoid that a protocol contains different nomenclator practices
        if ($protocol->internalPractices->isNotEmpty() && $protocol->plan->nomenclator_id != $new_plan->nomenclator_id) 
        {
            return redirect()->back()->withErrors(Lang::get('protocols.error_modifying_social_work'));     
        }

        return $next($request);
    }
}
