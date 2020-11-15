<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the emails
|
*/
Route::get('emails/create/{patient_id}', 'EmailController@create')->name('emails/create')
->where('patient_id', '[1-9][0-9]*');

Route::post('emails/store', 'EmailController@store')->name('emails/store');

Route::post('emails/edit', 'EmailController@edit')->name('emails/edit');

Route::post('emails/update', 'EmailController@update')->name('emails/update');

Route::post('emails/destroy', 'EmailController@destroy')->name('emails/destroy');