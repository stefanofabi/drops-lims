<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FamilyMember extends Model
{
    //

    use LogsActivity;

    protected $fillable = [
        'user_id', 
        'internal_patient_id'
    ];

    /**
     * Get the patient associated with the family member.
     */
    public function internalPatient() {
        return $this->belongsTo(InternalPatient::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
