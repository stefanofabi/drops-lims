<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InternalPatient extends Model
{
    //

    use HasFactory;

    use LogsActivity;

    protected $fillable = [
        'name',
        'last_name',
        'identification_number',
        'sex',
        'birthdate',
        'city',
        'address',
        'phone',
        'alternative_phone',
        'email',
        'alternative_email',
        'plan_id',
        'affiliate_number',
        'security_code',
        'expiration_date',
    ];

    /**
     * Get the plan associated with the affiliate.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    
    /**
     * Get the security code associated with the patient.
     */
    public function securityCode()
    {
        return $this->hasOne(SecurityCode::class);
    }

    public function age()
    {

        $age = null;

        $date = $this->birthdate;

        if (! empty($date)) {
            $birth_date = new \DateTime(date('Y/m/d', strtotime($date)));
            $date_today = new \DateTime(date('Y/m/d', time()));

            if ($date_today >= $birth_date) {
                $diff = date_diff($date_today, $birth_date);

                $age = [
                    'day' => ceil($diff->format('%d')),
                    'year' => ceil($diff->format('%Y')),
                    'month' => ceil($diff->format('%m')),
                ];
            }
        }

        return $age;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
