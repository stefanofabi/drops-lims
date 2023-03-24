<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the internal protocols
|
*/

use App\Http\Controllers\Administrators\InternalProtocols\InternalProtocolController;

Route::controller(InternalProtocolController::class)
    ->prefix('internal_protocols')
    ->as('protocols/')
    ->middleware('permission:manage protocols')
    ->group(function () {
        require('internal_practices.php');
        
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
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_protocol')
            ->middleware('check_nomenclator_when_updating_internal_protocol');

        Route::delete('destroy/{id}', 'destroy')
            ->name('destroy')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_protocol');

        Route::get('generate_worksheet/{id}', 'generateWorksheet')
            ->name('generate_worksheet')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:print worksheets')
            ->middleware('verify_open_protocol');

        Route::get('generate_protocol/{id}', 'generateProtocol')
            ->name('generate_protocol')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:print protocols')
            ->middleware('check_filtered_practices_to_print');

        Route::post('close/{id}', 'closeProtocol')
            ->name('close')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_protocol')
            ->middleware('check_if_exists_loaded_practices')
            ->middleware('verify_all_practices_signed');
                
        Route::post('send_protocol_to_email/{id}', 'sendProtocolToEmail')
            ->name('send_protocol_to_email')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:print protocols')
            ->middleware('check_filtered_practices_to_print')
            ->middleware('check_protocol_can_sent_by_email');
    });