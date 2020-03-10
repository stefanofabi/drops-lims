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

			Route::get('crear', 'ProtocolController@create')->name('create');

			Route::post('almacenar', 'ProtocolController@store')->name('store');

			Route::get('ver/{id}', 'ProtocolController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::put('actualizar/{id}', 'ProtocolController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('editar/{id}', 'ProtocolController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'ProtocolController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');
		});