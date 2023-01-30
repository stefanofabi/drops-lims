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
use App\Http\Controllers\Administrators\Summaries\DebtSocialWorkController;
use App\Http\Controllers\Administrators\Summaries\PatientFlowController;
use App\Http\Controllers\Administrators\Summaries\ProtocolsSummaryController;

Route::group([
    'prefix' => 'summaries', 
    'as' => 'summaries/', 
    'middleware' => 'permission:generate summaries'
], function() {

    Route::controller(SummaryController::class)
    ->group(function () {

        Route::get('statistics', 'index')
        ->name('index');
    });

    Route::controller(DebtSocialWorkController::class)
    ->group(function () {

        Route::get('debt-social-works', 'index')
        ->name('debt_social_works');

        Route::post('generate-debt-social-work', 'generateSummary')
        ->name('generate_debt_social_work');
    });

    Route::controller(PatientFlowController::class)
    ->group(function () {

        Route::get('patient-flow', 'index')
        ->name('patient_flow');

        Route::post('generate-patient-flow', 'generateSummary')
        ->name('generate_patient_flow');
    });

    Route::controller(ProtocolsSummaryController::class)
    ->group(function () {

        Route::get('protocols-summary', 'index')
        ->name('protocols_summary');

        Route::post('generate-protocols-summary', 'generateSummary')
        ->name('generate_protocols_summary');
    });

});