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


        $role_administrator = Role::create(['name' => 'Administrator']);
        $role_secretary = Role::create(['name' => 'Secretary']);
        $role_biochemical = Role::create(['name' => 'Biochemical']);

        $role_patient = Role::create(['name' => 'Patient']);


        $role_administrator->givePermissionTo(
        	[
        		'is lab staff',
                'manage roles',
        		'manage patients',
        		'manage prescribers',
        		'manage determinations',
                'manage templates',
        		'manage protocols',
                'print worksheets',
                'print protocols',
        		'manage practices',
        		'sign practices',
                'change result',
        		'view statistics',
        		'generate security codes',
                'generate summaries',
                'manage profile',
        		'manage settings',
                'manage system parameters',
                'manage users',
                'manage bans',
                'view logs',
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
                'generate summaries',
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
                'is patient'
            ]
        );

    }
}
