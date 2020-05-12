<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OurProtocol extends Protocol
{
    //
    protected $primaryKey = "protocol_id";
	public $incrementing = false;


	public function plan() {
		return $this->belongsTo('App\Plan');
	}

	public function prescriber() {
		return $this->belongsTo('App\Prescriber');
	}

	public function patient() {
		return $this->belongsTo('App\Patient');
	}

	public function scopeProtocol($query) {
		return $query->join('protocols', 'our_protocols.protocol_id', '=', 'protocols.id');
	}

	public function scopePlan($query) {
		return $query->join('plans', 'our_protocols.plan_id', '=', 'plans.id');
	}

	public function scopeSocial_Work($query) {
		return $query->join('social_works', 'plans.social_work_id', '=', 'social_works.id');
	}

}
