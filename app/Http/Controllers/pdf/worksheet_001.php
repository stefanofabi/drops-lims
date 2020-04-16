
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

?>

<style>
	td {
		width: 100mm;
	}
</style>

<page backtop="40mm" backbottom="50mm"> 
	<page_header>
		<table>
			<tr>
		    	<td> <?php echo Lang::get('patients.patient').": $patient->full_name"; ?> </td>
		        <td> <?php echo Lang::get('protocols.protocol_number').": #". str_pad($protocol->id, 10, '0', STR_PAD_LEFT) ?> </td>
		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('patients.dni').": $patient->key"; ?> </td>

		    	<?php
		    		$array = getAge($patient->birth_date);
		    		if ($array['month'] == 0) {
		    			$result = 0;
		    		} else {
		    			$result = 1;
		    		}
		    	?>
		        <td> <?php echo Lang::get('protocols.completion_date').": ".date_format(new DateTime($protocol->completion_date), 'd/m/Y'); ?> </td>
		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('patients.home_address').": $patient->address"; ?> </td>
			    
				<td> <?php echo Lang::get('patients.age').": ".trans_choice('patients.calculate_age', $result, $array); ?> </td>
		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('prescribers.prescriber').": $prescriber->full_name"; ?> </td>
		        <td> 
		        	<?php 
		        		echo Lang::get('patients.sex').": "; 
		        		switch ($patient->sex) {
		        			case 'M': {
		        				echo Lang::get('patients.male');
		        				break;
		        			}
		        			case 'F': {
		        				echo Lang::get('patients.female');
		        				break;
		        			}

		        			default: {
		        				echo Lang::get('patients.undefined');
		        				break;
		        			}
		        		}

		        	?> 

					</td>
		    </tr>

		    <tr>
		    	<td> <?php echo Lang::get('social_works.social_work').": $social_work->name"; ?> </td>
		        <td> 
		        	<?php 

						echo Lang::get('phones.phone').": ";
				
			    		if (!empty($phone)) {
			    			 echo "$phone->phone ($phone->type)";
			    		} else {
			    			echo "N/A";
			    		}
			    	?> 
		    	</td>
		    </tr>
		</table>

		<br />
			<?php 
				if (!empty($protocol->diagnostic)) {
					echo Lang::get('protocols.diagnostic').": $protocol->diagnostic";
				}
			?>
		
	</page_header>

    <page_footer>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left; width: 50%"> <?php echo Lang::get('protocols.worksheet') ?> </td>
                <td style="text-align: right; width: 50%"> <?php echo Lang::get('forms.page') ?> [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>


</page>


<?php
	foreach ($practices as $practice) {
		echo "<nobreak> <p> ".$practice->report->determination->name."</p> ============================================ <br /> </nobreak> ";
	}
?>