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
use App\Http\Controllers\Administrators\Statistics\CollectionSocialWorkController;
use App\Http\Controllers\Administrators\Statistics\PatientFlowController;
use App\Http\Controllers\Administrators\Statistics\TrackIncomeController;

Route::group([
    'prefix' => 'statistics', 
    'as' => 'statistics/', 
    'middleware' => 'permission:view statistics'
], function() {

    Route::controller(StatisticsController::class)
    ->group(function () {

        Route::get('statistics', 'index')
        ->name('index');
    });

    Route::controller(CollectionSocialWorkController::class)
    ->prefix('collection-social-work')
    ->as('collection_social_work/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-graph', 'generateGraph')
            ->name('generate_graph');
    });

    Route::controller(PatientFlowController::class)
    ->prefix('patient-flow')
    ->as('patient_flow/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-graph', 'generateGraph')
            ->name('generate_graph');
    });
    
    Route::controller(TrackIncomeController::class)
    ->prefix('track-income')
    ->as('track_income/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-graph', 'generateGraph')
            ->name('generate_graph');
    });
});


