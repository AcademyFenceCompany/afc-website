<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryPageController extends Controller
{
    public function index()
    {
        $pages = DB::connection('academyfence')
            ->table('category_pages')
            ->join('majorcategories', 'category_pages.family_category_id', '=', 'majorcategories.id')
            ->select('category_pages.*', 'majorcategories.cat_name')
            ->get();

        return view('ams.cms.pages.index', compact('pages'));
    }

    public function create()
    {
        $categories = DB::connection('academyfence')
            ->table('categories')
            ->get();

        return view('ams.cms.pages.create', [
            'page' => null,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_category_id' => 'required|exists:academyfence.categories,id',
            'template' => 'required|string|in:standard,welded_wire,razor_wire',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'bulletin_board' => 'nullable|string',
            'product_image' => 'nullable|image|max:2048',
            'product_text' => 'nullable|string',
            'category_tidbit_1' => 'nullable|string',
            'category_tidbit_2' => 'nullable|string',
            'category_tidbit_3' => 'nullable|string',
            'footer_subtitle' => 'nullable|string|max:500',
            'footer_bulletin_board' => 'nullable|string',
            'footer_product_image' => 'nullable|image|max:2048',
            'footer_product_text' => 'nullable|string',
            'menu_type' => 'nullable|string|in:main_menu,quick_menu',
            'menu_order' => 'nullable|integer|min:0'
        ]);

        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')
                ->store('category-pages', 'public');
        }

        if ($request->hasFile('footer_product_image')) {
            $validated['footer_product_image'] = $request->file('footer_product_image')
                ->store('category-pages', 'public');
        }

        $validated['slug'] = \Str::slug($validated['title'] ?? 'category-page-' . time());

        DB::connection('academyfence')
            ->table('category_pages')
            ->insert($validated);

        return redirect()->route('ams.cms.pages.index')
            ->with('success', 'Category page created successfully.');
    }

    public function edit($id)
    {
        $page = DB::connection('academyfence')
            ->table('category_pages')
            ->where('id', $id)
            ->first();

        if (!$page) {
            return redirect()->route('ams.cms.pages.index')
                ->with('error', 'Category page not found.');
        }

$categories = DB::connection('academyfence')
    ->table('majorcategories')
    ->get();

return view('ams.cms.pages.edit', compact('page', 'categories'));
}

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'family_category_id' => 'required|exists:academyfence.majorcategories,id',
            'template' => 'required|string|in:standard,welded_wire,razor_wire',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'bulletin_board' => 'nullable|string',
            'product_image' => 'nullable|image|max:2048',
            'product_text' => 'nullable|string',
            'category_tidbit_1' => 'nullable|string',
            'category_tidbit_2' => 'nullable|string',
            'category_tidbit_3' => 'nullable|string',
            'footer_subtitle' => 'nullable|string|max:500',
            'footer_bulletin_board' => 'nullable|string',
            'footer_product_image' => 'nullable|image|max:2048',
            'footer_product_text' => 'nullable|string',
            'menu_type' => 'nullable|string|in:main_menu,quick_menu',
            'menu_order' => 'nullable|integer|min:0'
        ]);

        $page = DB::connection('academyfence')
            ->table('category_pages')
            ->where('id', $id)
            ->first();

        if (!$page) {
            return redirect()->route('ams.cms.pages.index')
                ->with('error', 'Category page not found.');
        }

        if ($request->hasFile('product_image')) {
            if ($page->product_image) {
                Storage::disk('public')->delete($page->product_image);
            }
            $validated['product_image'] = $request->file('product_image')
                ->store('category-pages', 'public');
        }

        if ($request->hasFile('footer_product_image')) {
            if ($page->footer_product_image) {
                Storage::disk('public')->delete($page->footer_product_image);
            }
            $validated['footer_product_image'] = $request->file('footer_product_image')
                ->store('category-pages', 'public');
        }

        if (isset($validated['title']) && $validated['title'] !== $page->title) {
            $validated['slug'] = \Str::slug($validated['title'] ?? 'category-page-' . time());
        }

        DB::connection('academyfence')
            ->table('category_pages')
            ->where('id', $id)
            ->update($validated);

        return redirect()->route('ams.cms.pages.index')
            ->with('success', 'Category page updated successfully.');
    }

    public function destroy($id)
    {
        $page = DB::connection('academyfence')
            ->table('category_pages')
            ->where('id', $id)
            ->first();

        if (!$page) {
            return redirect()->route('ams.cms.pages.index')
                ->with('error', 'Category page not found.');
        }

        if ($page->product_image) {
            Storage::disk('public')->delete($page->product_image);
        }
        if ($page->footer_product_image) {
            Storage::disk('public')->delete($page->footer_product_image);
        }
        
        DB::connection('academyfence')
            ->table('category_pages')
            ->where('id', $id)
            ->delete();

        return redirect()->route('ams.cms.pages.index')
            ->with('success', 'Category page deleted successfully.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/uploads/editor');
            
            return response()->json([
                'location' => Storage::url($path)
            ]);
        }
        
        return response()->json([
            'error' => 'No file uploaded'
        ], 400);
    }
}
