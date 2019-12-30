<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Patient;

class Human extends Model
{
    //
	protected $primaryKey = "patient_id";
	public $incrementing = false;


	protected function index($shunt, $filter, $offset, $length) {
		$patients = DB::table('patients')
		->join('humans', 'id', '=', 'patient_id')
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


	protected function count_index($shunt, $filter) {
		$count = DB::table('patients')
		->join('humans', 'id', '=', 'patient_id')
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

	public function patient() {
		return $this->belongsTo('App\Patient');
	}

}