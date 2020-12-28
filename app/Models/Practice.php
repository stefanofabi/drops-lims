<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    //

    public function protocol()
    {
        return $this->belongsTo('App\Models\Protocol');
    }

    public function report()
    {
		return $this->belongsTo('App\Models\Report');
	}

	public function results()
    {
        return $this->hasMany('App\Models\Result', 'practice_id');
    }

    public function signs()
    {
        return $this->hasMany('App\Models\SignPractice', 'practice_id');
    }

    public function scopeProtocol($query) {
        return $query->join('protocols', 'practices.protocol_id', '=', 'protocols.id');
    }
}
