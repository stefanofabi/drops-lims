
<?php
	function getAge($date) {
		$response = array(
			'day' => 0,
			'month' => 0,
			'year' => 0
		);

		if (!empty($date)) {
			$birth_date = new DateTime(date('Y/m/d', strtotime($date)));
			$date_today =  new DateTime(date('Y/m/d', time()));

			if ($date_today >= $birth_date) {
				$age = date_diff($date_today, $birth_date);

				$response['day'] = ceil($age->format('%d'));
				$response['month'] = ceil($age->format('%m'));
				$response['year'] =  ceil($age->format('%Y'));
			}
		}

		return $response;
	}


	function convert_to_pdf($html, $results) {
		$new_html = "";
		$i_result = 0;

		for ($i = 0; $i < strlen($html); $i++) {
			$start_input = strpos($html, "<input", $i);

			if ($start_input) {

				// remove input tag
				$new_html = $new_html."".copy_text($html, $i, $start_input);

				$end_input = strpos($html, ">", $start_input);

				if ($end_input) {
					$i = $end_input;

					// put the result
					if ($i_result < sizeof($results)) {
						$new_html = $new_html."".$results[$i_result]->result;
						$i_result++;
					}

				} else {
					// sintaxis error
					$new_html = "ERROR";
					break;
				}

			} else {
				// there are no more input
				$new_html = $new_html."".copy_text($html, $i, strlen($html));
				break;
			}
		}

		return $new_html;
	}


	function copy_text($text, $start, $end) {
		$copy = "";
		for ($i = $start; $i < $end; $i++) {
			$copy = $copy."".$text[$i];
		}

		return $copy;
	}

?>

<style>

	.cover {
		background: #FFFFA6;
		margin-left: 20px;
	}


	.cover td {
		width: 150mm;
	}

	.info {
		margin-left: 50px
	}

	.info td {
		text-align: left;
		width: 100mm;
	}

	.result-2 {
		width: 20mm;
		text-align: center;
		background: #E8E1D6;
	}

	.title {
		font-weight: bold;
		font-size: 16px;
	}

	hr {
		border: 0.5px;
	}

</style>

<page backtop="60mm" backbottom="50mm">
	<page_header>

		<img width="100" height="100" src="<?php echo public_path() ?>/img/logo.png" style="float: left">

		<table class="cover">
		    <tr>
		    	<td class="title"> Title 1 </td>
		    </tr>
		</table>

		<br />

		<table class="cover">
		    <tr>
		    	<td> Text 1 </td>
		    </tr>

		    <tr>
		    	<td> Text 2 </td>
		    </tr>

		    <tr>
		    	<td> Text 3 </td>
		    </tr>
		</table>

		<p />

		<table class="info">
			<tr>
		    	<td> <?php echo Lang::get('patients.patient').": $patient->full_name"; ?> </td>
		        <td> <?php echo Lang::get('protocols.protocol_number').": #". str_pad($protocol->id, 10, '0', STR_PAD_LEFT) ?> </td>
		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('patients.home_address').": $patient->address"; ?> </td>
		    	<td> <?php echo Lang::get('protocols.completion_date').": ".date_format(new DateTime($protocol->completion_date), 'd/m/Y'); ?> </td>

		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('prescribers.prescriber').": $prescriber->full_name"; ?> </td>

				<?php
		    		$array = getAge($patient->birth_date);
		    		if ($array['month'] == 0) {
		    			$result = 0;
		    		} else {
		    			$result = 1;
		    		}
		    	?>
		        <td> <?php echo Lang::get('patients.age').": ".trans_choice('patients.calculate_age', $result, $array); ?> </td>
		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('social_works.social_work').": $social_work->name"; ?> </td>
		    	<td> </td>
		    </tr>
		</table>
	</page_header>

    <page_footer>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left; width: 50%"> </td>
                <td style="text-align: right; width: 50%"> <?php echo Lang::get('forms.page') ?> [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>


</page>


<?php
	foreach ($practices as $practice) {
		$report = $practice->report->report;
		$results = $practice->results;

		if (!empty($report)) {
			echo "<nobreak>". convert_to_pdf($report, $results)." <hr style='margin-top: 5px; margin-bottom: 5px'> </nobreak>";
		}
	}
?>
