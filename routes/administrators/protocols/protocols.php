<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to the protocols
|
*/

use App\Http\Controllers\Administrators\Protocols\ProtocolController;

Route::group([
    'middleware' => 'permission:crud_protocols',
    'prefix' => 'protocols',
    'as' => 'protocols/',
], function () {

    require('our_protocols.php');
    require('practices.php');
    
    Route::get('index', [ProtocolController::class, 'index'])->name('index');
});