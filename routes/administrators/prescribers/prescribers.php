<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the prescribers
|
*/

Route::get('prescribers', [
    '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
    'index',
])->name('prescribers')->middleware('permission:crud_prescribers');
Route::post('prescribers/load', [
    '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
    'load',
])->name('prescribers/load')->middleware('permission:crud_prescribers');

Route::group([
    'middleware' => 'permission:crud_prescribers',
    'prefix' => 'prescribers',
    'as' => 'prescribers/',
], function () {
    Route::get('show/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'show',
    ])->name('show')->where('id', '[1-9][0-9]*');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'store',
    ])->name('store');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Prescribers\PrescriberController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');
    
});
