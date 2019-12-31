<?php

use Illuminate\Database\Seeder;
use App\Industrial;

class IndustrialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Industrial::class, 100)->create();
    }
}
