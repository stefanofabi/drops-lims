<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurProtocol extends Protocol
{
    //
    protected $primaryKey = "protocol_id";

    public $incrementing = false;

    protected $fillable = ['protocol_id', 'patient_id', 'plan_id', 'prescriber_id', 'quantity_orders', 'diagnostic'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function prescriber()
    {
        return $this->belongsTo(Prescriber::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    public function scopeProtocol($query)
    {
        return $query->join('protocols', 'our_protocols.protocol_id', '=', 'protocols.id');
    }

    public function scopePlan($query)
    {
        return $query->join('plans', 'our_protocols.plan_id', '=', 'plans.id');
    }

    public function scopeSocial_Work($query)
    {
        return $query->join('social_works', 'plans.social_work_id', '=', 'social_works.id');
    }

    public function scopePatient($query)
    {
        return $query->join('patients', 'our_protocols.patient_id', '=', 'patients.id');
    }

    public function scopePrescriber($query)
    {
        return $query->join('prescribers', 'our_protocols.prescriber_id', '=', 'prescribers.id');
    }
}
