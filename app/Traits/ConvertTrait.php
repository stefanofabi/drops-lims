<?php 

namespace App\Traits;

trait ConvertTrait {

	public function ConvertToPDF($html, $results) {
		$new_html = "";
		$i_result = 0;

		for ($i = 0; $i < strlen($html); $i++) {
			$start_input = strpos($html, "<input", $i);

			if ($start_input) {

				// remove input tag
				$new_html = $new_html."".$this->copyText($html, $i, $start_input);

				$end_input = strpos($html, ">", $start_input);

				if ($end_input) {
					$i = $end_input;

					// put the result
					if ($i_result < sizeof($results)) {
						$new_html = $new_html."".$results[$i_result];
						$i_result++;
					}

				} else {
					// sintaxis error
					$new_html = "ERROR";
					break;
				}

			} else {
				// there are no more input
				$new_html = $new_html."".$this->copyText($html, $i, strlen($html));
				break;
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