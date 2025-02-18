<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyCategory;

class CategoryController extends Controller
{
    // Show the form to create a new category
    public function create()
    {
        $familyCategories = FamilyCategory::all(); // Fetch all family categories

        return view('categories.create', compact('familyCategories')); // Pass data to view
    }

    // Store the new category
    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'family_category_id' => 'required|integer|exists:family_categories,family_category_id',
            'parent_category_id' => 'nullable|integer|exists:family_categories,family_category_id',
            'family_category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string',
        ]);

        try {
            // Create new category
            FamilyCategory::create($validatedData);

            return redirect()->route('categories.create')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }
}
