<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Plan;

class SocialWork extends Model
{
    //

    protected function get_plans($social_work) {
    	return Plan::where('social_work_id', $social_work)->get();
    }

}
