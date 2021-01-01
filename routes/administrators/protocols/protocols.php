<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

use App\Http\Controllers\Administrators\Protocols\ProtocolController;
use App\Http\Controllers\Administrators\Protocols\OurProtocolController;

Route::get('protocols', [
    ProtocolController::class,
    'index',
])->name('protocols')->middleware('permission:crud_protocols');

Route::post('protocols', [
    ProtocolController::class,
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

        Route::post('load_patients', [OurProtocolController::class, 'load_patients'])->name('load_patients');
        Route::post('load_prescribers', [OurProtocolController::class, 'load_prescribers'])->name('load_prescribers');

        Route::get('add_practices/{id}', [
            OurProtocolController::class,
            'add_practices',
        ])->name('add_practices')->where('id', '[1-9][0-9]*');

        Route::get('create', [OurProtocolController::class, 'create'])->name('create');
        Route::post('create', [OurProtocolController::class, 'create'])->name('create');

        Route::post('store', [OurProtocolController::class, 'store'])->name('store');

        Route::get('show/{id}', [OurProtocolController::class, 'show'])->name('show')->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', [OurProtocolController::class, 'update'])->name('update')->where('id', '[1-9][0-9]*');

        Route::get('edit/{id}', [OurProtocolController::class, 'edit'])->name('edit')->where('id', '[1-9][0-9]*');

        Route::get('destroy/{id}', [
            OurProtocolController::class,
            'destroy',
        ])->name('destroy')->where('id', '[1-9][0-9]*');

        Route::get('print_worksheet/{id}', [
            OurProtocolController::class,
            'print_worksheet',
        ])->name('print_worksheet')->where('id', '[1-9][0-9]*')->middleware('permission:print_worksheets');

        Route::get('print/{id}', [
            OurProtocolController::class,
            'print',
        ])->name('print')->where('id', '[1-9][0-9]*')->middleware('permission:print_protocols');
    });
});
