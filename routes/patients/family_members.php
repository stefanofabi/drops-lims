<?php

use App\Http\Controllers\Patients\FamilyMemberController;

Route::controller(FamilyMemberController::class)
->prefix('family_members')
->as('family_members/')
->group(function () {
    Route::get('index', 'index')
        ->name('index');

    Route::get('create', 'create')
        ->name('create');

    Route::post('store', 'store')
        ->name('store')
        ->middleware('verify_security_code');
});