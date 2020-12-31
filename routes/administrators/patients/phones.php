<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the phones
|
*/

use App\Http\Controllers\Administrators\Patients\PhoneController;

Route::get('phones/create/{id}', [PhoneController::class, 'create'])->name('phones/create')->where('id', '[1-9][0-9]*');

Route::post('phones/edit', [PhoneController::class, 'edit'])->name('phones/edit');

Route::post('phones/store', [PhoneController::class, 'store'])->name('phones/store');

Route::post('phones/update', [PhoneController::class, 'update'])->name('phones/update');

Route::post('phones/destroy', [PhoneController::class, 'destroy'])->name('phones/destroy');
