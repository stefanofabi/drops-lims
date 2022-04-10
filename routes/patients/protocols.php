<?php

use App\Http\Controllers\Patients\ProtocolController;

Route::controller(ProtocolController::class)
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

    Route::get('print/{id}', 'printProtocol')
        ->name('print')
        ->where('id', '[1-9][0-9]*')
        ->middleware('verify_protocol_access_relation')
        ->middleware('verify_closed_protocol');

    Route::post('print_selection', 'printPartialReport')
        ->name('print_selection')
        ->middleware('verify_protocol_access_relation')
        ->middleware('check_filtered_practices_to_print');
});