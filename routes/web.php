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

	Route::post('pacientes', 'PatientsController@load')->name('patients/load');
	Route::get('pacientes', 'PatientsController@index')->name('patients');
	Route::get('pacientes/crear', 'PatientsController@create')->name('patients/create');

	Route::group(
		[
			'prefix' => 'pacientes/humanos',
			'as' => 'patients/humans/',
		], function() {
			Route::get('crear', 'HumansController@create')->name('create');

			Route::post('almacenar', 'HumansController@store')->name('store');
			
			Route::get('editar/{id}', 'HumansController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');
			
			Route::put('actualizar/{id}', 'HumansController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'HumansController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');
		});


	Route::group(
		[
			'prefix' => 'pacientes/animales',
			'as' => 'patients/animals/',
		], function() {
			Route::get('pacientes/animales/crear', 'AnimalsController@create')->name('create');

			Route::post('pacientes/animales/almacenar', 'AnimalsController@store')->name('store');

			Route::get('editar/{id}', 'AnimalsController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::put('actualizar/{id}', 'AnimalsController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'AnimalsController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');


		});


	Route::group(
		[
			'prefix' => 'pacientes/industriales',
			'as' => 'patients/industrials/',
		], function() {
			Route::get('crear', 'IndustrialsController@create')->name('create');

			Route::post('almacenar', 'IndustrialsController@store')->name('store');

			Route::get('editar/{id}', 'IndustrialsController@edit')->name('edit')
			->where('id', '[1-9][0-9]*');

			Route::put('actualizar/{id}', 'IndustrialsController@update')->name('update')
			->where('id', '[1-9][0-9]*');

			Route::get('destruir/{id}', 'IndustrialsController@destroy')->name('destroy')
			->where('id', '[1-9][0-9]*');
		});

});