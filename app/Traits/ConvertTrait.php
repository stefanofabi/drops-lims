<?php 

namespace App\Traits;

trait ConvertTrait {

	public function ConvertToPDF($html, $results) {
		$keys_to_find = array('<input', '<select');

		$new_html = "";
		$last_find = 0;

		$i_result = 0;

		for ($i = 0; $i < strlen($html); $i++) 
		{			
			$found = false;

			// Find the opening of a tag
			if ($html[$i] == '<') 
			{
				// Check if it is one of my tags
				foreach($keys_to_find as $start_find) 
				{
					$start_input = strpos($html, $start_find, $i);

					// The string was found
					// $start_find es mi proximo input
					if ($start_input !== false && $start_input == $i) 
					{
						
							$found = true;

							switch ($start_find) {
								case '<input': {
									$end_find = ">";
	
									break;
								}
	
								case '<select': {
									$end_find = "</select>";	
									
									break;
								}
							}

							$end_input = strpos($html, $end_find, $start_input);
							
							if ($end_input !== false) {
								$i = $end_input;

								// Base case when the end of the tag contains more than one character
								if (strlen($end_find) > 1) $i += strlen($end_find) - 1;
			
								// put the result
								if ($i_result < sizeof($results)) {
									$new_html = $new_html."".$results[$i_result];
									$i_result++;
								} else {
									$new_html = $new_html."NO RESULT";
								}

								$last_find = $i;
							} else {
								// sintaxis error
								$new_html = "ERROR";
								break;
							}

							break;
					}
				}
			}

			if (! $found) {
				$last_find = $i;
				$new_html .= $html[$i];
			}
		}

		return $new_html;
	}

    private function copyText($text, $start, $end) {
		$copy = "";
		for ($i = $start; $i < $end; $i++) {
			$copy = $copy."".$text[$i];
		}

		return $copy;
	}

}