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

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'index',
    ])->name('index');

    Route::get('create', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'create',
    ])->name('create');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');

    Route::post('plans/load', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorkController',
        'load_plans',
    ])->name('social_works/plans/load');
});
