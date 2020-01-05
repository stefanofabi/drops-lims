<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prescriber extends Model
{
    //

    protected function index($filter, $offset, $length) {
		$patients = DB::table('prescribers')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere(DB::raw('CONCAT(last_name, " ", name)'), "like", "%$filter%")
				->orWhere('provincial_enrollment', "like", "$filter%")
				->orWhere('national_enrollment', "like", "$filter%");
			}
		})
		->orderBy('last_name', 'asc')
		->orderBy('name', 'asc')
		->offset($offset)
		->limit($length)
		->get();

		return $patients;
	}


	protected function count_index($filter) {
		$count = DB::table('prescribers')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere(DB::raw('CONCAT(last_name, " ", name)'), "like", "%$filter%")
				->orWhere('provincial_enrollment', "like", "$filter%")
				->orWhere('national_enrollment', "like", "$filter%");
			}
		})
		->count();

		return $count;
	}
}
