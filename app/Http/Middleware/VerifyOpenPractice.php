<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Contracts\Repository\PracticeRepositoryInterface;

use Lang;

class VerifyOpenPractice
{
    /** @var \App\Contracts\Repository\PracticeRepositoryInterface */
    private $practiceRepository;

    public function __construct (PracticeRepositoryInterface $practiceRepository)
    {
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

        $id = isset($request->id) ? $request->id : $request->practice_id;
    
        $practice = $this->practiceRepository->findOrFail($id);

        if (! empty($practice->protocol->closed)) 
        {
            if ($request->ajax())
            {
                return response()->json(['message' => Lang::get('protocols.protocol_closed_message')], 500);
            } else 
            {
                return redirect()->back()->withErrors(Lang::get('protocols.protocol_closed_message'));
            }
        }

        return $next($request);
    }
}
