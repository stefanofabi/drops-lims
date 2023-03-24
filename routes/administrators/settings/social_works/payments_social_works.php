<?php

use App\Http\Controllers\Administrators\Settings\SocialWorks\PaymentSocialWorkController;

Route::controller(PaymentSocialWorkController::class)
    ->prefix('payments')
    ->as('payments/')
    ->group(function () { 

        Route::get('index', 'index')
        ->name('index');

        Route::get('create', 'create')
        ->name('create');

        Route::post('store', 'store')
        ->name('store')
        ->middleware('verify_payment_date_social_work');

        Route::delete('destroy/{id}', 'destroy')
        ->name('destroy')
        ->where('id', '[1-9][0-9]*');
    });