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

                Route::get('results', 'UserPatientController@index')->name('results');
                Route::post('get_protocols', 'UserPatientController@get_protocols')->name('protocols/index');

                Route::get('protocols/{id}', 'UserPatientController@show_protocol')->name('protocols/show')
                    ->where('id', '[1-9][0-9]*');
                Route::get('protocols/print/{id}', 'UserPatientController@print_protocol')->name('protocols/print')
                    ->where('id', '[1-9][0-9]*');
                Route::post('protocols/print_selection', 'UserPatientController@print_partial_report')->name('protocols/print_selection');

                Route::get('protocols/practices/{id}', 'UserPatientController@show_practice')->name('protocols/practices/show')
                    ->where('id', '[1-9][0-9]*');
                Route::post('protocols/practices/get_results', 'UserPatientController@get_results')->name('protocols/practices/get_results');

                Route::get('family_members/index', 'FamilyMemberController@index')->name('family_members/index');
                Route::get('family_members/create', 'FamilyMemberController@create')->name('family_members/create');
                Route::post('family_members/store', 'FamilyMemberController@store')->name('family_members/store');


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
