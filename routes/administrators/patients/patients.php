<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to patients
|
*/

Route::get('patients', [
    '\App\Http\Controllers\Administrators\Patients\PatientController',
    'index',
])->name('patients')->middleware('permission:crud_patients');

Route::post('patients', [
    '\App\Http\Controllers\Administrators\Patients\PatientController',
    'load',
])->name('patients/load')->middleware('permission:crud_patients');

Route::group([
    'middleware' => 'permission:crud_patients',
    'prefix' => 'patients',
    'as' => 'patients/',
], function () {
    
    Route::get('create/{type?}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'create',
    ])->name('create')->where('type', 'animal|human|industrial');

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
    
});
