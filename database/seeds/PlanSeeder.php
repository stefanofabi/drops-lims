<?php

use Illuminate\Database\Seeder;
use App\Plan;

class PlansTableSeeder extends Seeder
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
    			'name' => 'SB01',
    			'nbu_price' => '65.0',
    			'social_work_id' => '1',
    			'nomenclator_id' => '1',
    		],
    		[
    			'name' => 'SB02',
    			'nbu_price' => '68.5',
    			'social_work_id' => '1',
    			'nomenclator_id' => '1',
    		],

    		[
    			'name' => 'Plata',
    			'nbu_price' => '50.5',
    			'social_work_id' => '2',
    			'nomenclator_id' => '2',
    		],
    	]);
    }
}
