<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the prescribers
|
*/

Route::get('prescribers', 'PrescriberController@index')->name('prescribers');
Route::post('prescribers', 'PrescriberController@load')->name('prescribers/load');

Route::group(
	[
		'prefix' => 'prescribers',
		'as' => 'prescribers/',
	], function() {
		Route::get('show/{id}', 'PrescriberController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		Route::get('create', 'PrescriberController@create')->name('create');

		Route::post('store', 'PrescriberController@store')->name('store');

		Route::put('update/{id}', 'PrescriberController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('edit/{id}', 'PrescriberController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destroy/{id}', 'PrescriberController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');
	});