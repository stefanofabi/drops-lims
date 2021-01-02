<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamilyMember extends Model
{
    //

    protected $fillable = ['user_id', 'patient_id'];

    /**
     * Get the nomenclator associated with the determination.
     */
    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    protected function check_relation($user_id, $patient_id) {
        return DB::table('family_members')
            ->where('user_id', $user_id)
            ->where('patient_id', $patient_id)
            ->count();
    }
}
