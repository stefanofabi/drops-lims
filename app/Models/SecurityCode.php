<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityCode extends Model
{
    //

    /**
     * Get the plan associated with the affiliate.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
