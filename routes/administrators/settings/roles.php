<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the roles
|
*/

use App\Http\Controllers\Administrators\Settings\RoleController;

Route::controller(RoleController::class)
->prefix('roles')
->as('roles/')
->middleware('permission:manage roles')
->group(function () {   
    Route::get('index', 'index')
        ->name('index');
    
    Route::get('create', 'create')
        ->name('create');

    Route::post('store', 'store')
        ->name('store')
        ->middleware('unique_environment');

    Route::get('edit/{id}', 'edit')
        ->name('edit')
        ->where('id', '[1-9][0-9]*');
    
    Route::put('update/{id}', 'update')
        ->name('update')
        ->where('id', '[1-9][0-9]*')
        ->middleware('check_self_sabotage')
        ->middleware('unique_environment');

    Route::delete('destroy/{id}', 'destroy')
        ->name('destroy')
        ->where('id', '[1-9][0-9]*');
        
});
