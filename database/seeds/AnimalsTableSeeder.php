<?php

use Illuminate\Database\Seeder;
use App\Animal;

class AnimalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Animal::class, 100)->create();
    }
}
