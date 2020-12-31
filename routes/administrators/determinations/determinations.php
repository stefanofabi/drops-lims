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

Route::get('determinations', [
    DeterminationController::class,
    'index',
])->name('determinations')->middleware('permission:crud_determinations');
Route::post('determinations', [
    DeterminationController::class,
    'load',
])->name('determinations/load')->middleware('permission:crud_determinations');

Route::group([
    'middleware' => 'permission:crud_determinations',
    'prefix' => 'determinations',
    'as' => 'determinations/',
], function () {

    require('reports.php');

    Route::get('create', [DeterminationController::class, 'create'])->name('create');

    Route::post('store', [DeterminationController::class, 'store'])->name('store');

    Route::get('show/{id}', [DeterminationController::class, 'show'])->name('show')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [DeterminationController::class, 'update'])->name('update')->where('id', '[1-9][0-9]*');

    Route::get('edit/{id}', [DeterminationController::class, 'edit'])->name('edit')->where('id', '[1-9][0-9]*');

    Route::get('destroy/{id}', [
        DeterminationController::class,
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::patch('restore/{id}', [
        DeterminationController::class,
        'restore',
    ])->name('restore')->where('id', '[1-9][0-9]*');
});
