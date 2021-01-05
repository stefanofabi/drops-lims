<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

Route::get('social_works/affiliates/create/{patient_id}', [
    '\App\Http\Controllers\Administrators\Patients\AffiliateController',
    'create',
])->name('social_works/affiliates/create')->where('patient_id', '[1-9][0-9]*');

Route::post('social_works/affiliates/store', [
    '\App\Http\Controllers\Administrators\Patients\AffiliateController',
    'store',
])->name('social_works/affiliates/store');

Route::post('social_works/affiliates/edit', [
    '\App\Http\Controllers\Administrators\Patients\AffiliateController',
    'edit',
])->name('social_works/affiliates/edit');

Route::post('social_works/affiliates/update', [
    '\App\Http\Controllers\Administrators\Patients\AffiliateController',
    'update',
])->name('social_works/affiliates/update');

Route::post('social_works/affiliates/destroy', [
    '\App\Http\Controllers\Administrators\Patients\AffiliateController',
    'destroy',
])->name('social_works/affiliates/destroy');

Route::post('social_works/plans/load', [
    '\App\Http\Controllers\Administrators\SocialWorks\SocialWorkController',
    'load_plans',
])->name('social_works/plans/load');
