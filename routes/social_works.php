<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

Route::get('obras_sociales/afiliados/crear/{id}', 'AffiliateController@create')->name('social_works/affiliates/create')
->where('id', '[1-9][0-9]*');

Route::post('obras_sociales/afiliados/almacenar', 'AffiliateController@store')->name('social_works/affiliates/store');

Route::post('obras_sociales/afiliados/editar', 'AffiliateController@edit')->name('social_works/affiliates/edit');

Route::post('obras_sociales/afiliados/actualizar', 'AffiliateController@update')->name('social_works/affiliates/update');

Route::post('obras_sociales/planes/load_plans', 'PlanController@load_plans')->name('social_works/plans/load_plans')
->where('id', '[1-9][0-9]*');
