<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to patients
|
*/

Route::group([
    'middleware' => 'permission:crud_patients',
    'prefix' => 'patients',
    'as' => 'patients/',
], function () {
    
    Route::get('index', ['\App\Http\Controllers\Administrators\Patients\PatientController', 'index'])
    ->name('index');

    Route::get('create/{type}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'create',
    ])->name('create')
    ->where('type', 'animal|human|industrial');

    Route::post('store', ['\App\Http\Controllers\Administrators\Patients\PatientController', 'store'])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::post('security_codes/store', [
        '\App\Http\Controllers\Administrators\Patients\SecurityCodeController',
        'store',
    ])->name('security_codes/store');

    Route::post('load-patients', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'loadPatients',
    ])->name('load_patients');
    
});
