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

Route::post('pacientes', 'PatientsController@load')->name('patients/load');
Route::get('pacientes', 'PatientsController@index')->name('patients');

Route::get('pacientes/nuevo', 'PatientsController@create')->name('patients/create');


Route::get('pacientes/nuevo/animal', 'AnimalsController@create')->name('patients/animals/create');
Route::get('pacientes/nuevo/humano', 'HumansController@create')->name('patients/humans/create');
Route::get('pacientes/nuevo/industrial', 'Controller@create')->name('patients/industrials/create');

Route::post('pacientes/nuevo/humano', 'HumansController@store')->name('patients/humans/store');

Route::get('pacientes/{id}', function ($id) {
		return 'User '.$id;
})->where('id', '[1-9]+[0-9]*');



/*
Route::get('/', function () {
    return view('welcome');
});

*/

// Ruta por defecto
Route::fallback(function () {
     return 'LINK NO ENCONTRADO';
});
