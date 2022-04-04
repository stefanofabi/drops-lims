<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the nomenclators
|
*/

use App\Http\Controllers\Administrators\Settings\NomenclatorController;

Route::controller(NomenclatorController::class)
    ->prefix('nomenclators')
    ->as('nomenclators/')
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
            ->where('id', '[1-9][0-9]*');
    });
