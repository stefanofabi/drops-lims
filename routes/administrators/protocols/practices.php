<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

use App\Http\Controllers\Administrators\Protocols\PracticeController;

Route::group(
	[
		'middleware' => 'permission:crud_practices',
		'prefix' => 'practices',
		'as' => 'practices/',
	], function() {

		Route::post('find', [PracticeController::class, 'load'])->name('load');

		Route::get('create', [PracticeController::class, 'create'])->name('create');

		Route::post('store', [PracticeController::class, 'store'])->name('store');

		Route::get('show/{id}', [PracticeController::class, 'show'])->name('show')
		->where('id', '[1-9][0-9]*');

		Route::put('update/{id}', [PracticeController::class, 'update'])->name('update')
		->where('id', '[1-9][0-9]*');

		Route::put('sign/{id}', [PracticeController::class, 'sign'])->name('sign')
		->where('id', '[1-9][0-9]*')->middleware('permission:sign_practices');

		Route::get('edit/{id}', [PracticeController::class, 'edit'])->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destroy/{id}', [PracticeController::class, 'destroy'])->name('destroy')
		->where('id', '[1-9][0-9]*');

		Route::post('results', [PracticeController::class, 'get_results'])->name('results');

	});
