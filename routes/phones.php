<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the phones
|
*/

Route::get('phones/create/{id}', 'PhoneController@create')->name('phones/create')
->where('id', '[1-9][0-9]*');

Route::post('phones/edit', 'PhoneController@edit')->name('phones/edit');

Route::post('phones/store', 'PhoneController@store')->name('phones/store');

Route::post('phones/update', 'PhoneController@update')->name('phones/update');

Route::post('phones/destroy', 'PhoneController@destroy')->name('phones/destroy');