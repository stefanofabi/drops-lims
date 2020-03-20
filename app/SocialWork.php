<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Plan;

class SocialWork extends Model
{
    //

    protected function get_plans($social_work) {
    	return Plan::where('social_work_id', $social_work)->get();
    }

}
