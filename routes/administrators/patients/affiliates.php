<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

Route::group([
    'middleware' => 'permission:crud_patients',
    'prefix' => 'social_works/affiliates',
    'as' => 'social_works/affiliates/',
], function () {

    Route::get('create/{patient_id}', [
        '\App\Http\Controllers\Administrators\Patients\AffiliateController',
        'create',
    ])->name('create')->where('patient_id', '[1-9][0-9]*');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Patients\AffiliateController',
        'store',
    ])->name('store');

    Route::post('edit', [
        '\App\Http\Controllers\Administrators\Patients\AffiliateController',
        'edit',
    ])->name('edit');

    Route::post('update', [
        '\App\Http\Controllers\Administrators\Patients\AffiliateController',
        'update',
    ])->name('update');

    Route::post('destroy', [
        '\App\Http\Controllers\Administrators\Patients\AffiliateController',
        'destroy',
    ])->name('destroy');

});


