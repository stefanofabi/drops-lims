<?php

use App\Http\Controllers\Administrators\Settings\BillingPeriodController;


Route::controller(BillingPeriodController::class)
    ->prefix('billing_periods')
    ->as('billing_periods/')
    ->group(function () { 

        Route::get('index', 'index')
        ->name('index');

        Route::get('create', 'create')
        ->name('create');

        Route::post('store', 'store')
        ->name('store')
        ->middleware('verify_billing_period_dates')
        ->middleware('check_overlap_dates');

        Route::get('edit/{id}', 'edit')
        ->name('edit')
        ->where('id', '[1-9][0-9]*');

        Route::put('update/{id}', 'update')
        ->name('update')
        ->where('id', '[1-9][0-9]*')
        ->middleware('verify_billing_period_dates')
        ->middleware('check_overlap_dates');

        Route::delete('destroy/{id}', 'destroy')
        ->name('destroy')
        ->where('id', '[1-9][0-9]*');

        Route::post('load_billing_periods', 'loadBillingPeriods')
        ->name('load_billing_periods');
    });