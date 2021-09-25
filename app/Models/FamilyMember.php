<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    //

    protected $fillable = ['user_id', 'patient_id'];

    /**
     * Get the patient associated with the family member.
     */
    public function patient() {
        return $this->belongsTo(Patient::class);
    }
}
