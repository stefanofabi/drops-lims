<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Affiliate extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['patient_id', 'plan_id', 'affiliate_number', 'expiration_date', 'security_code'];

    protected static $logFillable = true;

    /**
     * Get the plan associated with the affiliate.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
