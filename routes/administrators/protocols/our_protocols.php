<?php

use App\Http\Controllers\Administrators\Protocols\OurProtocolController;

Route::controller(OurProtocolController::class)
    ->prefix('our')
    ->as('our/')
    ->group(function () {
        Route::get('create', 'create')
            ->name('create');
        
        Route::post('store', 'store')
            ->name('store');

        Route::put('update/{id}', 'update')
            ->name('update')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_protocol');

        Route::get('edit/{id}', 'edit')
            ->name('edit')
            ->where('id', '[1-9][0-9]*');

        Route::get('destroy/{id}', 'destroy')
            ->name('destroy')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_protocol');

        Route::get('print_worksheet/{id}', 'printWorksheet')
            ->name('print_worksheet')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:print_worksheets')
            ->middleware('verify_open_protocol');

        Route::get('print/{id}', 'printProtocol')
            ->name('print')
            ->where('id', '[1-9][0-9]*')
            ->middleware('permission:print_protocols')
            ->middleware('verify_closed_protocol');

        Route::post('close/{id}', 'closeProtocol')
            ->name('close')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_open_protocol')
            ->middleware('check_if_exists_loaded_practices')
            ->middleware('verify_all_practices_signed');
            

        Route::post('sendProtocolToEmail/{id}', 'sendProtocolToEmail')
            ->name('send_protocol_to_email')
            ->where('id', '[1-9][0-9]*')
            ->middleware('verify_closed_protocol');
    });