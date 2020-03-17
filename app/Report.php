<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //

    public function determination() {
		return $this->belongsTo('App\Determination');
	}
}
