<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

use App\Http\Controllers\Administrators\Settings\SocialWorks\SocialWorkController;

Route::group([
    'prefix' => 'social_works',
    'as' => 'social_works/',
], function () {

    require('plans.php');
    require('payments_social_works.php');

    Route::controller(SocialWorkController::class)
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

        Route::post('get-social-works', 'getSocialWorks')
            ->name('getSocialWorks');
    });
});
