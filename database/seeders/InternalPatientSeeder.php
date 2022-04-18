<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\InternalPatient;

class InternalPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        InternalPatient::factory()->count(300)->create();
    }
}
