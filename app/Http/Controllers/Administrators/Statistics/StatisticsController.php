<?php

namespace App\Http\Controllers\Administrators\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    //

    public function index()
    {
        return view('administrators.statistics.index');
    }
}
