<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all major categories
        $majorCategories = DB::connection('mysql_second')
            ->table('majorcategories')
            ->orderBy('id')
            ->get();
            
        // Get all categories with their associated major category name
        $categories = DB::connection('mysql_second')
            ->table('categories')
            ->select('categories.*', 'majorcategories.cat_name as major_cat_name')
            ->leftJoin('majorcategories', 'categories.majorcategories_id', '=', 'majorcategories.id')
            ->orderBy('categories.id')
            ->get();

        return view('ams.category-management.mysql-categories.index', compact('categories', 'majorCategories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $majorCategories = DB::connection('mysql_second')
            ->table('majorcategories')
            ->orderBy('id')
            ->get();

        return view('ams.category-management.mysql-categories.create', compact('majorCategories'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
            'seo_name' => 'required|string|max:255|unique:mysql_second.categories',
            'majorcategories_id' => 'required|integer|exists:mysql_second.majorcategories,id',
            'cat_desc_short' => 'nullable|string',
            'cat_desc_long' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set web_enabled based on checkbox presence
        $webEnabled = $request->has('web_enabled') ? 1 : 0;
        
        // Handle image upload
        $imageName = 'default.png'; 
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Store the image in the storage/app/public/categories directory
                $image->storeAs('public/categories', $imageName);
                Log::info('Store: Image uploaded successfully', ['name' => $imageName]);
            } catch (\Exception $e) {
                Log::error('Store: Image upload failed', ['error' => $e->getMessage()]);
            }
        }

        try {
            // Insert data with explicit field list to ensure all fields are included
            DB::connection('mysql_second')->table('categories')->insert([
                'cat_name' => $request->cat_name,
                'seo_name' => $request->seo_name,
                'majorcategories_id' => $request->majorcategories_id,
                'cat_desc_short' => $request->cat_desc_short,
                'cat_desc_long' => $request->cat_desc_long,
                'web_enabled' => $webEnabled,
                'cat_date' => now(),
                'cat_mod' => now(),
                'cat_parent_id' => $request->majorcategories_id,
                'cat_url' => $request->seo_name,
                'cat_meta_title' => $request->cat_name,
                'cat_meta_keywords' => '',
                'cat_meta_description' => $request->cat_desc_short ?? '',
                'insert_keywords' => '',
                'page_template' => 0,
                'blog_tag' => 0,
                'image' => $imageName
            ]);
            
            Log::info('Category created successfully with data:', [
                'cat_name' => $request->cat_name,
                'web_enabled' => $webEnabled,
                'image' => $imageName
            ]);
        } catch (\Exception $e) {
            Log::error('Category creation failed:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('ams.mysql-categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $id)
            ->first();

        if (!$category) {
            return redirect()->route('ams.mysql-categories.index')
                ->with('error', 'Category not found');
        }

        $majorCategories = DB::connection('mysql_second')
            ->table('majorcategories')
            ->orderBy('id')
            ->get();

        return view('ams.category-management.mysql-categories.edit', compact('category', 'majorCategories'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $id)
            ->first();

        if (!$category) {
            return redirect()->route('ams.mysql-categories.index')
                ->with('error', 'Category not found');
        }

        // Debug: Log the full request data
        Log::info('Category Update Request Data:', $request->all());
        Log::info('Form has web_enabled?', ['value' => $request->has('web_enabled')]);
        
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
            'seo_name' => 'required|string|max:255|unique:mysql_second.categories,seo_name,' . $id,
            'majorcategories_id' => 'required|integer|exists:mysql_second.majorcategories,id',
            'cat_desc_short' => 'nullable|string',
            'cat_desc_long' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set web_enabled based on checkbox presence - force integer type
        $webEnabled = $request->has('web_enabled') ? 1 : 0;
        Log::info('Web enabled value set to:', ['web_enabled' => $webEnabled]);
        
        // Handle image upload if there's a new image
        $imageName = $category->image ?? 'default.png';
        if ($request->hasFile('image')) {
            try {
                // Remove old image if it's not the default
                if ($imageName && !in_array($imageName, ['default.png', 'default.jpg'])) {
                    Storage::delete('public/categories/' . $imageName);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Store the image in the storage/app/public/categories directory
                $image->storeAs('public/categories', $imageName);
                
                Log::info('Update: Image uploaded successfully', ['name' => $imageName]);
            } catch (\Exception $e) {
                Log::error('Update: Image upload failed', ['error' => $e->getMessage()]);
            }
        }

        try {
            // Update with direct values to ensure proper assignment
            $result = DB::connection('mysql_second')
                ->table('categories')
                ->where('id', $id)
                ->update([
                    'cat_name' => $request->cat_name,
                    'seo_name' => $request->seo_name,
                    'majorcategories_id' => $request->majorcategories_id,
                    'cat_desc_short' => $request->cat_desc_short,
                    'cat_desc_long' => $request->cat_desc_long,
                    'web_enabled' => $webEnabled,
                    'cat_mod' => now(),
                    'cat_url' => $request->seo_name,
                    'cat_meta_title' => $request->cat_name,
                    'cat_meta_description' => $request->cat_desc_short ?? '',
                    'image' => $imageName
                ]);
            
            Log::info('Category updated successfully:', [
                'id' => $id, 
                'rows_affected' => $result,
                'image' => $imageName,
                'web_enabled' => $webEnabled
            ]);
            
            // Double-check if update worked by retrieving the updated record
            $updatedCategory = DB::connection('mysql_second')
                ->table('categories')
                ->where('id', $id)
                ->first();
            
            Log::info('Updated category values:', [
                'web_enabled' => $updatedCategory->web_enabled,
                'image' => $updatedCategory->image
            ]);
        } catch (\Exception $e) {
            Log::error('Category update failed:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('ams.mysql-categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if there are products using this category
        $productCount = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', $id)
            ->count();

        if ($productCount > 0) {
            return redirect()->route('ams.mysql-categories.index')
                ->with('error', 'Category cannot be deleted because it has products associated with it');
        }
        
        // Get category image before deletion
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $id)
            ->first();
            
        // Delete the image file if it's not the default
        if ($category && $category->image && !in_array($category->image, ['default.png', 'default.jpg'])) {
            Storage::delete('public/categories/' . $category->image);
        }

        DB::connection('mysql_second')->table('categories')
            ->where('id', $id)
            ->delete();

        return redirect()->route('ams.mysql-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}