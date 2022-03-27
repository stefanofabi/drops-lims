<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the reports
|
*/

Route::group([
    'middleware' => 'permission:crud_reports',
    'prefix' => 'reports',
    'as' => 'reports/',
], function () {

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Determinations\ReportController',
        'index',
    ])->name('index');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Determinations\ReportController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Determinations\ReportController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\ReportController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\ReportController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Determinations\ReportController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');
});
