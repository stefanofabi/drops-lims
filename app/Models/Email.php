<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Email extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['email', 'patient_id'];

    protected static $logFillable = true;
}
