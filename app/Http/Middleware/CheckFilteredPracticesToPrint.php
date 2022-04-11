<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\ProtocolRepositoryInterface;
use App\Contracts\Repository\PracticeRepositoryInterface;

use App\Models\Protocol;

use Lang;

class CheckFilteredPracticesToPrint
{
    /** @var \App\Contracts\Repository\ProtocolRepositoryInterface */
    private $protocolRepository;

    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

    public function __construct (
        ProtocolRepositoryInterface $protocolRepository,
        PracticeRepositoryInterface $practiceRepository
    ) {
        $this->protocolRepository = $protocolRepository;
        $this->practiceRepository = $practiceRepository;
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
        $protocol = $this->protocolRepository->findOrFail($request->id);
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

            if ($this->practiceRepository->findOrFail($practice)->signs->isEmpty())
            {
                die(Lang::get('practices.practice_not_signed')); 
            }
        }

        if (! $need_verify_filter) $request->filter_practices = array();

        return $next($request);
    }

    private function getPracticesIdForProtocol(Protocol $protocol)
    {
        $protocol_practices = array();

        foreach ($protocol->practices as $practice)
        {
            array_push($protocol_practices, $practice->id);
        }

        return $protocol_practices;
    }
}
