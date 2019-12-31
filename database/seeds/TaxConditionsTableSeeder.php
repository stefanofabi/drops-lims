<?php

use Illuminate\Database\Seeder;
use App\TaxCondition;

class TaxConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        TaxCondition::insert([
            ['name' => 'Exento'],
            ['name' => 'Monotributo'],
            ['name' => 'No responsable'],
            ['name' => 'Responsable inscripto'],
        ]);
    }
}
