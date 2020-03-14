<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

	Route::get('protocolos', 'ProtocolController@index')->name('protocols');
	Route::post('protocolos', 'ProtocolController@load')->name('protocols/load');
	
	Route::group(
		[
			'prefix' => 'protocolos',
			'as' => 'protocols/',
		], function() {

			Route::post('cargar_pacientes', 'ProtocolController@load_patients')->name('load_patients');


			Route::group(
			[
				'prefix' => 'laboratorio',
				'as' => 'our/',
			], function() {

				Route::get('crear', 'OurProtocolController@create')->name('create');
				Route::post('crear', 'OurProtocolController@create')->name('create');

				Route::post('almacenar', 'OurProtocolController@store')->name('store');

				Route::get('ver/{id}', 'OurProtocolController@show')->name('show')
				->where('id', '[1-9][0-9]*');

				Route::put('actualizar/{id}', 'OurProtocolController@update')->name('update')
				->where('id', '[1-9][0-9]*');

				Route::get('editar/{id}', 'OurProtocolController@edit')->name('edit')
				->where('id', '[1-9][0-9]*');

				Route::get('destruir/{id}', 'OurProtocolController@destroy')->name('destroy')
				->where('id', '[1-9][0-9]*');

			});

		});