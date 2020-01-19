<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    //

    protected function get_social_works($id) {
    	$my_social_works = Affiliate::select('affiliates.id as id', 'social_works.name as social_work', 'plans.name as plan', 'affiliates.affiliate_number as affiliate_number', 'affiliates.security_code as security_code', 'affiliates.expiration_date as expiration_date')
    	->where('patient_id', $id)
    	->join('plans', 'affiliates.plan_id', '=', 'plans.id')
    	->join('social_works', 'plans.social_work_id', '=', 'social_works.id')
    	->get();

    	return $my_social_works;
    }
}
