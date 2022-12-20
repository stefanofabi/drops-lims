<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Prescriber extends Model
{
    //

    use HasFactory;

    use LogsActivity;

    protected $fillable = [
        'name',
        'last_name', 
        'phone', 
        'email', 
        'provincial_enrollment', 
        'national_enrollment',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
