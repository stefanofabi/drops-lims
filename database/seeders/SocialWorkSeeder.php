<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SocialWork;

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
            ['name' => 'Social work #1'],
            ['name' => 'Social work #2'],
            ['name' => 'Social work #3'],
            ['name' => 'Social work #4'],
        ]);
    }
}
