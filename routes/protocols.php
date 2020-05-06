<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

	Route::get('protocols', 'ProtocolController@index')->name('protocols');
	Route::post('protocols', 'ProtocolController@load')->name('protocols/load');
	
	Route::group(
		[
			'prefix' => 'protocols',
			'as' => 'protocols/',
		], function() {

			require('practices.php');

			Route::group(
			[
				'prefix' => 'laboratory',
				'as' => 'our/',
			], function() {

				Route::post('load_patients', 'OurProtocolController@load_patients')->name('load_patients');
				Route::post('load_prescribers', 'OurProtocolController@load_prescribers')->name('load_prescribers');

				Route::get('add_practices/{id}', 'OurProtocolController@add_practices')->name('add_practices')
				->where('id', '[1-9][0-9]*');

				Route::get('create', 'OurProtocolController@create')->name('create');
				Route::post('create', 'OurProtocolController@create')->name('create');

				Route::post('store', 'OurProtocolController@store')->name('store');

				Route::get('show/{id}', 'OurProtocolController@show')->name('show')
				->where('id', '[1-9][0-9]*');

				Route::put('update/{id}', 'OurProtocolController@update')->name('update')
				->where('id', '[1-9][0-9]*');

				Route::get('edit/{id}', 'OurProtocolController@edit')->name('edit')
				->where('id', '[1-9][0-9]*');

				Route::get('destroy/{id}', 'OurProtocolController@destroy')->name('destroy')
				->where('id', '[1-9][0-9]*');

				Route::get('print_worksheet/{id}', 'OurProtocolController@print_worksheet')->name('print_worksheet')
				->where('id', '[1-9][0-9]*');

				Route::get('print/{id}', 'OurProtocolController@print')->name('print')
				->where('id', '[1-9][0-9]*');

			});

		});