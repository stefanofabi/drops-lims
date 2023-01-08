<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the statistics
|
*/

use App\Http\Controllers\Administrators\Statistics\StatisticsController;

Route::controller(StatisticsController::class)
    ->prefix('statistics')
    ->as('statistics/')
    ->middleware('permission:view statistics')
    ->group(function () {   

        Route::get('statistics', 'index')
            ->name('index');

        Route::get('annual-collection-social-work', 'getViewAnnualCollectionSocialWork')
            ->name('annual_collection_social_work');

        Route::post('get-annual-collection-social-work', 'getAnnualCollectionSocialWork')
            ->name('get_annual_collection_social_work');

        Route::get('patient-flow_per-month', 'getViewPatientFlowPerMonth')
            ->name('patient_flow_per_month');
            
        Route::post('get-patient-flow_per-month', 'getPatientFlowPerMonth')
            ->name('get_patient_flow_per_month');

        Route::get('track-income', 'getViewTrackIncome')
            ->name('track_income');
        
        Route::post('get-track-income', 'getTrackIncome')
            ->name('get_track_income');
    });