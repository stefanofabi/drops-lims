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


Route::group(['middleware' => ['is_admin']], function () {

		Route::group(
			[
				'prefix' => 'administrators',
				'as' => 'administrators/',
			], function() {
				require('patients.php');
				require('prescribers.php');
				require('determinations.php');
				require('protocols.php');

				Route::get('home', 'HomeController@adminHome')->name('home');
			}
		);
});


Route::group(['middleware' => ['is_user']], function () {

		Route::get('/home', 'HomeController@index')->name('home');

});

Route::group(['middleware' => ['web']], function () {

		Route::get('lang/{lang}', function ($lang) {
			session(['lang' => $lang]);

			return \Redirect::back();
		})->where([
			'lang' => 'en|es'
		]);
});


Auth::routes();

// For guests
Route::get('/', function () {
    //
    return redirect()->route('login');
});
