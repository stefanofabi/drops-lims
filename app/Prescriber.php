<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prescriber extends Model
{
    //

    protected function index($filter, $offset, $length) {
		$prescribers = DB::table('prescribers')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("full_name", "like", "%$filter%")
				->orWhere("provincial_enrollment", "like", "$filter%")
				->orWhere("national_enrollment", "like", "$filter%");
			}
		})
		->orderBy('full_name', 'asc')
		->offset($offset)
		->limit($length)
		->get();

		return $prescribers;
	}


	protected function count_index($filter) {
		$count = DB::table('prescribers')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("full_name", "like", "%$filter%")
				->orWhere("provincial_enrollment", "like", "$filter%")
				->orWhere("national_enrollment", "like", "$filter%");
			}
		})
		->count();

		return $count;
	}
}
