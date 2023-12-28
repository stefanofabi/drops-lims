<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the users
|
*/

use App\Http\Controllers\Administrators\Settings\UserController;

Route::controller(UserController::class)
->prefix('users')
->as('users/')
->middleware('permission:manage users')
->group(function () {   
    
    Route::get('index', 'index')
        ->name('index');
    
    Route::get('create', 'create')
        ->name('create');

    Route::post('store', 'store')
        ->name('store');

    Route::get('edit/{id}', 'edit')
        ->name('edit')
        ->where('id', '[1-9][0-9]*');
    
    Route::put('update/{id}', 'update')
        ->name('update')
        ->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', 'destroy')
        ->name('destroy')
        ->where('id', '[1-9][0-9]*')
        ->middleware('check_if_not_me');
        
});
