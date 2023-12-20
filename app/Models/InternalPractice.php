<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\GenerateReplacementVariables;

class InternalPractice extends Model
{
    //

    use LogsActivity;
    
    use GenerateReplacementVariables;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'internal_protocol_id', 
        'determination_id',
        'result',
        'result_template',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'result' => 'json',
    ];

    /**
     * Get the protocol associated with the practice.
     */
    public function internalProtocol()
    {
        return $this->belongsTo(InternalProtocol::class);
    }

    /**
     * Get the determination associated with the practice.
     */
    public function determination()
    {
        return $this->belongsTo(Determination::class);
    }

    /**
     * Get the signs for the practice.
     */
    public function signInternalPractices()
    {
        return $this->hasMany(SignInternalPractice::class);
    }

    /**
     * Get html result
     */
    public function print()
    {
        return $this->result_template;
    }

    /**
     * Returns true if the practice contains reported results, false otherwise.
     */
    public function isInformed()
    {
        return ! empty($this->result);
    }

    public function getReplacementResultVariables() 
    {
        return $this->generateReplacementVariables($this->result);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
