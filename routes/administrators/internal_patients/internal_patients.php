<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to internal patients
|
*/

use App\Http\Controllers\Administrators\InternalPatients\InternalPatientController;
use App\Http\Controllers\Administrators\InternalPatients\SecurityCodeController;

Route::controller(InternalPatientController::class)
    ->prefix('internal_patients')
    ->as('patients/')
    ->middleware('permission:manage patients')
    ->group(function () {   

        Route::get('index', 'index')
            ->name('index');

        Route::get('create', 'create')
            ->name('create');

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

        Route::controller(SecurityCodeController::class)
        ->prefix('security_codes')
        ->as('security_codes/')
        ->middleware('permission:generate security codes')
        ->group(function () {   

            Route::post('store', 'store')
                ->name('store')
                ->middleware('check_if_loaded_patient_email');
        });

    });