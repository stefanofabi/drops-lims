<?php

namespace App\Http\Middleware\Administrators\InternalProtocols;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Contracts\Repository\InternalPracticeRepositoryInterface;

use Lang;

class VerifyIfPracticeIsSignedByAnother
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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = isset($request->id) ? $request->id : $request->internal_practice_id;
    
        $practice = $this->internalPracticeRepository->findOrFail($id);

        $user = auth()->user();
            
        if ($user->hasPermissionTo('change result'))
            return $next($request);

        $another_signs = $practice->signInternalPractices->where('user_id', '<>', $user->id);
        
        if ($another_signs->isNotEmpty()) 
        {
            // Someone else signed the practice and I cannot modify it
            return redirect()->back()->withErrors(Lang::get('practices.not_have_permission_to_modify_practices_already_signed'));
        }

        // I have only signed it therefore I can continue
        return $next($request);
    }
}
