<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the nomenclators
|
*/

Route::group([
    'prefix' => 'nomenclators',
    'as' => 'nomenclators/',
], function () {

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\NomenclatorController',
        'index',
    ])->name('index');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Settings\NomenclatorController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Settings\NomenclatorController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Settings\NomenclatorController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Settings\NomenclatorController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Settings\NomenclatorController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');
});
