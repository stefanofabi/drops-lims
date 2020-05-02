<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        User::insert([
            'name' => 'Admin',
            'email' => 'admin@company',
            'password' => Hash::make('password'),
        ]);

    }
}
