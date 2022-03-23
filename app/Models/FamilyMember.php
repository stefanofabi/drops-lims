<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FamilyMember extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['user_id', 'patient_id'];

    /**
     * Get the patient associated with the family member.
     */
    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
