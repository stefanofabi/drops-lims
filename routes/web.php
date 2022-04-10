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

Route::group([
    'middleware' => ['permission:is_admin', 'auth'],
    'prefix' => 'administrators',
    'as' => 'administrators/',
], function () {

    require('administrators/settings/settings.php');
    require('administrators/patients/patients.php');
    require('administrators/prescribers/prescribers.php');
    require('administrators/determinations/determinations.php');
    require('administrators/protocols/protocols.php');

    Route::get('home', ['\App\Http\Controllers\HomeController', 'adminHome'])->name('home');
});

Route::group(['middleware' => ['permission:is_user', 'auth']], function () {

    Route::group([
        'prefix' => 'patients',
        'as' => 'patients/',
    ], function () {

        require('patients/protocols.php');
        require('patients/family_members.php');

        Route::get('home', ['\App\Http\Controllers\HomeController', 'patientHome'])->name('home');
    });
});

Route::group(['middleware' => ['web']], function () {

    Route::get('lang/{lang}', function ($lang) {
        session(['lang' => $lang]);

        return \Redirect::back();
    })->name('lang')
    ->where(['lang' => 'en|es']);
});

// For guests
Route::get('/', function () {
    //
    $user = auth()->user();
    if ($user) {
        if ($user->hasPermissionTo('is_admin')) {
            return redirect()->route('administrators/home');
        } else {
            return redirect()->route('patients/home');
        }
    }

    return redirect()->route('login');
});
