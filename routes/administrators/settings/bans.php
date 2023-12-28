<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the users
|
*/

use App\Http\Controllers\Administrators\Settings\BanController;

Route::controller(BanController::class)
->prefix('bans')
->as('bans/')
->middleware('permission:manage bans')
->group(function () {   
    Route::post('store', 'store')
        ->name('store')
        ->middleware('check_if_not_me');

    Route::delete('unban/{user_id}', 'unban')
        ->name('unban')
        ->where('user_id', '[1-9][0-9]*');
        
});
