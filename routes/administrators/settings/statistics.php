<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the statistics
|
*/

Route::get('statistics', [
    '\App\Http\Controllers\Administrators\Settings\StatisticsController',
    'index',
])->name('statistics')->middleware('permission:see_statistics');

Route::group([
    'middleware' => 'permission:see_statistics',
    'prefix' => 'statistics',
    'as' => 'statistics/',
], function () {

    Route::post('annual_collection_social_work', [
        '\App\Http\Controllers\Administrators\Settings\StatisticsController',
        'getAnnualCollectionSocialWork',
    ])->name('annual_collection_social_work');

    Route::post('patient_flow_per_month', [
        '\App\Http\Controllers\Administrators\Settings\StatisticsController',
        'getPatientFlowPerMonth',
    ])->name('patient_flow_per_month');

    Route::post('track_income', [
        '\App\Http\Controllers\Administrators\Settings\StatisticsController',
        'getTrackIncome',
    ])->name('track_income');
});
