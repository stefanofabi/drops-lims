<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Plan;

class SocialWork extends Model
{
    //

    /**
     * Get the plans for the social work.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

}
