<?php

use Illuminate\Database\Seeder;
use App\Human;

class HumansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $humans = factory(Human::class, 100)->create();
    }
}
