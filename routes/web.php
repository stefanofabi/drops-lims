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

Auth::routes();

Route::group(['middleware' => ['is_admin', 'auth']], function () {

		Route::group(
			[
				'prefix' => 'administrators',
				'as' => 'administrators/',
			], function() {
				require('patients.php');
				require('prescribers.php');
				require('determinations.php');
				require('protocols.php');
				require('statistics.php');

				Route::get('home', 'HomeController@adminHome')->name('home');
			}
		);
});


Route::group(['middleware' => ['is_user', 'auth']], function () {

        Route::group(
            [
                'prefix' => 'patients',
                'as' => 'patients/',
            ], function() {

                Route::get('home', 'HomeController@index')->name('home');
                Route::get('results', 'FamilyMemberController@index_results')->name('results');
                Route::post('get_protocols', 'FamilyMemberController@get_protocols')->name('get_protocols');
        }
        );
});

Route::group(['middleware' => ['web']], function () {

		Route::get('lang/{lang}', function ($lang) {
			session(['lang' => $lang]);

			return \Redirect::back();
		})->where([
			'lang' => 'en|es'
		]);
});


// For guests
Route::get('/', function () {
    //
    $user = auth()->user();
    if ($user) {
        if ($user->is_admin) {
            return redirect()->route('administrators/home');
        } else {
            return redirect()->route('patients/home');
        }
    }

    return redirect()->route('login');
});
