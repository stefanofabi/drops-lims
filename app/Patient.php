<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    //
    public $timestamps = false;

	protected function show_patients($patient_type, $shunt, $filter, $offset, $length) {
		$patients = DB::table('patients')
		->join($patient_type, 'id', '=', 'patient_id')
		->where('shunt_id', $shunt)
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere(DB::raw('CONCAT(surname, " ", name)'), "like", "%$filter%")
				->orWhere('dni', "like", "$filter%");
			}
		})
		->orderBy('surname', 'asc')
		->orderBy('name', 'asc')
		->offset($offset)
		->limit($length)
		->get();

		return $patients;
	}


	protected function count_patients($patient_type, $shunt, $filter) {
		$count = DB::table('patients')
		->join($patient_type, 'id', '=', 'patient_id')
		->where('shunt_id', $shunt)
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere(DB::raw('CONCAT(surname, " ", name)'), "like", "%$filter%")
				->orWhere('dni', "like", "$filter%");
			}
		})
		->count();

		return $count;
	}
}
