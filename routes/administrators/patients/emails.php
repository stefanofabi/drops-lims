<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the emails
|
*/

Route::get('emails/create/{patient_id}', [
    '\App\Http\Controllers\Administrators\Patients\EmailController',
    'create',
])->name('emails/create')->where('patient_id', '[1-9][0-9]*');

Route::post('emails/store', [
    '\App\Http\Controllers\Administrators\Patients\EmailController',
    'store',
])->name('emails/store');

Route::post('emails/edit', [
    '\App\Http\Controllers\Administrators\Patients\EmailController',
    'edit',
])->name('emails/edit');

Route::post('emails/update', [
    '\App\Http\Controllers\Administrators\Patients\EmailController',
    'update',
])->name('emails/update');

Route::post('emails/destroy', [
    '\App\Http\Controllers\Administrators\Patients\EmailController',
    'destroy',
])->name('emails/destroy');
