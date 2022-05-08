<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

use App\Http\Controllers\Administrators\InternalProtocols\InternalPracticeController;

Route::controller(InternalPracticeController::class)
    ->prefix('internal_practices')
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

        Route::put('inform-result/{id}', 'informResult')
            ->name('inform_result')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_practice');

        Route::put('sign/{id}', 'sign')
            ->name('sign')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:sign_practices')
            ->middleware('verify_open_practice')
            ->middleware('verify_practice_has_result');

        Route::post('get-results/{id}', 'getResult')
            ->where('id', '[1-9][0-9]*')
            ->name('get_result');
    });