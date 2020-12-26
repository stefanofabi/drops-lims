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
			'middleware' => 'permission:crud_practices',
			'prefix' => 'practices',
			'as' => 'practices/',
		], function() {

			Route::post('find', 'PracticeController@load')->name('load');

			Route::get('create', 'PracticeController@create')->name('create');

			Route::post('store', 'PracticeController@store')->name('store');

			Route::get('show/{id}', 'PracticeController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::put('update/{id}', 'PracticeController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('edit/{id}', 'PracticeController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::get('destroy/{id}', 'PracticeController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');

			Route::post('results', 'PracticeController@get_results')->name('results');

		});