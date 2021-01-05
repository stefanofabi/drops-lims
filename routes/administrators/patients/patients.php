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

    require('emails.php');
    require('phones.php');
    require('social_works.php');

    Route::get('show/{id}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'show',
    ])->name('show')->where('id', '[1-9][0-9]*');

    Route::get('create', ['\App\Http\Controllers\Administrators\Patients\PatientController', 'create'])->name('create');

    Route::get('animals/create', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'create_animal',
    ])->name('animals/create');
    Route::get('humans/create', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'create_human',
    ])->name('humans/create');
    Route::get('industrials/create', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'create_industrial',
    ])->name('industrials/create');

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

    Route::patch('restore/{id}', [
        '\App\Http\Controllers\Administrators\Patients\PatientController',
        'restore',
    ])->name('restore')->where('id', '[1-9][0-9]*');

    Route::post('security_codes/store', [
        '\App\Http\Controllers\Administrators\Patients\SecurityCodeController',
        'store',
    ])->name('security_codes/store');
});
