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
use App\Http\Controllers\Administrators\Statistics\SocialWorkCompositionController;
use App\Http\Controllers\Administrators\Statistics\SexCompositionController;

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
    
        Route::post('generate-chart', 'generateChart')
            ->name('generate_chart');
    });

    Route::controller(PatientFlowController::class)
    ->prefix('patient-flow')
    ->as('patient_flow/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-chart', 'generateChart')
            ->name('generate_chart');
    });
    
    Route::controller(TrackIncomeController::class)
    ->prefix('track-income')
    ->as('track_income/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-chart', 'generateChart')
            ->name('generate_chart');
    });

    Route::controller(SocialWorkCompositionController::class)
    ->prefix('social-work-composition')
    ->as('social_work_composition/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-chart', 'generateChart')
            ->name('generate_chart');
    });

    Route::controller(SexCompositionController::class)
    ->prefix('sex-composition')
    ->as('sex_composition/')
    ->group(function () {   
    
        Route::get('index', 'index')
            ->name('index');
    
        Route::post('generate-chart', 'generateChart')
            ->name('generate_chart');
    });
});


