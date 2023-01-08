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
->middleware('permission:generate summaries')
->group(function () {   
    Route::get('index', 'index')
        ->name('index');

    Route::get('protocols-summary', 'getProtocolsSummaryView')
        ->name('protocols_summary');

    Route::post('get-protocols-summary', 'getProtocolsSummary')
        ->name('get_protocols_summary');

    Route::get('patients-flow', 'getPatientsFlowView')
        ->name('patients_flow');

    Route::post('get-patients-flow', 'getPatientsFlow')
        ->name('get_patients_flow');

    Route::get('debt-social-works', 'getDebtSocialWorksView')
        ->name('debt_social_works');

    Route::post('get-debt-social-works', 'getDebtSocialWorks')
        ->name('get_debt_social_works');
});