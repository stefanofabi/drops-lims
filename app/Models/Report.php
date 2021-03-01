<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Report extends Model
{
    //

    use LogsActivity;

    protected $fillable = ['name', 'report', 'determination_id'];

    protected static $logFillable = true;

    /**
     * Get the determination associated with the report.
     */
    public function determination()
    {
        return $this->belongsTo('App\Models\Determination');
    }
}
