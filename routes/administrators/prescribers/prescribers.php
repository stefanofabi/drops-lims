<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the prescribers
|
*/

Route::group([
    'middleware' => 'permission:crud_prescribers',
    'prefix' => 'prescribers',
    'as' => 'prescribers/',
], function () {

    Route::get('index', ['\App\Http\Controllers\Administrators\Prescribers\PrescriberController', 'index'])
    ->name('index');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');
    
    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');
    
    Route::post('load-prescribers', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'loadPrescribers',
    ])->name('load_prescribers');

});
