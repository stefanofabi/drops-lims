<?php

namespace App\Http\Middleware\Administrators\Settings\Users;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Lang;

class CheckIfNotMe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // I can't remove myself
        if ($user->id == $request->id) 
        {
            if($request->ajax()) 
                return response()->json(['message' => Lang::get('users.you_cannot_perform_operation_on_your_own_account')], 302);
            
            return redirect()->back()->withErrors(Lang::get('users.you_cannot_perform_operation_on_your_own_account'));
        }

        return $next($request);
    }
}
