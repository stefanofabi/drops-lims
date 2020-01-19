<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the emails
|
*/
Route::get('correos/crear/{id}', 'EmailController@create')->name('emails/create')
->where('id', '[1-9][0-9]*');

Route::post('correos/almacenar', 'EmailController@store')->name('emails/store');

Route::post('correos/editar', 'EmailController@edit')->name('emails/edit');

Route::post('correos/actualizar', 'EmailController@update')->name('emails/update');