<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Nomenclator;

class NomenclatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Nomenclator::insert([
            ['name' => 'NBU PMO v2012'],
            ['name' => 'NBU PMO v2016'],
            ['name' => 'NBU PMO v2020'],
        ]);
    }
}
