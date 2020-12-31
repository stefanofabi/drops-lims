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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Patients\UserPatientController;
use App\Http\Controllers\Patients\FamilyMemberController;

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

        Route::get('home', [HomeController::class, 'adminHome'])->name('home');
    });
});

Route::group(['middleware' => ['permission:is_user', 'auth']], function () {

    Route::group([
        'prefix' => 'patients',
        'as' => 'patients/',
    ], function () {

        Route::get('home', [HomeController::class, 'index'])->name('home');

        Route::get('results', [UserPatientController::class, 'index'])->name('results');
        Route::post('get_protocols', [UserPatientController::class, 'get_protocols'])->name('protocols/index');

        Route::get('protocols/{id}', [UserPatientController::class, 'show_protocol'])->name('protocols/show')->where('id', '[1-9][0-9]*');
        Route::get('protocols/print/{id}', [UserPatientController::class, 'print_protocol'])->name('protocols/print')->where('id', '[1-9][0-9]*');
        Route::post('protocols/print_selection', [UserPatientController::class, 'print_partial_report'])->name('protocols/print_selection');

        Route::get('protocols/practices/{id}', [UserPatientController::class, 'show_practice'])->name('protocols/practices/show')->where('id', '[1-9][0-9]*');
        Route::post('protocols/practices/get_results', [UserPatientController::class, 'get_results'])->name('protocols/practices/get_results');

        Route::get('family_members/index', [FamilyMemberController::class, 'index'])->name('family_members/index');
        Route::get('family_members/create', [FamilyMemberController::class, 'create'])->name('family_members/create');
        Route::post('family_members/store', [FamilyMemberController::class, 'store'])->name('family_members/store');
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
