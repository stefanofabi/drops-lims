<?php

namespace App\Http\Middleware\Administrators\Settings\Roles;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Lang;

class UniqueEnvironment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $environments = array('is lab staff', 'is patient');

        $count = 0;

        foreach ($environments as $environment) {
            if (in_array($environment, $request->permissions)) 
            {
                $count++;
            }
        }

        if ($count != 1) 
        {
            return redirect()->back()->withErrors(Lang::get('roles.only_one_environment'));
        }

        return $next($request);
    }
}
