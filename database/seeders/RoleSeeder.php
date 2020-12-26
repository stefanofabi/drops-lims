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
        		'internal_management',
        		'crud_patients',
        		'crud_prescribers',
        		'crud_determinations',
        		'crud_reports',
        		'crud_protocols',
        		'crud_practices',
        		'sign_protocols',
        		'see_statistics',
        		'restore_items',
        		'generate_security_code',
        		'settings',

        	]
        );

        $role_secretary->givePermissionTo(
        	[
        		'internal_management',
        		'crud_patients',
        		'crud_prescribers',
        		'crud_determinations',
        		'crud_protocols',
        		'crud_practices',
        		'generate_security_code',
        	]
        );

        $role_biochemical->givePermissionTo(
        	[
        		'internal_management',
        		'crud_determinations',
        		'crud_reports',
        		'crud_protocols',
        		'crud_practices',
        		'sign_protocols',
        	]
        );

    }
}
