<?php

namespace App\Http\Middleware;

use Closure;
use App;

class LangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // In case such session variable does not exist, the application will use by default the language defined in the config/app.php file
        App::setLocale(auth()->user()->lang ?? session('lang'));

        return $next($request);
    }
}
