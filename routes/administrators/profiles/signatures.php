<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the profiles
|
*/

use App\Http\Controllers\Administrators\Profiles\SignatureController;

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