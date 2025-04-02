<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set web_enabled based on checkbox presence
        $webEnabled = $request->has('web_enabled') ? 1 : 0;

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
            'img' => 'default.jpg'
        ]);

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

        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
            'seo_name' => 'required|string|max:255|unique:mysql_second.categories,seo_name,' . $id,
            'majorcategories_id' => 'required|integer|exists:mysql_second.majorcategories,id',
            'cat_desc_short' => 'nullable|string',
            'cat_desc_long' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set web_enabled based on checkbox presence
        $webEnabled = $request->has('web_enabled') ? 1 : 0;

        DB::connection('mysql_second')
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
                'cat_meta_description' => $request->cat_desc_short ?? ''
            ]);

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

        DB::connection('mysql_second')->table('categories')
            ->where('id', $id)
            ->delete();

        return redirect()->route('ams.mysql-categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
