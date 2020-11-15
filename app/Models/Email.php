<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //

	protected $fillable = ['email', 'patient_id'];

    protected function get_emails($patient_id) {
    	return Email::where('patient_id', $patient_id)->get();
    }
}
