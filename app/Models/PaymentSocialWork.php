<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSocialWork extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['payment_date', 'social_work_id', 'billing_period_id', 'amount'];


    /**
     * Get the determination associated with the payment.
     */
    public function billing_period()
    {
        return $this->belongsTo('App\Models\BillingPeriod');
    }

    /**
     * Get the social work associated with the payment.
     */
    public function social_work()
    {
        return $this->belongsTo('App\Models\SocialWork');
    }
}
