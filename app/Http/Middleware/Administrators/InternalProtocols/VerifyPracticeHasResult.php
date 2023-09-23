<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use Lang;

class VerifyPracticeHasResult
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
        $practice = $this->internalPracticeRepository->findOrFail($request->id);

        if (! $practice->isInformed())
        {
            return redirect()->back()->withErrors(Lang::get('practices.practice_not_informed'));
        }    

        return $next($request);
    }
}
