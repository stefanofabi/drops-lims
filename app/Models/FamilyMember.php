<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FamilyMember extends Model
{
    //

    protected function get_family($id)
    {
        return DB::table('family_members')
            ->select('family_members.patient_id', 'patients.full_name')
            ->join('patients', 'family_members.patient_id', '=', 'patients.id')
            ->where('family_members.user_id', $id)
            ->get();
    }

    protected function check_relation($user_id, $patient_id) {
        return DB::table('family_members')
            ->where('user_id', $user_id)
            ->where('patient_id', $patient_id)
            ->count();
    }
}
