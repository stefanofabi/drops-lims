<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the determinations
|
*/

use App\Http\Controllers\Administrators\Determinations\DeterminationController;
use App\Http\Controllers\Administrators\Determinations\ResultTemplateController;
use App\Http\Controllers\Administrators\Determinations\WorksheetTemplateController;

Route::controller(DeterminationController::class)
    ->prefix('determinations')
    ->as('determinations/')
    ->middleware('permission:manage determinations')
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

        Route::prefix('templates')
        ->as('templates/')
        ->middleware('permission:manage templates')
        ->group(function () {   

            Route::controller(ResultTemplateController::class)
            ->prefix('results')
            ->as('results/')
            ->middleware('permission:manage templates')
            ->group(function () {   
                Route::get('edit/{id}', 'edit')
                ->name('edit')
                ->where('id', '[1-9][0-9]*');

                Route::put('update/{id}', 'update')
                ->name('update')
                ->where('id', '[1-9][0-9]*')
                ->middleware('combine_template_variables')
                ->middleware('redirect_if_not_match_pattern');
            });

            Route::controller(WorksheetTemplateController::class)
            ->prefix('worksheets')
            ->as('worksheets/')
            ->middleware('permission:manage templates')
            ->group(function () {   
                Route::get('edit/{id}', 'edit')
                ->name('edit')
                ->where('id', '[1-9][0-9]*');
    
                Route::put('update/{id}', 'update')
                ->name('update')
                ->where('id', '[1-9][0-9]*');
            });
        });
    });