<?php

namespace App\Http\Controllers\Ams;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ams\ActivityLog;

class ActivityLogController extends Controller
{
    //This function is used to get all activity logs
    public function getAllLogs()
    {
        $activityLog = new ActivityLog();
        $activityLog = $activityLog->getAllLogs();
        return view('ams.activity-log', compact('activityLog'));
    }
}
