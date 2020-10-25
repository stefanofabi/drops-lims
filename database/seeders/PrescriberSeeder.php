<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Prescriber;

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
        Prescriber::factory()->count(300)->create();
    }
}
