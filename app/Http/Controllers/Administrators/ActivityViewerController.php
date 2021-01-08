<?php

namespace App\Http\Controllers\Administrators;

use App\Http\Controllers\Controller;
use \Spatie\Activitylog\Models\Activity;

//use Illuminate\Http\Request;

class ActivityViewerController extends Controller
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

        $activities = Activity::all();

        return view('administrators/logs/activity_logs')->with('activities', $activities);
    }
}
