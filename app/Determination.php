<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Determination extends Model
{
    //
	protected function index($nbu_id, $filter, $offset, $length) {
		$determination = DB::table('determinations')
		->where('nomenclator_id', '=', $nbu_id)
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("name", "like", "%$filter%")
				->orWhere("code", "like", "$filter%");
			}
		})
		->orderBy('code', 'asc')
		->orderBy('name', 'asc')
		->offset($offset)
		->limit($length)
		->get();

		return $determination;
	}


	protected function count_index($nbu_id, $filter) {
		$count = DB::table('determinations')
		->where('nomenclator_id', '=', $nbu_id)
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("name", "like", "%$filter%")
				->orWhere("code", "like", "$filter%");
			}
		})
		->count();

		return $count;
	}

	public function nomenclator() {
		return $this->belongsTo('App\Nomenclator');
	}
}
