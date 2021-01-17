<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the settings
|
*/

Route::group([
    'prefix' => 'settings',
    'as' => 'settings/',
], function () {

    require('nomenclators.php');
    require('social_works.php');

    Route::get('logs/system_logs', [
        '\Rap2hpoutre\LaravelLogViewer\LogViewerController',
        'index',
    ])->name('system_logs')->middleware('permission:system_logs');

    Route::get('logs/activity_logs', [
        '\App\Http\Controllers\Administrators\Settings\ActivityViewerController',
        'index',
    ])->name('activity_logs')->middleware('permission:activity_logs');

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'index',
    ])->name('index');

});
