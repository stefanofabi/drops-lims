<?php

namespace App\Http\Controllers\Administrators\Summaries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Display a generate summaries view
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('administrators.summaries.index');
    }
}