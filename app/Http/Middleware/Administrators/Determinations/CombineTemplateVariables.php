<?php

namespace App\Http\Middleware\Administrators\Determinations;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CombineTemplateVariables
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'variable_names' => 'required|array',
            'variable_values' => 'required|array',
        ]);

        // we reassemble the array
        $template_variables = array_combine($request->variable_names, $request->variable_values);

        foreach ($template_variables as $var_name => $var_value) 
        {
            if (empty($var_name) || empty($var_value)) 
            {
                unset($template_variables[$var_name]);
            }
        }

        // add the reassembled array to the request
        $request->request->add(['template_variables' => $template_variables]);
        
        // we eliminate the auxiliary variables
        $request->request->remove('variable_names');
        $request->request->remove('variable_values');

        return $next($request);
    }
}
