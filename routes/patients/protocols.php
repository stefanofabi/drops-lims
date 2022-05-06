<?php

use App\Http\Controllers\Patients\InternalProtocolController;

Route::controller(InternalProtocolController::class)
->prefix('protocols')
->as('protocols/')
->group(function () {

    require('practices.php');
    
    Route::get('index', 'index')
        ->name('index')
        ->middleware('verify_family_member_relation');

    Route::get('show/{id}', 'show')
        ->name('show')
        ->where('id', '[1-9][0-9]*')
        ->middleware('verify_protocol_access_relation');

    Route::get('generate_protocol/{id}', 'generateProtocol')
        ->name('generate_protocol')
        ->where('id', '[1-9][0-9]*')
        ->middleware('verify_protocol_access_relation')
        ->middleware('check_filtered_practices_to_print');
});