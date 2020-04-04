<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    //

    public function report() {
		return $this->belongsTo('App\Report');
	}

	public function results()
    {
        return $this->hasMany('App\Result', 'practice_id');
    }
}
