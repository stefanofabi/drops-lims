<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the phones
|
*/

Route::get('phones/create/{id}', ['\App\Http\Controllers\Administrators\Patients\PhoneController', 'create'])->name('phones/create')->where('id', '[1-9][0-9]*');

Route::post('phones/edit', ['\App\Http\Controllers\Administrators\Patients\PhoneController', 'edit'])->name('phones/edit');

Route::post('phones/store', ['\App\Http\Controllers\Administrators\Patients\PhoneController', 'store'])->name('phones/store');

Route::post('phones/update', ['\App\Http\Controllers\Administrators\Patients\PhoneController', 'update'])->name('phones/update');

Route::post('phones/destroy', ['\App\Http\Controllers\Administrators\Patients\PhoneController', 'destroy'])->name('phones/destroy');
