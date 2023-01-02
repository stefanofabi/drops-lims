<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nbu_price',
        'social_work_id',
    ];

    /**
     * Get the nomenclator associated with the plan.
     */
    public function nomenclator()
    {
        return $this->belongsTo(Nomenclator::class);
    }

    /**
     * Get the social work associated with the plan.
     */
    public function social_work()
    {
        return $this->belongsTo(SocialWork::class);
    }
}
