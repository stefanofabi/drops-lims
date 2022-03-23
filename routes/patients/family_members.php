<?php

Route::group([
    'prefix' => 'family_members',
    'as' => 'family_members/',
], function () {

    Route::get('index', ['\App\Http\Controllers\Patients\FamilyMemberController', 'index'])
    ->name('index');

    Route::get('create', ['\App\Http\Controllers\Patients\FamilyMemberController', 'create'])
    ->name('create');

    Route::post('store', ['\App\Http\Controllers\Patients\FamilyMemberController', 'store'])
    ->name('store')
    ->middleware('verify_security_code');
});