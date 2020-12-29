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
        		'is_admin',
        		'crud_patients',
        		'crud_prescribers',
        		'crud_determinations',
        		'crud_reports',
        		'crud_protocols',
                'print_protocols'
        		'crud_practices',
        		'sign_practices',
        		'see_statistics',
        		'restore_items',
        		'generate_security_codes',
        		'settings',

        	]
        );

        $role_secretary->givePermissionTo(
        	[
        		'is_admin',
        		'crud_patients',
        		'crud_prescribers',
        		'crud_determinations',
        		'crud_protocols',
                'print_protocols',
        		'crud_practices',
        		'generate_security_codes',
        	]
        );

        $role_biochemical->givePermissionTo(
        	[
        		'is_admin',
        		'crud_determinations',
        		'crud_reports',
        		'crud_protocols',
                'print_protocols',
        		'crud_practices',
        		'sign_practices',
        	]
        );

        $role_patient->givePermissionTo(
            [
                'is_user'
            ]
        );

    }
}
