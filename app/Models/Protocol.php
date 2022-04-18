<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Protocol extends Model
{
    //

    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completion_date', 
        'observations',
        'private_notes',
        'closed',
    ];

    /**
     * Get the practices for the protocol.
     */
    public function practices()
    {
        return $this->hasMany(Practice::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
