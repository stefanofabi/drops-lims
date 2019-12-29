<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;

class Human extends Model
{
    //
	protected $primaryKey = "patient_id";
	public $incrementing = false;


	public function patient() {
		return $this->belongsTo('App\Patient');
	}

}