<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    //

    protected function get_social_works($id) {
    	$my_social_works = Affiliate::select('affiliates.id as id', 'social_works.name as social_work', 'plans.name as plan', 'affiliates.affiliate_number as affiliate_number', 'affiliates.expiration_date as expiration_date')
    	->plan()
    	->socialWork()
        ->where('patient_id', $id)
    	->get();

    	return $my_social_works;
    }


    public function scopePlan($query) {
		return $query->join('plans', 'plans.id', '=', 'affiliates.plan_id');
	}

    public function scopeSocialWork($query) {
        return $query->join('social_works', 'social_works.id', '=', 'plans.social_work_id');
    }
}
