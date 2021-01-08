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

    public function scopePlan($query)
    {
        return $query->join('plans', 'plans.id', '=', 'affiliates.plan_id');
    }

    public function scopeSocialWork($query)
    {
        return $query->join('social_works', 'social_works.id', '=', 'plans.social_work_id');
    }
}
