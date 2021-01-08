<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Result extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['practice_id', 'result'];

    protected static $logFillable = true;

}
