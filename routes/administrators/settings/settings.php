<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the settings
|
*/

use App\Http\Controllers\Administrators\Settings\SettingController;


Route::group([
    'prefix' => 'settings',
    'as' => 'settings/',
    'middleware' => 'permission:manage settings',
], function () {

    require('roles.php');
    require('billing_periods.php');
    require('nomenclators.php');
    require('social_works/social_works.php');
    require('system_parameters.php');
    require('users.php');
    require('bans.php');
    
    Route::controller(SettingController::class)
    ->group(function () {   
        Route::get('index', 'index')
            ->name('index');
            
    });
});
