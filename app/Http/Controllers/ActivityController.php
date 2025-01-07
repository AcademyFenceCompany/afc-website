<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // Return the AMS Activity view
        return view('ams.activity'); // Ensure the view file exists
    }
}
