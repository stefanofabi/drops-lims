<?php

Route::group([
    'prefix' => 'payments',
    'as' => 'payments/',
], function () {

    Route::get('create/{social_work_id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PaymentSocialWorkController',
        'create',
    ])->name('create')->where('social_work_id', '[1-9][0-9]*');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PaymentSocialWorkController',
        'store',
    ])->name('store')
    ->middleware('verify_payment_date_social_work');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PaymentSocialWorkController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PaymentSocialWorkController',
        'update',
    ])->name('update')
    ->where('id', '[1-9][0-9]*')
    ->middleware('verify_payment_date_social_work');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PaymentSocialWorkController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');
});
