<?php

Route::group([
    'prefix' => 'plans',
    'as' => 'plans/',
], function () {

    Route::get('index', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PlanController',
        'index',
    ])->name('index');

    Route::get('create/{social_work_id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PlanController',
        'create',
    ])->name('create')->where('social_work_id', '[1-9][0-9]*');

    Route::post('store', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PlanController',
        'store',
    ])->name('store');

    Route::get('edit/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PlanController',
        'edit',
    ])->name('edit')->where('id', '[1-9][0-9]*');

    Route::put('update/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PlanController',
        'update',
    ])->name('update')->where('id', '[1-9][0-9]*');

    Route::delete('destroy/{id}', [
        '\App\Http\Controllers\Administrators\Settings\SocialWorks\PlanController',
        'destroy',
    ])->name('destroy')->where('id', '[1-9][0-9]*');
});
