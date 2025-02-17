<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Show the form
    public function create()
    {
        return view('categories.create'); // Blade template
    }

    // Handle form submission
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_url' => 'required|string|max:255',
            'category_meta_title' => 'required|string|max:255',
            'category_meta_keywords' => 'required|string|max:255',
            'category_meta_description' => 'nullable|string',
        ]);

        // Save to database
        Category::create($request->all());

        return redirect()->route('categories.create')->with('success', 'Category saved successfully!');
    }
}
