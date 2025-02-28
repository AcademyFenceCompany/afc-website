<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use App\Models\CategoryPage;
use App\Models\FamilyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryPageController extends Controller
{
    public function index()
    {
        $pages = CategoryPage::with('category')->get();
        return view('ams.cms.pages.index', compact('pages'));
    }

    public function create()
    {
        $categories = FamilyCategory::all();
        return view('ams.cms.pages.create', [
            'page' => null,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_category_id' => 'required|exists:family_categories,family_category_id',
            'template' => 'required|string|in:standard,welded_wire',
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
        ]);

        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')
                ->store('category-pages', 'public');
        }

        if ($request->hasFile('footer_product_image')) {
            $validated['footer_product_image'] = $request->file('footer_product_image')
                ->store('category-pages', 'public');
        }

        CategoryPage::create($validated);

        return redirect()->route('ams.cms.pages.index')
            ->with('success', 'Category page created successfully.');
    }

    public function edit(CategoryPage $page)
    {
        $categories = FamilyCategory::all();
        return view('ams.cms.pages.edit', compact('page', 'categories'));
    }

    public function update(Request $request, CategoryPage $page)
    {
        $validated = $request->validate([
            'family_category_id' => 'required|exists:family_categories,family_category_id',
            'template' => 'required|string|in:standard,welded_wire',
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
        ]);

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

        $page->update($validated);

        return redirect()->route('ams.cms.pages.index')
            ->with('success', 'Category page updated successfully.');
    }

    public function destroy(CategoryPage $page)
    {
        if ($page->product_image) {
            Storage::disk('public')->delete($page->product_image);
        }
        if ($page->footer_product_image) {
            Storage::disk('public')->delete($page->footer_product_image);
        }
        
        $page->delete();

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
