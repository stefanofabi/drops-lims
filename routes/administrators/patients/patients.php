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

Route::get('patients', [PatientController::class, 'index'])->name('patients')->middleware('permission:crud_patients');

Route::post('patients', [
    PatientController::class,
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

    Route::get('show/{id}', [PatientController::class, 'show'])->name('show')->where('id', '[1-9][0-9]*');

    Route::get('create', [PatientController::class, 'create'])->name('create');

    Route::get('animals/create', [PatientController::class, 'create_animal'])->name('animals/create');
    Route::get('humans/create', [PatientController::class, 'create_human'])->name('humans/create');
    Route::get('industrials/create', [PatientController::class, 'create_industrial'])->name('industrials/create');

    Route::post('store', [PatientController::class, 'store'])->name('store');

    Route::get('edit/{id}', [PatientController::class, 'edit'])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [PatientController::class, 'update'])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [PatientController::class, 'destroy'])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::patch('restore/{id}', [PatientController::class, 'restore'])->name('restore')->where('id', '[1-9][0-9]*');

    Route::post('security_codes/store', [SecurityCodeController::class, 'store'])->name('security_codes/store');
});
