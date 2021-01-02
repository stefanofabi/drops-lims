<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Plan;

class SocialWork extends Model
{
    //

    /**
     * Get the emails for the patient.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

}
