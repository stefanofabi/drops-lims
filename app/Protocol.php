<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Protocol extends Model
{
    //

    protected function index($filter, $offset, $length) {

    	/* ID - DATE - PATIENT_ID - PATIENT - TYPE */
	 	$derived_protocols = DB::table('protocols')
		->join('derived_protocols', 'protocols.id', '=', 'derived_protocols.protocol_id')
		->join('derived_patients', 'derived_protocols.patient_id', '=', 'derived_patients.id')
		->select('protocols.id', 'protocols.date', 'derived_patients.id as patient_id', 'derived_patients.full_name as patient', DB::raw('"derived" as type'));


		$protocols = DB::table('our_protocols')
		->join('patients', 'patients.id', '=', 'our_protocols.patient_id')
		->join('protocols', 'protocols.id', '=', 'our_protocols.protocol_id')
		->select('protocols.id', 'protocols.date as date', 'patients.id as patient_id', 'patients.full_name as patient', DB::raw('"our" as type'))
		->union($derived_protocols);


		return $protocols->get();
	}


	protected function count_index($filter) {
		/*$count = DB::table('patients')
		->join('humans', 'id', '=', 'patient_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere(DB::raw('CONCAT(last_name, " ", name)'), "like", "%$filter%")
				->orWhere('dni', "like", "$filter%");
			}
		})
		->count();
		*/
		return 50;
	}

}
