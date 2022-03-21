<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Protocol extends Model
{
    //

    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completion_date', 
        'observations',
        'type',
    
        // Our protocols
        'patient_id',
        'plan_id',
        'prescriber_id',
        'quantity_orders',
        'diagnostic',
        'billing_period_id',

        // Derived protocols
        'derived_patient_id',
        'reference',
    ];

    /**
     * Get the plan associated with the our protocol.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the prescriber associated with the our protocol.
     */
    public function prescriber()
    {
        return $this->belongsTo(Prescriber::class);
    }

    /**
     * Get the patient associated with the our protocol.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the billing period associated with the our protocol.
     */
    public function billingPeriod()
    {
        return $this->belongsTo(BillingPeriod::class);
    }

    /**
     * Get the practices for the protocol.
     */
    public function practices()
    {
        return $this->hasMany(Practice::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
