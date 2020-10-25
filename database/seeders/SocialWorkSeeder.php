<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\SocialWork;

class SocialWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SocialWork::insert([
            ['name' => 'Swiss Medical'],
            ['name' => 'OSDE'],
            ['name' => 'Galeno'],
            ['name' => 'Medife'],
        ]);
    }
}
