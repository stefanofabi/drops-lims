<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the system parameters
|
*/

use App\Http\Controllers\Administrators\Settings\SystemParameterController;

Route::controller(SystemParameterController::class)
->prefix('system_parameters')
->as('system_parameters/')
->middleware('permission:manage system parameters')
->group(function () {   

    Route::get('edit', 'edit')
        ->name('edit');

    Route::put('update', 'update')
        ->name('update');
});
