<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Patient;

class Animal extends Model
{
    //
    protected $primaryKey = "patient_id";
	public $incrementing = false;


	protected function index($filter, $offset, $length) {
		$patients = DB::table('patients')
		->join('animals', 'id', '=', 'patient_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere('name', "like", "%$filter%")
				//->orWhere('dni', "like", "$filter%")
				->orWhere('owner', "like", "%$filter%");
			}
		})
		->orderBy('name', 'asc')
		->offset($offset)
		->limit($length)
		->get();

		return $patients;
	}


	protected function count_index($filter) {
		$count = DB::table('patients')
		->join('animals', 'id', '=', 'patient_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere('name', "like", "%$filter%")
				//->orWhere('dni', "like", "$filter%")
				->orWhere('owner', "like", "%$filter%");
			}
		})
		->count();

		return $count;
	}

	public function patient() {
		return $this->belongsTo('App\Patient');
	}
}
