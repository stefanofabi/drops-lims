<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InternalProtocol extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completion_date', 
        'observations',
        'private_notes',
        'closed',
        'internal_patient_id',
        'plan_id',
        'prescriber_id',
        'quantity_orders',
        'diagnostic',
        'billing_period_id',
    ];

    /**
     * Get the practices for the protocol.
     */
    public function internalPractices()
    {
        return $this->hasMany(InternalPractice::class);
    }

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
    public function internalPatient()
    {
        return $this->belongsTo(InternalPatient::class);
    }

    /**
     * Get the billing period associated with the our protocol.
     */
    public function billingPeriod()
    {
        return $this->belongsTo(BillingPeriod::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
