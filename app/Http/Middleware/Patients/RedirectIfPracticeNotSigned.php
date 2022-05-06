<?php

namespace App\Http\Middleware\Patients;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use Lang;

class RedirectIfPracticeNotSigned
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

        if ($practice->signInternalPractices->isEmpty())
        {
            if ($request->ajax())
            {
                return response()->json(['message' => Lang::get('practices.practice_not_signed')], 500);
            } else 
            {
                return redirect()->back()->withErrors(Lang::get('practices.practice_not_signed'));
            }
        }

        return $next($request);
    }
}
