<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

use App\Http\Controllers\Administrators\Protocols\PracticeController;

Route::controller(PracticeController::class)
    ->prefix('practices')
    ->as('practices/')
    ->group(function () {
        Route::get('create', 'create')
            ->name('create');

        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::post('store', 'store')
            ->name('store')
            ->middleware('verify_open_protocol');
        
        Route::get('destroy/{id}', 'destroy')
            ->name('destroy')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_practice');

        Route::post('find', 'loadPractices')
            ->name('load_practices');

        Route::put('inform_results/{practice_id}', 'informResults')
            ->name('inform_results')
            ->where('practice_id', '[1-9][0-9]*')
            ->middleware('verify_open_practice');

        Route::put('sign/{practice_id}', 'sign')
            ->name('sign')
            ->where('practice_id', '[1-9][0-9]*')
            ->middleware('permission:sign_practices')
            ->middleware('verify_open_practice');

        Route::post('results', 'getResults')
            ->name('results');
    });