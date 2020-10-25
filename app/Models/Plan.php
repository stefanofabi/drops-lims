<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //

    public function nomenclator() {
		return $this->belongsTo('App\Nomenclator');
	}

	public function social_work() {
		return $this->belongsTo('App\SocialWork');
	}
	
}
