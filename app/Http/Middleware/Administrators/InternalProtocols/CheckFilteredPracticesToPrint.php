<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalProtocolRepositoryInterface;
use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use App\Models\InternalProtocol;

use Lang;

class CheckFilteredPracticesToPrint
{
    /** @var \App\Contracts\Repository\InternalProtocolRepositoryInterface */
    private $internalProtocolRepository;

    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $internalPracticeRepository;

    public function __construct (
        InternalProtocolRepositoryInterface $internalProtocolRepository,
        InternalPracticeRepositoryInterface $internalPracticeRepository
    ) {
        $this->internalProtocolRepository = $internalProtocolRepository;
        $this->internalPracticeRepository = $internalPracticeRepository;
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
        $protocol_practices = $this->getPracticesIdForProtocol($protocol);
        $need_verify_filter = true;

        if (! isset($request->filter_practices) || ! is_array($request->filter_practices) || empty($request->filter_practices)) {
            $need_verify_filter = false;
            $request->filter_practices = $protocol_practices;
        }
        
        foreach ($request->filter_practices as $practice) 
        {
            if ($need_verify_filter && ! in_array($practice, $protocol_practices)) 
            {
                // Practice that does not belong to the protocol was detected

                die(Lang::get('protocols.practice_detected_not_belong_protocol')); 
            }

            if ($this->internalPracticeRepository->findOrFail($practice)->signInternalPractices->isEmpty())
            {
                die(Lang::get('practices.practice_not_signed')); 
            }
        }

        if (! $need_verify_filter) $request->filter_practices = array();

        return $next($request);
    }

    private function getPracticesIdForProtocol(InternalProtocol $protocol)
    {
        $protocol_practices = array();

        foreach ($protocol->internalPractices as $practice)
        {
            array_push($protocol_practices, $practice->id);
        }

        return $protocol_practices;
    }
}
