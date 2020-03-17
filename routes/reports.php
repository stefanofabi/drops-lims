<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the reports
|
*/


Route::group(
	[
		'prefix' => 'reportes',
		'as' => 'reports/',
	], function() {

		Route::get('ver/{id}', 'ReportController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		// do not confuse, refers to the id of the determination
		Route::get('crear/{id}', 'ReportController@create')->name('create')
		->where('id', '[1-9][0-9]*');

		Route::post('almacenar', 'ReportController@store')->name('store');

		Route::put('actualizar/{id}', 'ReportController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('editar/{id}', 'ReportController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destruir/{id}', 'ReportController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');
	});