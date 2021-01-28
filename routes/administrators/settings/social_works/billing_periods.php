<?php

Route::group([
    'prefix' => 'billing_periods',
    'as' => 'billing_periods/',
], function () {

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'index',
    ])->name('index');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::post('load_billing_periods', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\BillingPeriodController',
        'load_billing_periods',
    ])->name('load_billing_periods');
});
