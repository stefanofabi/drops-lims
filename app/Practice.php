<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    //

    public function protocol()
    {
        return $this->belongsTo('App\Protocol');
    }

    public function report()
    {
		return $this->belongsTo('App\Report');
	}

	public function results()
    {
        return $this->hasMany('App\Result', 'practice_id');
    }

    public function scopeProtocol($query) {
        return $query->join('protocols', 'practices.protocol_id', '=', 'protocols.id');
    }
}
