<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class OurProtocol extends Model
{
    //

    use LogsActivity;

    protected $primaryKey = "protocol_id";

    public $incrementing = false;

    protected $fillable = [
        'protocol_id',
        'patient_id',
        'plan_id',
        'prescriber_id',
        'quantity_orders',
        'diagnostic',
        'billing_period_id',
    ];

    protected static $logFillable = true;

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
     * Get the protocol associated with the our protocol.
     */
    public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    /**
     * Get the billing period associated with the our protocol.
     */
    public function billing_period()
    {
        return $this->belongsTo(BillingPeriod::class);
    }
}
