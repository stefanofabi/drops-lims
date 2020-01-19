<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the prescribers
|
*/

Route::post('prescriptores', 'PrescriberController@load')->name('prescribers/load');
Route::get('prescriptores', 'PrescriberController@index')->name('prescribers');

Route::group(
	[
		'prefix' => 'prescriptores',
		'as' => 'prescribers/',
	], function() {
		Route::get('ver/{id}', 'PrescriberController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		Route::get('crear', 'PrescriberController@create')->name('create');

		Route::post('almacenar', 'PrescriberController@store')->name('store');

		Route::put('actualizar/{id}', 'PrescriberController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('editar/{id}', 'PrescriberController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destruir/{id}', 'PrescriberController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');
	});