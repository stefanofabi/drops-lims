<?php

use Illuminate\Database\Seeder;
use App\SocialWork;

class SocialWorksTableSeeder extends Seeder
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
