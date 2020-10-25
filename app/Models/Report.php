<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //

    public function determination() {
		return $this->belongsTo('App\Determination');
	}

	public function scopeDetermination($query) {
		return $query->join('determinations', 'determinations.id', '=', 'reports.determination_id');
	}
}
