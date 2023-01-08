<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the summaries
|
*/

use App\Http\Controllers\Administrators\Summaries\SummaryController;

Route::controller(SummaryController::class)
->prefix('summaries')
->as('summaries/')
->group(function () {   
    Route::get('index', 'index')
        ->name('index');

    Route::post('protocols-summary', 'getProtocolsSummary')
        ->name('protocols_summary');

    Route::post('patients_flow', 'getPatientsFlow')
        ->name('patients_flow');

    Route::post('debt_social_works', 'getDebtSocialWorks')
        ->name('debt_social_works');
});