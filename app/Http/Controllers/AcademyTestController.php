<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcademyTestController extends Controller
{
    private function getDatabaseConnection()
    {
        try {
            \DB::connection()->getPdo();
            if (\DB::connection()->getDatabaseName()) {
                echo "Connected to database: " . \DB::connection()->getDatabaseName();
            } else {
                echo "Not connected to any database.";
            }
        } catch (\Exception $e) {
            echo "Could not connect to the database. Please check your configuration. Error: " . $e->getMessage();
        }
    }
    public function index()
    {
        
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();

        return view('academy', compact('majCategories', 'subCategories'));
    }
    public function height($h)
    {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $height = $h;
        return view('academy', compact('majCategories', 'subCategories', 'height'));
    }
}