<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the phones
|
*/

Route::get('telefonos/crear/{id}', 'PhoneController@create')->name('phones/create')
->where('id', '[1-9][0-9]*');

Route::post('telefonos/editar', 'PhoneController@edit')->name('phones/edit');

Route::post('telefonos/almacenar', 'PhoneController@store')->name('phones/store');

Route::post('telefonos/actualizar', 'PhoneController@update')->name('phones/update');