<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Contracts\Repository\UserRepositoryInterface;

class UserSeeder extends Seeder
{
    /** @var \App\Contracts\Repository\UserRepositoryInterface */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $user_administrator = $this->userRepository->create(
            [
                'name' => 'Admin',
                'last_name' => 'Lab',
                'email' => 'admin@laboratory',
                'password' => Hash::make('password'),
            ]
        );

        $user_administrator->assignRole('Administrator');


        $user_patient = $this->userRepository->create(
            [
                'name' => 'Patient',
                'last_name' => 'Lab',
                'email' => 'patient@domain',                        
                'password' => Hash::make('password'),
            ]
        );

        $user_patient->assignRole('Patient');

    }
}
