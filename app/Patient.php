<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //

	/**
    * Get the shunt record associated with the patient.
    */
    public function shunt()
    {
    	return $this->belongsTo('App\Shunt');
    }
}
