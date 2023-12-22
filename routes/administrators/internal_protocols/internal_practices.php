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
    ->middleware('permission:manage practices')
    ->group(function () {
        Route::get('index', 'index')
            ->name('index');

        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::post('store', 'store')
            ->name('store')
            ->middleware('verify_open_protocol')
            ->middleware('set_internal_practice_price');
        
        Route::get('destroy/{id}', 'destroy')
            ->name('destroy')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_practice')
            ->middleware('verify_if_practice_signed_by_another');

        Route::post('load-practices', 'loadPractices')
            ->name('load_practices');

        Route::post('get-results/{id}', 'getResult')
            ->where('id', '[1-9][0-9]*')
            ->name('get_result');

        Route::put('inform-result/{id}', 'informResult')
            ->name('inform_result')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_practice')
            ->middleware('verify_if_practice_signed_by_another');

        Route::put('sign/{id}', 'sign')
            ->name('sign')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:sign practices')
            ->middleware('verify_open_practice')
            ->middleware('verify_practice_has_result');
    });