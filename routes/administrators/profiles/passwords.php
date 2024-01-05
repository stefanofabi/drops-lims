<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the passwords
|
*/

use App\Http\Controllers\Administrators\Profiles\PasswordController;

Route::controller(PasswordController::class)
->as('passwords/')
->group(function () {   
    Route::get('{id}/passwords/edit', 'edit')
        ->name('edit')
        ->where('id', '[1-9][0-9]*');

    Route::put('{id}/passwords/update', 'update')
        ->name('update')
        ->where('id', '[1-9][0-9]*');

});