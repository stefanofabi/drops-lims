<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        $role_administrator = Role::create(['name' => 'administrator']);
        $role_secretary = Role::create(['name' => 'secretary']);
        $role_biochemical = Role::create(['name' => 'biochemical']);

        $role_patient = Role::create(['name' => 'patient']);
    }
}
