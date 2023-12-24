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
            return redirect()->back()->withErrors(Lang::get('users.you_cannot_delete_your_own_account'));
        }

        return $next($request);
    }
}
