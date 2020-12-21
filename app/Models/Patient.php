<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    //

    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

	protected function index($filter, $offset, $length, $type) {
		$patients = DB::table('patients')
		->where('type', $type)
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("full_name", "like", "%$filter%")
				->orWhere("key", "like", "$filter%")
				->orWhere("owner", "like", "%$filter%");
			}
		})
		->whereNull('deleted_at')
		->orderBy('full_name', 'asc')
		->offset($offset)
		->limit($length)
		->get();

		return $patients;
	}


	protected function count_index($filter, $type) {
		$count = DB::table('patients')
		->where('type', $type)
		->where(function ($query) use ($filter) {
			if (!empty($filter)) {
				$query->orWhere("full_name", "like", "%$filter%")
				->orWhere("key", "like", "$filter%")
				->orWhere("owner", "like", "%$filter%");
			}
		})
		->whereNull('deleted_at')
		->count();
		
		return $count;
	}    

	public function phone() {
		return $this->hasMany('App\Models\Phone');
	}
    
}
