<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

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


        $role_administrator->givePermissionTo(
        	[
        		'is lab staff',
        		'manage patients',
        		'manage prescribers',
        		'manage determinations',
                'manage reports',
        		'manage protocols',
                'print worksheets',
                'print protocols',
        		'manage practices',
        		'sign practices',
        		'view statistics',
        		'generate security codes',
        		'manage settings',
                'view system logs',
                'view activity logs',
        	]
        );

        $role_secretary->givePermissionTo(
        	[
        		'is lab staff',
        		'manage patients',
        		'manage prescribers',
        		'manage determinations',
        		'manage protocols',
                'print worksheets',
                'print protocols',
        		'manage practices',
        		'generate security codes',
        	]
        );

        $role_biochemical->givePermissionTo(
        	[
        		'is lab staff',
        		'manage determinations',
        		'manage protocols',
                'print worksheets',
                'print protocols',
        		'manage practices',
        		'sign practices',
        	]
        );

        $role_patient->givePermissionTo(
            [
                'is user'
            ]
        );

    }
}
