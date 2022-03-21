<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    //

    use HasFactory;

    use LogsActivity;

    protected $fillable = [
        'full_name',
        'identification_number',
        'sex',
        'birth_date',
        'city',
        'address',
        'phone',
        'alternative_phone',
        'email',
        'alternative_email',

        // For humans
        'plan_id',
        'affiliate_number',
        'security_code',
        'expiration_date',

        // For animals
        'owner',

        // For industrials
        'business_name',
        'tax_condition_id',
        'start_activity',

        'type',
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

        $date = $this->birth_date;

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
