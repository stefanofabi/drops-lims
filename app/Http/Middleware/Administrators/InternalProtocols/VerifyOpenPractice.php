<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use Lang;

class VerifyOpenPractice
{
    /** @var \App\Contracts\Repository\InternalPracticeRepositoryInterface */
    private $internalPracticeRepository;

    public function __construct (InternalPracticeRepositoryInterface $internalPracticeRepository)
    {
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

        $id = isset($request->id) ? $request->id : $request->internal_practice_id;
    
        $practice = $this->internalPracticeRepository->findOrFail($id);

        if ($practice->internalProtocol->isClosed())
        {
            return redirect()->back()->withErrors(Lang::get('protocols.protocol_closed_message'));
        }

        return $next($request);
    }
}
