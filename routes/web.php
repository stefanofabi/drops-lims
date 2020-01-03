<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['web']], function () {

	Route::get('lang/{lang}', function ($lang) {
		session(['lang' => $lang]);

		return \Redirect::back();
	})->where([
		'lang' => 'en|es'
	]);

	Route::post('pacientes', 'PatientController@load')->name('patients/load');
	Route::get('pacientes', 'PatientController@index')->name('patients');


	Route::group(
		[
			'prefix' => 'pacientes',
			'as' => 'patients/',
		], function() {

			Route::get('emails/crear/{id}', 'EmailController@create')->name('emails/create')
			->where('id', '[1-9][0-9]*');
			Route::post('emails/almacenar', 'EmailController@store')->name('emails/store');


			Route::get('phones/crear/{id}', 'PhoneController@create')->name('phones/create')
			->where('id', '[1-9][0-9]*');
			Route::post('phones/almacenar', 'PhoneController@store')->name('phones/store');

			Route::get('ver/{id}', 'PatientController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::get('crear', 'PatientController@create')->name('create');
		});



	Route::group(
		[
			'prefix' => 'pacientes/humanos',
			'as' => 'patients/humans/',
		], function() {
			
			Route::get('crear', 'HumanController@create')->name('create');

			Route::post('almacenar', 'HumanController@store')->name('store');
			
			Route::get('ver/{id}', 'HumanController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::get('editar/{id}', 'HumanController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');
			
			Route::put('actualizar/{id}', 'HumanController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'HumanController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');
		});


	Route::group(
		[
			'prefix' => 'pacientes/animales',
			'as' => 'patients/animals/',
		], function() {
			Route::get('pacientes/animales/crear', 'AnimalController@create')->name('create');

			Route::post('pacientes/animales/almacenar', 'AnimalController@store')->name('store');

			Route::get('ver/{id}', 'AnimalController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::get('editar/{id}', 'AnimalController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::put('actualizar/{id}', 'AnimalController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'AnimalController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');


		});


	Route::group(
		[
			'prefix' => 'pacientes/industriales',
			'as' => 'patients/industrials/',
		], function() {
			Route::get('crear', 'IndustrialController@create')->name('create');

			Route::post('almacenar', 'IndustrialController@store')->name('store');

			Route::get('ver/{id}', 'IndustrialController@show')->name('show')
			->where('id', '[1-9][0-9]*');

			Route::get('editar/{id}', 'IndustrialController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::put('actualizar/{id}', 'IndustrialController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'IndustrialController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');
		});

});