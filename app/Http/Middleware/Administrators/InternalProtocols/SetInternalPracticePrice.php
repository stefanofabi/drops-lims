<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\DeterminationRepositoryInterface;

class SetInternalPracticePrice
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\DeterminationRepositoryInterface */
    private $determinationRepository;

    public function __construct (InternalProtocolRepositoryInterface $internalProtocolRepository, DeterminationRepositoryInterface $determinationRepository)
    {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->determinationRepository = $determinationRepository;
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
        $protocol = $this->internalProtocolRepository->findOrFail($request->internal_protocol_id);

        $determination = $this->determinationRepository->findOrFail($request->determination_id);

        $request->request->add(['price' => $determination->biochemical_unit * $protocol->plan->nbu_price]);

        return $next($request);
    }
}
