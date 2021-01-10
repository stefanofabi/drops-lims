<?php

namespace App\Http\Controllers\Administrators\Settings;

use App\Http\Controllers\Controller;
use \Spatie\Activitylog\Models\Activity;

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

        return view('administrators/settings/logs/activity_logs')->with('activities', $activities);
    }
}
