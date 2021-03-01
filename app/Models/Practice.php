<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Practice extends Model
{
    //

    use LogsActivity;
    
    protected $fillable = ['protocol_id', 'report_id', 'amount'];

    protected static $logFillable = true;

    /**
     * Get the protocol associated with the practice.
     */
    public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    /**
     * Get the report associated with the practice.
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Get the results for the practice.
     */
    public function results()
    {
        return $this->hasMany(Result::class, 'practice_id');
    }

    /**
     * Get the signs for the practice.
     */
    public function signs()
    {
        return $this->hasMany(SignPractice::class);
    }
}
