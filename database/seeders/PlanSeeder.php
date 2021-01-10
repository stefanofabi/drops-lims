<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	Plan::insert([
    		[
    			'name' => 'Plan #1',
    			'nbu_price' => '65.0',
    			'social_work_id' => '1',
    			'nomenclator_id' => '1',
    		],
    		[
    			'name' => 'Plan #2',
    			'nbu_price' => '68.5',
    			'social_work_id' => '1',
    			'nomenclator_id' => '1',
    		],

    		[
    			'name' => 'Plan #3',
    			'nbu_price' => '50.5',
    			'social_work_id' => '2',
    			'nomenclator_id' => '2',
    		],
    	]);
    }
}
