<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MajorCategoryController extends Controller
{
    /**
     * Display a listing of the major categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majorCategories = DB::connection('academyfence')
            ->table('majorcategories')
            ->orderBy('cat_name')
            ->get();

        return view('ams.category-management.mysql-categories.major-index', compact('majorCategories'));
    }

    /**
     * Show the form for creating a new major category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ams.category-management.mysql-categories.major-create');
    }

    /**
     * Store a newly created major category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
            'cat_desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set enabled status based on checkbox presence
        $enabled = $request->has('enabled') ? 1 : 0;

        DB::connection('academyfence')->table('majorcategories')->insert([
            'cat_name' => $request->cat_name,
            'cat_desc' => $request->cat_desc,
            'enabled' => $enabled,
            'cat_date' => now()
        ]);

        return redirect()->route('ams.mysql-majorcategories.index')
            ->with('success', 'Major category created successfully');
    }

    /**
     * Show the form for editing the specified major category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $majorCategory = DB::connection('academyfence')
            ->table('majorcategories')
            ->where('id', $id)
            ->first();

        if (!$majorCategory) {
            return redirect()->route('ams.mysql-majorcategories.index')
                ->with('error', 'Major category not found');
        }

        return view('ams.category-management.mysql-categories.major-edit', compact('majorCategory'));
    }

    /**
     * Update the specified major category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required|string|max:255',
            'cat_desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set enabled status based on checkbox presence
        $enabled = $request->has('enabled') ? 1 : 0;

        DB::connection('academyfence')->table('majorcategories')
            ->where('id', $id)
            ->update([
                'cat_name' => $request->cat_name,
                'cat_desc' => $request->cat_desc,
                'enabled' => $enabled,
                'cat_date' => now()
            ]);

        return redirect()->route('ams.mysql-majorcategories.index')
            ->with('success', 'Major category updated successfully');
    }

    /**
     * Remove the specified major category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if there are categories using this major category
        $categoryCount = DB::connection('academyfence')
            ->table('categories')
            ->where('majorcategories_id', $id)
            ->count();

        if ($categoryCount > 0) {
            return redirect()->route('ams.mysql-majorcategories.index')
                ->with('error', 'Major category cannot be deleted because it has categories associated with it');
        }

        DB::connection('academyfence')->table('majorcategories')
            ->where('id', $id)
            ->delete();

        return redirect()->route('ams.mysql-majorcategories.index')
            ->with('success', 'Major category deleted successfully');
    }
}
