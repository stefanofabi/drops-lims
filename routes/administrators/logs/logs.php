<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the logs
|
*/

use App\Http\Controllers\Administrators\Logs\ActivityViewerController;

Route::get('logs/activity_logs', [ActivityViewerController::class, 'index'])
    ->name('logs/activity_logs')
    ->middleware('permission:view logs');

Route::get('logs/system_logs', ['\Rap2hpoutre\LaravelLogViewer\LogViewerController', 'index'])
    ->name('logs/system_logs')
    ->middleware('permission:view logs');