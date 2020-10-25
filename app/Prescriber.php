<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescriber extends Model
{
    //

	use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected function index($filter, $offset, $length) {
		$prescribers = DB::table('prescribers')
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("full_name", "like", "%$filter%")
				->orWhere("provincial_enrollment", "like", "$filter%")
				->orWhere("national_enrollment", "like", "$filter%");
			}
		})
		->whereNull('deleted_at')
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
		->whereNull('deleted_at')
		->count();

		return $count;
	}
}
