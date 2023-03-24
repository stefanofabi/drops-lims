<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the profiles
|
*/

use App\Http\Controllers\Administrators\Profiles\ProfileController;
use App\Http\Controllers\Administrators\Profiles\SignatureController;

Route::group([
    'prefix' => 'profiles',
    'as' => 'profiles/',
    'middleware' => ['permission:manage profile', 'redirect_if_not_my_profile'],
], function () {

    Route::controller(ProfileController::class)
    ->group(function () {   
        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', 'update')
            ->name('update')
            ->where('id', '[1-9][0-9]*');

    });

    Route::controller(SignatureController::class)
    ->prefix('signatures')
    ->as('signatures/')
    ->group(function () {   
        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', 'update')
            ->name('update')
            ->where('id', '[1-9][0-9]*');

        Route::delete('destroy/{id}', 'destroy')
            ->name('destroy')
            ->where('id', '[1-9][0-9]*');

    });
});