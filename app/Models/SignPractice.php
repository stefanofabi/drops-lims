<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SignPractice extends Model
{
    use HasFactory;

    use LogsActivity;

    protected $fillable = ['practice_id', 'user_id'];

    /**
     * Get the user associated with the sign.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
