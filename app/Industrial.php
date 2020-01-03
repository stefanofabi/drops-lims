<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Patient;

class Industrial extends Model
{
    //

	protected $primaryKey = "patient_id";
	public $incrementing = false;


	protected function index($filter, $offset, $length) {
		$patients = DB::table('patients')
		->join('industrials', 'id', '=', 'patient_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere('name', "like", "%$filter%")
				->orWhere('cuit', "like", "%$filter%");
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
		->join('industrials', 'id', '=', 'patient_id')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere('name', "like", "%$filter%")
				->orWhere('cuit', "like", "%$filter%");
			}
		})
		->count();

		return $count;
	}

	public function patient() {
		return $this->belongsTo('App\Patient');
	}
}
