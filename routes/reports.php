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
		'prefix' => 'reports',
		'as' => 'reports/',
	], function() {

		Route::get('show/{id}', 'ReportController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		// do not confuse, refers to the id of the determination
		Route::get('create/{id}', 'ReportController@create')->name('create')
		->where('id', '[1-9][0-9]*');

		Route::post('store', 'ReportController@store')->name('store');

		Route::put('update/{id}', 'ReportController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('edit/{id}', 'ReportController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destroy/{id}', 'ReportController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');
	});