<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    //

    protected $fillable = ['protocol_id', 'report_id', 'amount'];

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
     * Get the results for the determination.
     */
    public function results()
    {
        return $this->hasMany(Result::class, 'practice_id');
    }

    /**
     * Get the signs for the determination.
     */
    public function signs()
    {
        return $this->hasMany(SignPractice::class);
    }

    public function scopeProtocol($query)
    {
        return $query->join('protocols', 'practices.protocol_id', '=', 'protocols.id');
    }
}
