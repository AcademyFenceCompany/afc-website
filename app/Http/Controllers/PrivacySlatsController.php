<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

// class PrivacySlatsController extends Controller
// {
    // public function show()
    // {
    //     if ($privacySlats->isEmpty()) {
    //     abort(404, 'Privacy Slats category not found.');
    // }

    //     // // Fetch privacy slats products from the database
    //     // $privacySlats = Product::where('category', 'privacy_slats')->get();

    //     // Return the category view
    //     return view('categories.privacy_slats', compact('privacyslats'));
    // }

    class PrivacySlatsController extends Controller
{
    public function show()
    {
        // Return the category view without fetching data
        return view('categories.privacy_slats');
    }
}



