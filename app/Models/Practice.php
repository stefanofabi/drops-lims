<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\ConvertTrait;

class Practice extends Model
{
    //

    use LogsActivity;
    
    use ConvertTrait; 
    
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

    public function print() {
 
        return $this->ConvertToPDF($this->report->report, $this->results);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
