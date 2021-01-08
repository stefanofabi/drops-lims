<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SignPractice extends Model
{
    use HasFactory;

    use LogsActivity;

    protected $fillable = ['practice_id', 'user_id'];

    protected static $logFillable = true;

    /**
     * Get the user associated with the sign.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
