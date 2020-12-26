<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to patients
|
*/

Route::get('patients', 'PatientController@index')->name('patients')->middleware('permission:crud_patients');
Route::post('patients', 'PatientController@load')->name('patients/load')->middleware('permission:crud_patients');

Route::group(
	[
		'middleware' => 'permission:crud_patients',
		'prefix' => 'patients',
		'as' => 'patients/',
	], function() {

		require("emails.php");
		require("phones.php");
		require("social_works.php");

		Route::get('show/{id}', 'PatientController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		Route::get('create', 'PatientController@create')->name('create');


		Route::get('animals/create', 'PatientController@create_animal')->name('animals/create');
		Route::get('humans/create', 'PatientController@create_human')->name('humans/create');
		Route::get('industrials/create', 'PatientController@create_industrial')->name('industrials/create');


		Route::post('store', 'PatientController@store')->name('store');

		Route::get('edit/{id}', 'PatientController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::put('update/{id}', 'PatientController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::delete('destroy/{id}', 'PatientController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');

		Route::patch('restore/{id}', 'PatientController@restore')->name('restore')
		->where('id', '[1-9][0-9]*');

        Route::post('security_codes/store', 'SecurityCodeController@store')->name('security_codes/store');

	}
);
