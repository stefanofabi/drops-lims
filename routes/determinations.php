<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the determinations
|
*/

Route::get('determinations', 'DeterminationController@index')->name('determinations');
Route::post('determinations', 'DeterminationController@load')->name('determinations/load');

Route::group(
	[
		'prefix' => 'determinaciones',
		'as' => 'determinations/',
	], function() {

		require('reports.php');
		
		Route::get('create', 'DeterminationController@create')->name('create');

		Route::post('store', 'DeterminationController@store')->name('store');

		Route::get('show/{id}', 'DeterminationController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		Route::put('update/{id}', 'DeterminationController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('edit/{id}', 'DeterminationController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::get('destroy/{id}', 'DeterminationController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');

		Route::patch('restore/{id}', 'DeterminationController@restore')->name('restore')
		->where('id', '[1-9][0-9]*');
	});
