<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

Route::group([
    'prefix' => 'social_works',
    'as' => 'social_works/',
], function () {

    require('plans.php');
    require('payments_social_works.php');
    require('billing_periods.php');

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'index',
    ])->name('index');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::post('get-social-works', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController',
        'getSocialWorks',
    ])->name('getSocialWorks');

});
