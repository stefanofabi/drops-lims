<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('administrators/settings/index');
    }

    /**
     * Display a end day view
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_reports()
    {
        //

        return view('administrators/settings/generate_reports');
    }
}
