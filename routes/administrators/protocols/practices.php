<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

Route::group([
    'middleware' => 'permission:crud_practices',
    'prefix' => 'practices',
    'as' => 'practices/',
], function () {

    Route::post('find', ['\App\Http\Controllers\Administrators\Protocols\PracticeController', 'load'])->name('load');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'create',
    ])->name('create');

    Route::post('store', ['\App\Http\Controllers\Administrators\Protocols\PracticeController', 'store'])->name('store');

    Route::get('show/{id}', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'show',
    ])->name('show')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::put('sign/{id}', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'sign',
    ])->name('sign')->where('id', '[1-9][0-9]*')->middleware('permission:sign_practices');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::get('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::post('results', [
        '\App\Http\Controllers\Administrators\Protocols\PracticeController',
        'get_results',
    ])->name('results');
});
