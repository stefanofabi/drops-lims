<?php

Route::group([
        'prefix' => 'our',
        'as' => 'our/',
    ], function () {

        Route::get('add_practices', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'addPractices',
        ])->name('add_practices');

        Route::get('create', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'create',
        ])->name('create');
        
        Route::post('store', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'store',
        ])->name('store');

        Route::put('update/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'update',
        ])->name('update')->where('id', '[1-9][0-9]*');

        Route::get('edit/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'edit',
        ])->name('edit')->where('id', '[1-9][0-9]*');

        Route::get('destroy/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'destroy',
        ])->name('destroy')->where('id', '[1-9][0-9]*');

        Route::get('print_worksheet/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'printWorksheet',
        ])->name('print_worksheet')->where('id', '[1-9][0-9]*')->middleware('permission:print_worksheets');

        Route::get('print/{id}', [
            '\App\Http\Controllers\Administrators\Protocols\OurProtocolController',
            'printProtocol',
        ])->name('print')->where('id', '[1-9][0-9]*')->middleware('permission:print_protocols');
    });