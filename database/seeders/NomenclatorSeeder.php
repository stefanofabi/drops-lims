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
            ['name' => 'Nomenclator #1'],
            ['name' => 'Nomenclator #2'],
            ['name' => 'Nomenclator #3'],
        ]);
    }
}
