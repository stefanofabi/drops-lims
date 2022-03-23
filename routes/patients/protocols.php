<?php

Route::group([
    'prefix' => 'protocols',
    'as' => 'protocols/',
], function () {

    require('practices.php');
    
    Route::get('index', ['\App\Http\Controllers\Patients\ProtocolController', 'index'])
    ->name('index')
    ->middleware('verify_family_member_relation');

    Route::get('show/{id}', ['\App\Http\Controllers\Patients\ProtocolController', 'show'])
    ->name('show')
    ->where('id', '[1-9][0-9]*')
    ->middleware('verify_protocol_access_relation');

    Route::get('print/{id}', ['\App\Http\Controllers\Patients\ProtocolController', 'printProtocol'])
    ->name('print')
    ->where('id', '[1-9][0-9]*')
    ->middleware('verify_protocol_access_relation');

    Route::post('print_selection', ['\App\Http\Controllers\Patients\ProtocolController', 'printPartialReport'])
    ->name('print_selection')
    ->middleware('verify_partial_report_relation');
});