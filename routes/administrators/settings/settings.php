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
use App\Http\Controllers\Administrators\Settings\ActivityViewerController;

Route::group([
    'prefix' => 'settings',
    'as' => 'settings/',
    'middleware' => 'permission:manage settings',
], function () {

    require('nomenclators.php');
    require('social_works/social_works.php');

    Route::controller(SettingController::class)
    ->group(function () {   
        Route::get('index', 'index')
            ->name('index');
            
    });

    Route::get('logs/system_logs', ['\Rap2hpoutre\LaravelLogViewer\LogViewerController', 'index'])
        ->name('system_logs')
        ->middleware('permission:view system logs');

    Route::get('logs/activity_logs', [ActivityViewerController::class, 'index'])
        ->name('activity_logs')
        ->middleware('permission:view activity logs');
});
