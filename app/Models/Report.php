<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //

    protected $fillable = ['name', 'report', 'determination_id'];

    public function determination() {
		return $this->belongsTo('App\Models\Determination');
	}

	public function scopeDetermination($query) {
		return $query->join('determinations', 'determinations.id', '=', 'reports.determination_id');
	}
}
