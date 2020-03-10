<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ShuntsTableSeeder::class);
        
        $this->call(PatientsTableSeeder::class);

        $this->call(PrescribersTableSeeder::class);

        $this->call(NomenclatorsTableSeeder::class);

        $this->call(SocialWorksTableSeeder::class);
        
        $this->call(PlansTableSeeder::class);
    }
}
