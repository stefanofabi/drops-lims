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

Route::group([
    'prefix' => 'profiles',
    'as' => 'profiles/',
    'middleware' => ['permission:manage profile', 'redirect_if_not_my_profile'],
], function () {

    require('signatures.php');
    require('passwords.php');

    Route::controller(ProfileController::class)
    ->group(function () {   
        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', 'update')
            ->name('update')
            ->where('id', '[1-9][0-9]*');

    });
});