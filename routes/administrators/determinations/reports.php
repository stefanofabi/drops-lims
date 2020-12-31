<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the reports
|
*/

use App\Http\Controllers\Administrators\Determinations\ReportController;

Route::group([
    'middleware' => 'permission:crud_reports',
    'prefix' => 'reports',
    'as' => 'reports/',
], function () {

    Route::get('show/{id}', [ReportController::class, 'show'])->name('show')->where('id', '[1-9][0-9]*');

    Route::get('create/{determination_id}', [
        ReportController::class,
        'create',
    ])->name('create')->where('determination_id', '[1-9][0-9]*');

    Route::post('store', [ReportController::class, 'store'])->name('store');

    Route::put('update/{id}', [ReportController::class, 'update'])->name('update')->where('id', '[1-9][0-9]*');

    Route::get('edit/{id}', [ReportController::class, 'edit'])->name('edit')->where('id', '[1-9][0-9]*');

    Route::get('destroy/{id}', [ReportController::class, 'destroy'])->name('destroy')->where('id', '[1-9][0-9]*');
});
