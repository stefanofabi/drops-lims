<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the social works
|
*/

use App\Http\Controllers\Administrators\Patients\AffiliateController;
use App\Http\Controllers\Administrators\Patients\SocialWorkController;

Route::get('social_works/affiliates/create/{patient_id}', [
    AffiliateController::class,
    'create',
])->name('social_works/affiliates/create')->where('patient_id', '[1-9][0-9]*');

Route::post('social_works/affiliates/store', [
    AffiliateController::class,
    'store',
])->name('social_works/affiliates/store');

Route::post('social_works/affiliates/edit', [AffiliateController::class, 'edit'])->name('social_works/affiliates/edit');

Route::post('social_works/affiliates/update', [
    AffiliateController::class,
    'update',
])->name('social_works/affiliates/update');

Route::post('social_works/affiliates/destroy', [
    AffiliateController::class,
    'destroy',
])->name('social_works/affiliates/destroy');

Route::post('social_works/plans/load', [
    SocialWorkController::class,
    'load_plans',
])->name('social_works/plans/load')->where('id', '[1-9][0-9]*');
