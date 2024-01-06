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
    'middleware' => ['permission:is lab staff', 'auth', 'auth.banned'],
    'prefix' => 'administrators',
    'as' => 'administrators/',
], function () {
    
    require('administrators/profiles/profiles.php');
    require('administrators/internal_patients/internal_patients.php');
    require('administrators/prescribers/prescribers.php');
    require('administrators/determinations/determinations.php');
    require('administrators/internal_protocols/internal_protocols.php');
    require('administrators/settings/settings.php');
    require('administrators/statistics/statistics.php');
    require('administrators/summaries/summaries.php');
    require('administrators/logs/logs.php');

    Route::get('dashboard', ['\App\Http\Controllers\HomeController', 'adminHome'])->name('dashboard');
});

Route::group(['middleware' => ['permission:is patient', 'auth', 'auth.banned']], function () {

    Route::group([
        'prefix' => 'patients',
        'as' => 'patients/',
    ], function () {

        require('patients/protocols.php');
        require('patients/family_members.php');
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
        if ($user->hasPermissionTo('is lab staff')) {
            return redirect()->route('administrators/dashboard');
        } else if ($user->hasPermissionTo('is patient')) {
            return redirect()->route('patients/protocols/index');
        }

       die('User have not enviroment');
    }

    return redirect()->route('login');
})->name('/');