<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the prescribers
|
*/

Route::get('prescribers', 'PrescriberController@index')->name('prescribers')->middleware('permission:crud_prescribers');
Route::post('prescribers/load', 'PrescriberController@load')->name('prescribers/load')->middleware('permission:crud_prescribers');

Route::group(
	[
		'middleware' => 'permission:crud_prescribers',
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

		Route::delete('destroy/{id}', 'PrescriberController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');

		Route::patch('restore/{id}', 'PrescriberController@restore')->name('restore')
		->where('id', '[1-9][0-9]*');
	});