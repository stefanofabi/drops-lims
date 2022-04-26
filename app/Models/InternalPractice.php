<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\ConvertTrait;

class InternalPractice extends Model
{
    //

    use LogsActivity;
    
    use ConvertTrait; 
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'internal_protocol_id', 
        'determination_id', 
        'result',
        'price'
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

    public function print() {
 
        return $this->ConvertToPDF($this->determination->report,  json_decode($this->result));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
