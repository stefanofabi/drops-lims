<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the statistics
|
*/

Route::get('statistics', 'StatisticsController@index')->name('statistics');

Route::group(
	[
		'prefix' => 'statistics',
		'as' => 'statistics/',
	], function() {
		
		Route::post('annual_collection_social_work', 'StatisticsController@annual_collection_social_work')
		->name('annual_collection_social_work');

});