<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignPractice extends Model
{
    use HasFactory;

    protected $fillable = ['practice_id', 'user_id'];

    /**
     * Get the user associated with the sign.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
