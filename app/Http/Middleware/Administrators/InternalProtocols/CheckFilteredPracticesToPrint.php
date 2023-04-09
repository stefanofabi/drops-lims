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
        $request->validate([
            'filter_practices' => 'array|nullable',
        ]);

        $protocol = $this->internalProtocolRepository->findOrFail($request->id);
        
        $protocol_practices = $protocol->internalPractices
            ->map(function ($practice) {
                return $practice->id;
            })->toArray();

        $practices_to_check = (isset($request->filter_practices)) ? $request->filter_practices : $protocol_practices;

        foreach ($practices_to_check as $practice) 
        {
            if (isset($request->filter_practices) && ! in_array($practice, $protocol_practices)) 
            {
                // Practice that does not belong to the protocol was detected

                die(Lang::get('protocols.practice_detected_not_belong_protocol')); 
            }

            if ($this->internalPracticeRepository->findOrFail($practice)->signInternalPractices->isEmpty())
            {
                die(Lang::get('practices.practice_not_signed')); 
            }
        }

        return $next($request);
    }
}
