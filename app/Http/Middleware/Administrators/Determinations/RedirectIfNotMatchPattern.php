<?php

namespace App\Http\Middleware\Administrators\Determinations;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Lang;

class RedirectIfNotMatchPattern
{
    // represents any letter (upper or lower case), number, or underscore.
    const PATTERN = "/^[a-zA-Z0-9_]+$/";

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'template_variables' => 'required|array',
        ]);

        foreach ($request->template_variables as $var_name => $var_value) 
        {
            
            if (! preg_match(self::PATTERN, $var_name))
            {
                return redirect()->back()->withErrors(Lang::get('determinations.templates_variables_not_match_pattern'));
            }
        }

        return $next($request);
    }
}
