<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Prescriber extends Model
{
    //

    use HasFactory;

    use LogsActivity;

    protected $fillable = [
        'full_name', 
        'phone', 
        'email', 
        'provincial_enrollment', 
        'national_enrollment',
    ];

    protected static $logFillable = true;

}
