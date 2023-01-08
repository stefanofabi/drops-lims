<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    /**
     * Display a listing of the settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('administrators.settings.index');
    }
}
