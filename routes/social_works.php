<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

Route::get('social_works/affiliates/create/{id}', 'AffiliateController@create')->name('social_works/affiliates/create')
->where('id', '[1-9][0-9]*');

Route::post('social_works/affiliates/store', 'AffiliateController@store')->name('social_works/affiliates/store');

Route::post('social_works/affiliates/edit', 'AffiliateController@edit')->name('social_works/affiliates/edit');

Route::post('social_works/affiliates/update', 'AffiliateController@update')->name('social_works/affiliates/update');

Route::post('social_works/plans/load', 'SocialWorkController@load_plans')->name('social_works/plans/load')
->where('id', '[1-9][0-9]*');