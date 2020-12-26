<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the statistics
|
*/

Route::get('statistics', 'StatisticsController@index')->name('statistics')->middleware('permission:see_statistics');

Route::group(
	[
		'middleware' => 'permission:see_statistics',
		'prefix' => 'statistics',
		'as' => 'statistics/',
	], function() {
		
		Route::post('annual_collection_social_work', 'StatisticsController@annual_collection_social_work')
		->name('annual_collection_social_work');

		Route::post('patient_flow_per_month', 'StatisticsController@patient_flow_per_month')
		->name('patient_flow_per_month');

		Route::post('track_income', 'StatisticsController@track_income')
		->name('track_income');

});