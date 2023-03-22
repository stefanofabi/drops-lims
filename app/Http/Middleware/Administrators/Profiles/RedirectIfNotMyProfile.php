<?php

namespace App\Http\Middleware\Administrators\Profiles;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Lang;

class RedirectIfNotMyProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->id != $request->id)
        {
            return redirect()->back()->withErrors(Lang::get('profiles.you_cant_access_another_user_profile'));
        }

        return $next($request);
    }
}
