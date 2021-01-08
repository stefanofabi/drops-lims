<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Phone extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['patient_id', 'phone', 'type'];

    protected static $logFillable = true;

}
