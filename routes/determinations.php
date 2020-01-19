<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the determinations
|
*/


Route::post('determinaciones', 'DeterminationController@load')->name('determinations/load');
Route::get('determinaciones', 'DeterminationController@index')->name('determinations');

Route::group(
	[
		'prefix' => 'determinaciones',
		'as' => 'determinations/',
	], function() {

		Route::get('crear', 'DeterminationController@create')->name('create');

		Route::post('almacenar', 'DeterminationController@store')->name('store');

		Route::get('ver/{id}', 'DeterminationController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		Route::put('actualizar/{id}', 'DeterminationController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('editar/{id}', 'DeterminationController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destruir/{id}', 'DeterminationController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');
	});
