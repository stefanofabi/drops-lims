<?php

use App\Http\Controllers\Patients\InternalPracticeController;

Route::controller(InternalPracticeController::class)
->prefix('practices')
->as('practices/')
->group(function () {

    Route::get('index', 'index')
        ->name('index')
        ->middleware('verify_protocol_access_relation');

    Route::get('show/{id}', 'show')
        ->name('show')
        ->where('id', '[1-9][0-9]*')
        ->middleware('verify_practice_access_relation')
        ->middleware('redirect_if_practice_not_signed');

    Route::post('get_results', 'getResults')
        ->name('get_results')
        ->middleware('verify_practice_access_relation')
        ->middleware('redirect_if_practice_not_signed');
});