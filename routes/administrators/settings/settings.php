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
], function () {

    require('nomenclators.php');
    require('statistics.php');
    require('social_works/social_works.php');

    Route::controller(SettingController::class)
    ->group(function () {   
        Route::get('index', 'index')
            ->name('index');
    
        Route::get('generate_reports', 'getGenerateReportsView')
            ->name('generate_reports');
    
        Route::post('protocols_report', 'getProtocolsReport')
            ->name('protocols_report');
    
        Route::post('patients_flow', 'getPatientsFlow')
            ->name('patients_flow');
    
        Route::post('debt_social_works', 'getDebtSocialWorks')
            ->name('debt_social_works');
    });

    Route::get('logs/system_logs', ['\Rap2hpoutre\LaravelLogViewer\LogViewerController', 'index'])
        ->name('system_logs')
        ->middleware('permission:system_logs');

    Route::get('logs/activity_logs', [ActivityViewerController::class, 'index'])
        ->name('activity_logs')
        ->middleware('permission:activity_logs');
});
