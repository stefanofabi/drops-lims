<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityCode extends Model
{
    //

    protected $fillable = ['patient_id', 'security_code', 'expiration_date'];

}
