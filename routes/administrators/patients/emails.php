<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the emails
|
*/

use App\Http\Controllers\Administrators\Patients\EmailController;

Route::get('emails/create/{patient_id}', [
    EmailController::class,
    'create',
])->name('emails/create')->where('patient_id', '[1-9][0-9]*');

Route::post('emails/store', [EmailController::class, 'store'])->name('emails/store');

Route::post('emails/edit', [EmailController::class, 'edit'])->name('emails/edit');

Route::post('emails/update', [EmailController::class, 'update'])->name('emails/update');

Route::post('emails/destroy', [EmailController::class, 'destroy'])->name('emails/destroy');
