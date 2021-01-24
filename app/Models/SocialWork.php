<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialWork extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the plans for the social work.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    /**
     * Get the payments for the social work.
     */
    public function payments()
    {
        return $this->hasMany(PaymentSocialWork::class);
    }
}
