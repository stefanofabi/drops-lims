<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to patients
|
*/

Route::get('pacientes', 'PatientController@index')->name('patients');
Route::post('pacientes', 'PatientController@load')->name('patients/load');

Route::group(
	[
		'prefix' => 'pacientes',
		'as' => 'patients/',
	], function() {

		require("emails.php");
		require("phones.php");
		require("social_works.php");

		Route::get('ver/{id}', 'PatientController@show')->name('show')
		->where('id', '[1-9][0-9]*');

		Route::get('crear', 'PatientController@create')->name('create');


		Route::get('animales/crear', 'PatientController@create_animal')->name('animals/create');
		Route::get('humanos/crear', 'PatientController@create_human')->name('humans/create');
		Route::get('industriales/crear', 'PatientController@create_industrial')->name('industrials/create');


		Route::post('almacenar', 'PatientController@store')->name('store');

		Route::get('editar/{id}', 'PatientController@edit')->name('edit')
		->where('id', '[1-9][0-9]*');

		Route::put('actualizar/{id}', 'PatientController@update')->name('update')
		->where('id', '[1-9][0-9]*');

		Route::get('destruir/{id}', 'PatientController@destroy')->name('destroy')
		->where('id', '[1-9][0-9]*');

	}
);