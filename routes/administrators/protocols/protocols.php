<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

Route::group([
    'middleware' => 'permission:crud_protocols',
    'prefix' => 'protocols',
    'as' => 'protocols/',
], function () {

    require('our_protocols.php');
    require('practices.php');
    
    Route::get('protocols/index', [
        '\App\Http\Controllers\Administrators\Protocols\ProtocolController',
        'index',
    ])->name('index')
    ->middleware('permission:crud_protocols');

});
