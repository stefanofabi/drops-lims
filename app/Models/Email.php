<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //

    protected function get_emails($id) {
    	return Email::where('patient_id', $id)->get();
    }
}
