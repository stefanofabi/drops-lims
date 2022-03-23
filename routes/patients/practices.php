<?php

Route::group([
    'prefix' => 'practices',
    'as' => 'practices/',
], function () {

    Route::get('show/{id}', ['\App\Http\Controllers\Patients\PracticeController', 'show',])
    ->name('show')
    ->where('id', '[1-9][0-9]*')
    ->middleware('verify_practice_access_relation');

    Route::post('get_results', ['\App\Http\Controllers\Patients\PracticeController', 'getResults',])
    ->name('get_results')
    ->middleware('verify_practice_access_relation');
});