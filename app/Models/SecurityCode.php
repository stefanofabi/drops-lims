<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SecurityCode extends Model
{
    //

    use LogsActivity;

    protected $fillable = [
        'internal_patient_id', 
        'security_code', 
        'expiration_date', 
        'used_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'security_code',
        'used_at',
    ];

    /**
     * Get the plan associated with the affiliate.
     */
    public function internalPatient()
    {
        return $this->belongsTo(InternalPatient::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logExcept(['security_code']);
    }
}
