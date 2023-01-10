<?php

namespace App\Http\Controllers\Administrators\Logs;

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

        $activities = Activity::orderBy('id', 'DESC')
            ->take(50)
            ->get();

        return view('administrators/activity_logs/index')
            ->with('activities', $activities);
    }
}
