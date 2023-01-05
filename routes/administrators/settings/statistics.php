<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the statistics
|
*/

use App\Http\Controllers\Administrators\Settings\StatisticsController;

Route::controller(StatisticsController::class)
    ->prefix('statistics')
    ->as('statistics/')
    ->middleware('permission:view statistics')
    ->group(function () {   

        Route::get('statistics', 'index')
            ->name('index');

        Route::get('annual_collection_social_work', 'getAnnualCollectionSocialWork')
            ->name('annual_collection_social_work');

        Route::get('patient_flow_per_month', 'getPatientFlowPerMonth')
            ->name('patient_flow_per_month');

        Route::get('track_income', 'getTrackIncome')
            ->name('track_income');
    });