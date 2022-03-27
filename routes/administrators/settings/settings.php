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
    require('statistics.php');
    require('social_works/social_works.php');

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'index',
    ])->name('index');

    Route::get('generate_reports', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'getGenerateReportsView',
    ])->name('generate_reports');

    Route::post('protocols_report', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'getProtocolsReport',
    ])->name('protocols_report');

    Route::post('patients_flow', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'getPatientsFlow',
    ])->name('patients_flow');

    Route::post('debt_social_works', [
        '\App\Http\Controllers\Administrators\Settings\SettingController',
        'getDebtSocialWorks',
    ])->name('debt_social_works');

    Route::get('logs/system_logs', [
        '\Rap2hpoutre\LaravelLogViewer\LogViewerController',
        'index',
    ])->name('system_logs')->middleware('permission:system_logs');

    Route::get('logs/activity_logs', [
        '\App\Http\Controllers\Administrators\Settings\ActivityViewerController',
        'index',
    ])->name('activity_logs')->middleware('permission:activity_logs');
});
