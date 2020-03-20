<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/
	
	Route::group(
		[
			'prefix' => 'practicas',
			'as' => 'practices/',
		], function() {

			// do not confuse, it is the protocol id
			Route::get('practicas{id}', 'PracticeController@add')->name('add')
			->where('id', '[1-9][0-9]*');

			Route::get('crear', 'PracticeController@create')->name('create');

			Route::post('almacenar', 'PracticeController@store')->name('store');

			Route::get('ver/{id}', 'PracticeController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::put('actualizar/{id}', 'PracticeController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('editar/{id}', 'PracticeController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'PracticeController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');

		});