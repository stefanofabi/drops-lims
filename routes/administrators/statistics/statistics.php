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

Route::get('statistics', [
    StatisticsController::class,
    'index',
])->name('statistics')->middleware('permission:see_statistics');

Route::group([
    'middleware' => 'permission:see_statistics',
    'prefix' => 'statistics',
    'as' => 'statistics/',
], function () {

    Route::post('annual_collection_social_work', [
        StatisticsController::class,
        'annual_collection_social_work',
    ])->name('annual_collection_social_work');

    Route::post('patient_flow_per_month', [
        StatisticsController::class,
        'patient_flow_per_month',
    ])->name('patient_flow_per_month');

    Route::post('track_income', [StatisticsController::class, 'track_income'])->name('track_income');
});
