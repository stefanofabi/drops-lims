<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to patients
|
*/

use App\Http\Controllers\Administrators\Patients\PatientController;
use App\Http\Controllers\Administrators\Patients\SecurityCodeController;

Route::controller(PatientController::class)
    ->prefix('patients')
    ->as('patients/')
    ->middleware('permission:crud_patients')
    ->group(function () {   

        Route::get('index', 'index')
            ->name('index');

        Route::get('create/{type}', 'create')
            ->name('create')
            ->where('type', 'animal|human|industrial');

        Route::post('store', 'store')
            ->name('store');

        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', 'update')
            ->name('update')
            ->where('id', '[1-9][0-9]*');

        Route::delete('destroy/{id}', 'destroy')
            ->name('destroy')
            ->where('id', '[1-9][0-9]*');

        Route::post('load-patients', 'loadPatients')
            ->name('load_patients');
    });

Route::controller(SecurityCodeController::class)
    ->prefix('patients/security_codes')
    ->as('patients/security_codes/')
    ->middleware('permission:crud_patients')
    ->group(function () {   
        Route::post('store', 'store')
            ->name('store');
    });