<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SecurityCode extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['patient_id', 'security_code', 'expiration_date', 'used_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'security_code',
        'user_at',
    ];

    /**
     * Get the plan associated with the affiliate.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
