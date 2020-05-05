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
            [
                'name' => 'Admin',
                'email' => 'admin@company',
                'password' => Hash::make('password'),
                'is_admin' => true,
                ],
            [
                'name' => 'User',
                'email' => 'user@domain',                        
                'password' => Hash::make('password'),
                'is_admin' => 0,
            ]
        ]);

    }
}
