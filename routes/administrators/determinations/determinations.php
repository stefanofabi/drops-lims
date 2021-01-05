<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the determinations
|
*/

Route::get('determinations', [
    '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
    'index',
])->name('determinations')->middleware('permission:crud_determinations');
Route::post('determinations', [
    '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
    'load',
])->name('determinations/load')->middleware('permission:crud_determinations');

Route::group([
    'middleware' => 'permission:crud_determinations',
    'prefix' => 'determinations',
    'as' => 'determinations/',
], function () {

    require('reports.php');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'store',
    ])->name('store');

    Route::get('show/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'show',
    ])->name('show')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::get('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::patch('restore/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\DeterminationController',
        'restore',
    ])->name('restore')->where('id', '[1-9][0-9]*');
});
