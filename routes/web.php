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

Route::group(['middleware' => ['permission:is_admin', 'auth']], function () {

    Route::group([
        'prefix' => 'administrators',
        'as' => 'administrators/',
    ], function () {
        require('administrators/patients/patients.php');
        require('administrators/prescribers/prescribers.php');
        require('administrators/determinations/determinations.php');
        require('administrators/protocols/protocols.php');
        require('administrators/statistics/statistics.php');

        Route::get('home', ['\App\Http\Controllers\HomeController', 'adminHome'])->name('home');
    });
});

Route::group(['middleware' => ['permission:is_user', 'auth']], function () {

    Route::group([
        'prefix' => 'patients',
        'as' => 'patients/',
    ], function () {

        Route::get('home', ['\App\Http\Controllers\HomeController', 'index'])->name('home');

        Route::get('results', ['\App\Http\Controllers\Patients\UserPatientController', 'index'])->name('results');
        Route::post('get_protocols', ['\App\Http\Controllers\Patients\UserPatientController', 'get_protocols'])->name('protocols/index');

        Route::get('protocols/{id}', ['\App\Http\Controllers\Patients\ProtocolController', 'show'])->name('protocols/show')->where('id', '[1-9][0-9]*');
        Route::get('protocols/print/{id}', ['\App\Http\Controllers\Patients\ProtocolController', 'print_protocol'])->name('protocols/print')->where('id', '[1-9][0-9]*');
        Route::post('protocols/print_selection', ['\App\Http\Controllers\Patients\ProtocolController', 'print_partial_report'])->name('protocols/print_selection');

        Route::get('protocols/practices/{id}', ['\App\Http\Controllers\Patients\PracticeController', 'show'])->name('protocols/practices/show')->where('id', '[1-9][0-9]*');
        Route::post('protocols/practices/get_results', ['\App\Http\Controllers\Patients\PracticeController', 'get_results'])->name('protocols/practices/get_results');

        Route::get('family_members/index', ['\App\Http\Controllers\Patients\FamilyMemberController', 'index'])->name('family_members/index');
        Route::get('family_members/create', ['\App\Http\Controllers\Patients\FamilyMemberController', 'create'])->name('family_members/create');
        Route::post('family_members/store', ['\App\Http\Controllers\Patients\FamilyMemberController', 'store'])->name('family_members/store');
    });
});

Route::group(['middleware' => ['web']], function () {

    Route::get('lang/{lang}', function ($lang) {
        session(['lang' => $lang]);

        return \Redirect::back();
    })->where([
        'lang' => 'en|es',
    ]);
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
