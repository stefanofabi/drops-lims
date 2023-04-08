<?php 

namespace App\Traits;

trait GenerateReplacementVariables {

	public function generateReplacementVariables(array $array_vars) 
	{
		$replacement_vars = array();

        foreach ($array_vars as $var_name => $var_value)
        {
            
            $var_name = '${'.$var_name.'}';

            $replacement_vars = array_merge($replacement_vars, [$var_name => $var_value]);
        }

        return $replacement_vars;
	}
}