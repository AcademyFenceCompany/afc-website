<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WoodFenceMysql2Controller extends Controller
{
    public function index()
    {
        // Fetch wood fence categories from mysql_second where majorcategories_id is 1
        $woodFenceCategories = DB::connection('mysql_second')
            ->table('categories')
            ->where('majorcategories_id', 1)
            ->select('id', 'cat_name', 'cat_desc_long', 'seo_name')
            ->get();

        $categoriesWithDetails = [];
        foreach ($woodFenceCategories as $category) {
            // Get unique spacing options from productsqry for this category
            $spacingValues = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('categories_id', $category->id)
                ->whereNotNull('spacing')
                ->whereRaw("spacing != ''")
                ->distinct()
                ->pluck('spacing')
                ->toArray();
                
            // Filter and clean spacing values
            $spacingOptions = collect($spacingValues)
                ->filter(function($spacing) {
                    return !empty($spacing);
                })
                ->unique()
                ->values();

            // If no spacing options found, check size field for potential spacing info
            if ($spacingOptions->isEmpty()) {
                $sizes = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->where('categories_id', $category->id)
                    ->whereNotNull('size')
                    ->whereRaw("size != ''")
                    ->distinct()
                    ->pluck('size')
                    ->toArray();
                
                // Some basic processing to extract potential spacing values from sizes
                $spacingOptions = collect($sizes)
                    ->map(function($size) {
                        if (preg_match('/(\d+(\.\d+)?)\s*(?:inch|in|\"|\'\')/i', $size, $matches)) {
                            return $matches[1] . '"';
                        }
                        return null;
                    })
                    ->filter()
                    ->unique()
                    ->values();
            }

            // Determine if this is a "custom cedar" category based on name or description
            $isCustomCedar = false;
            $isOtherFencing = false;
            
            if (stripos($category->cat_name, 'cedar') !== false || 
                (isset($category->cat_desc_long) && stripos($category->cat_desc_long, 'cedar') !== false)) {
                $isCustomCedar = true;
            }
            // Check for other categories like parts, hardware, etc.
            elseif (stripos($category->cat_name, 'part') !== false || 
                    stripos($category->cat_name, 'hardware') !== false ||
                    stripos($category->cat_name, 'hinge') !== false ||
                    stripos($category->cat_name, 'latch') !== false) {
                $isOtherFencing = true;
            }
            
            // Category grouping for filtering in template
            $categoryGroup = $isCustomCedar ? 'custom_cedar' : ($isOtherFencing ? 'other_fencing' : 'other');

            $categoriesWithDetails[] = [
                'id' => $category->id,
                'name' => $category->cat_name,
                'description' => $category->cat_desc_long ?? 'No description available',
                'image' => '/default.png', // Default image as categoryimages table doesn't exist
                'spacing_options' => $spacingOptions,
                'seo_name' => $category->seo_name,
                'category_group' => $categoryGroup,
                'family_category_id' => $category->id, // Use the actual category ID
                'family_category_name' => $category->cat_name, // Use the actual category name
                'spacing' => $spacingOptions, // For backward compatibility with template
            ];
        }

        return view('categories.woodfence', [
            'wood_categories' => collect($categoriesWithDetails)
        ]);
    }

    /**
     * Display products specs for a specific category
     */
    public function specs(Request $request)
    {
        $categoryId = $request->input('id');
        $spacing = $request->input('spacing');
        $styleTitle = $request->input('style_title', '');
        $groupBy = $request->input('group_by', 'style');

        // Find the category
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->where('majorcategories_id', 1)
            ->select('id', 'cat_name', 'cat_desc_long', 'seo_name')
            ->first();

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        // Base query
        $query = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', $categoryId);

        // Apply spacing filter if provided
        if ($spacing) {
            // Try direct spacing match first
            $query->where(function($q) use ($spacing) {
                $q->where('spacing', $spacing)
                  ->orWhere('size', 'like', "%$spacing%");
            });
        }

        // Get all products for this category and spacing
        $products = $query->select(
            'id as product_id',
            'item_no',
            'categories_id',
            'parent',
            'product_name',
            'price',
            'size',
            'color',
            'style'
        )->get();

        // Convert the database result to a proper array to avoid type issues
        $productsArray = [];
        foreach ($products as $product) {
            $productsArray[] = [
                'product_id' => $product->product_id,
                'item_no' => $product->item_no,
                'categories_id' => $product->categories_id,
                'parent' => $product->parent,
                'product_name' => $product->product_name,
                'price' => $product->price,
                'size' => $product->size,
                'color' => $product->color,
                'style' => $product->style ?? 'Standard',
                'specialty' => 'Standard', // We don't have specialty column in the database
                'general_image' => '/default-product.png', // Default product image
                'spacing' => $spacing ?? null,
            ];
        }

        $formattedProducts = collect($productsArray);

        // Group products according to groupBy parameter
        if ($groupBy === 'style') {
            $styleGroups = $formattedProducts->groupBy('style')->map(function($group, $style) {
                return [
                    'style' => $style,
                    'combos' => $group
                ];
            })->values();

            return view('categories.woodfence-specs', [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->cat_name,
                    'description' => $category->cat_desc_long ?? 'No description available',
                    'seo_name' => $category->seo_name,
                ],
                'groupBy' => 'style',
                'styleGroups' => $styleGroups,
                'styles' => [], // For backward compatibility
                'spacing' => $spacing,
                'styleTitle' => $styleTitle,
            ]);
        } else {
            // Since we don't have a specialty column, we'll just use style as the grouping
            $specialtyGroups = $formattedProducts->groupBy('style')->map(function($group, $style) {
                return [
                    'specialty' => $style, // Using style as specialty
                    'products' => $group
                ];
            })->values();

            return view('categories.woodfence-specs', [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->cat_name,
                    'description' => $category->cat_desc_long ?? 'No description available',
                    'seo_name' => $category->seo_name,
                ],
                'groupBy' => 'specialty',
                'specialtyGroups' => $specialtyGroups,
                'spacing' => $spacing,
                'styleTitle' => $styleTitle,
            ]);
        }
    }
}
