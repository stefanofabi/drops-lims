<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'is lab staff']);
        Permission::create(['name' => 'manage parameters']);
        Permission::create(['name' => 'manage roles']);
    	Permission::create(['name' => 'manage patients']);
    	Permission::create(['name' => 'manage prescribers']);
    	Permission::create(['name' => 'manage determinations']);
        Permission::create(['name' => 'manage reports']);
    	Permission::create(['name' => 'manage protocols']);
        Permission::create(['name' => 'print worksheets']);
    	Permission::create(['name' => 'print protocols']);
    	Permission::create(['name' => 'manage practices']);
    	Permission::create(['name' => 'sign practices']);
    	Permission::create(['name' => 'view statistics']);
    	Permission::create(['name' => 'generate security codes']);
        Permission::create(['name' => 'generate summaries']);
    	Permission::create(['name' => 'manage settings']);
        Permission::create(['name' => 'view logs']);


        Permission::create(['name' => 'is user']);

    }
}
