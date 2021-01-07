<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

Route::get('protocols', [
    '\App\Http\Controllers\Administrators\Protocols\ProtocolController',
    'index',
])->name('protocols')->middleware('permission:crud_protocols');

Route::post('protocols', [
    '\App\Http\Controllers\Administrators\Protocols\ProtocolController',
    'load',
])->name('protocols/load')->middleware('permission:crud_protocols');

Route::group([
    'middleware' => 'permission:crud_protocols',
    'prefix' => 'protocols',
    'as' => 'protocols/',
], function () {

    require('practices.php');

    Route::group([
        'prefix' => 'our',
        'as' => 'our/',
    ], function () {

        Route::post('load_patients', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'load_patients',
        ])->name('load_patients');

        Route::post('load_prescribers', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'load_prescribers',
        ])->name('load_prescribers');

        Route::get('add_practices/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'add_practices',
        ])->name('add_practices')->where('id', '[1-9][0-9]*');

        Route::get('create', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'create',
        ])->name('create');

        Route::post('create', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'create',
        ])->name('create');

        Route::post('store', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'store',
        ])->name('store');

        Route::get('show/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'show',
        ])->name('show')->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'update',
        ])->name('update')->where('id', '[1-9][0-9]*');

        Route::get('edit/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'edit',
        ])->name('edit')->where('id', '[1-9][0-9]*');

        Route::get('destroy/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'destroy',
        ])->name('destroy')->where('id', '[1-9][0-9]*');

        Route::get('print_worksheet/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'print_worksheet',
        ])->name('print_worksheet')->where('id', '[1-9][0-9]*')->middleware('permission:print_worksheets');

        Route::get('print/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'print_protocol',
        ])->name('print')->where('id', '[1-9][0-9]*')->middleware('permission:print_protocols');
    });
});
