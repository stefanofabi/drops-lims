<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //

	protected $fillable = ['patient_id', 'phone', 'type'];
	
    protected function get_phones($id) {
    	return Phone::where('patient_id', $id)->get();
    }
}
