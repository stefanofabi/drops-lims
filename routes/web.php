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
Route::get('pacientes', 'PatientsController@index');

Route::get('pacientes/nuevo', function() {
	return view('patients/new_patient');
})->name('patients/new');

Route::get('pacientes/nuevo/animal', 'PatientsController@new_patient_animal')->name('patients/new/animal');
Route::get('pacientes/nuevo/humano', 'PatientsController@new_patient_human')->name('patients/new/human');
Route::get('pacientes/nuevo/industrial', 'PatientsController@new_patient_industrial')->name('patients/new/industrial');

Route::get('user/{id}', function ($id) {
	//return view('editar_paciente');
    return 'User '.$id;
})->where('id', '[0-9]+');



/*
Route::get('/', function () {
    return view('welcome');
});

*/

// Ruta por defecto
Route::fallback(function () {
     return 'LINK NO ENCONTRADO';
});
