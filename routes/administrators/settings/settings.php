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

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'index',
    ])->name('index');

    Route::get('generate_reports', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'generate_reports',
    ])->name('generate_reports');

    Route::post('protocols_report', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'protocols_report',
    ])->name('protocols_report');

    Route::post('patients_flow', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'patients_flow',
    ])->name('patients_flow');

    Route::get('logs/system_logs', [
        '\Rap2hpoutre\LaravelLogViewer\LogViewerController',
        'index',
    ])->name('system_logs')->middleware('permission:system_logs');

    Route::get('logs/activity_logs', [
        '\App\Http\Controllers\Administrators\Settings\ActivityViewerController',
        'index',
    ])->name('activity_logs')->middleware('permission:activity_logs');
});
