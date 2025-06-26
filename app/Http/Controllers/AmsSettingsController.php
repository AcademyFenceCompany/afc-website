<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmsSettingsController extends Controller
{
    //
    public function index()
    {
        // Logic to retrieve and display AMS settings
        return view('ams.ams-settings');
    }
}
