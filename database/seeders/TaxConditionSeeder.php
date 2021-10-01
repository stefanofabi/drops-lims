<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TaxCondition;

class TaxConditionSeeder extends Seeder
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
            ['name' => 'Exempt'],
            ['name' => 'Monotax'],
            ['name' => 'Not responsible'],
            ['name' => 'Registered Responsible'],
        ]);
    }
}
