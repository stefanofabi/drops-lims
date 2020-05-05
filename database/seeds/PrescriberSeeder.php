<?php

use Illuminate\Database\Seeder;
use App\Prescriber;

class PrescriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Prescriber::class, 100)->create();
    }
}
