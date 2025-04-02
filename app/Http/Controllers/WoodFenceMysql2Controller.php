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
            try {
                $spacingValues = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->where('categories_id', $category->id)
                    ->whereNotNull('spacing')
                    ->whereRaw("spacing != ''")
                    ->distinct()
                    ->pluck('spacing')
                    ->toArray();
            } catch (\Exception $e) {
                // If productsqry view doesn't exist, fall back to products table
                $spacingValues = DB::connection('mysql_second')
                    ->table('products')
                    ->where('categories_id', $category->id)
                    ->whereNotNull('spacing')
                    ->whereRaw("spacing != ''")
                    ->distinct()
                    ->pluck('spacing')
                    ->toArray();
            }
                
            // Filter and clean spacing values
            $spacingOptions = collect($spacingValues)
                ->filter(function($spacing) {
                    return !empty($spacing);
                })
                ->unique()
                ->values()
                ->toArray();

            // If no spacing options found, check size field for potential spacing info
            if (empty($spacingOptions)) {
                try {
                    $sizes = DB::connection('mysql_second')
                        ->table('productsqry')
                        ->where('categories_id', $category->id)
                        ->whereNotNull('size')
                        ->whereRaw("size != ''")
                        ->distinct()
                        ->pluck('size')
                        ->toArray();
                } catch (\Exception $e) {
                    // If productsqry view doesn't exist, fall back to products table
                    $sizes = DB::connection('mysql_second')
                        ->table('products')
                        ->where('categories_id', $category->id)
                        ->whereNotNull('size')
                        ->whereRaw("size != ''")
                        ->distinct()
                        ->pluck('size')
                        ->toArray();
                }
                
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
                    ->values()
                    ->toArray();
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
    public function specs(Request $request, $id, $spacing = null)
    {
        $categoryId = $id;
        $styleTitle = $request->input('styleTitle', '');
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
        try {
            $query = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('categories_id', $categoryId);
        } catch (\Exception $e) {
            // If productsqry view doesn't exist, fall back to products table
            $query = DB::connection('mysql_second')
                ->table('products')
                ->where('categories_id', $categoryId);
        }

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
            'style',
            'speciality',  // Use the correct field from the database
            'material',    // Use the material field from the database
            'spacing',     // Use the spacing field directly
            'img_small',   // Include image fields
            'img_large'
        )->get();

        // Join the products with category data manually since we don't have the view
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->first();

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
                'speciality' => $product->speciality ?? null, // Use the speciality field
                'general_image' => $product->img_large ? '/' . $product->img_large : '/default-product.png', // Use image from DB if available
                'spacing' => $product->spacing ?? $spacing ?? null, // Use DB spacing first, then param spacing
                'family_category_id' => $categoryId, // Add this for compatibility
                'material' => $product->material ?? 'Wood', // Use material from DB if available
            ];
        }

        $formattedProducts = $productsArray;

        // Group products according to groupBy parameter
        if ($groupBy === 'style') {
            // First group products by style (Section Top Style)
            $styleGroups = [];

            // Define common fence styles to ensure they're all represented
            $commonStyles = ['Straight On Top', 'Concave', 'Convex'];
            
            // First, categorize products by style and speciality
            foreach ($formattedProducts as $product) {
                $style = $product['style'] ?? 'Standard';
                
                // Map common style variations to standard names
                if (stripos($style, 'straight') !== false) {
                    $style = 'Straight On Top';
                } elseif (stripos($style, 'concave') !== false) {
                    $style = 'Concave';
                } elseif (stripos($style, 'convex') !== false) {
                    $style = 'Convex';
                }
                
                if (!isset($styleGroups[$style])) {
                    $styleGroups[$style] = [];
                }
                
                // Then within each style, group by speciality (Picket Style)
                $speciality = $product['speciality'] ?? null;
                if ($speciality === null || trim($speciality) === '') {
                    $speciality = 'Standard';
                }
                if (!isset($styleGroups[$style][$speciality])) {
                    $styleGroups[$style][$speciality] = [];
                }
                
                $styleGroups[$style][$speciality][] = $product;
            }
            
            // Ensure all common styles exist even if no products
            foreach ($commonStyles as $style) {
                if (!isset($styleGroups[$style])) {
                    $styleGroups[$style] = [];
                }
            }
            
            // Format for the blade template
            $formattedStyleGroups = [];
            foreach ($styleGroups as $style => $specialities) {
                $combos = [];
                foreach ($specialities as $speciality => $products) {
                    foreach ($products as $product) {
                        $combos[] = $product;
                    }
                }
                
                $formattedStyleGroups[] = [
                    'style' => $style,
                    'combos' => collect($combos)
                ];
            }

            return view('categories.woodfence-specs', [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->cat_name,
                    'description' => $category->cat_desc_long ?? 'No description available',
                    'seo_name' => $category->seo_name,
                ],
                'groupBy' => 'style',
                'styleGroups' => $formattedStyleGroups,
                'spacing' => $spacing,
                'styleTitle' => $styleTitle,
            ]);
        } elseif ($groupBy === 'speciality') {
            // First group products by speciality
            $specialityGroups = [];
            
            foreach ($formattedProducts as $product) {
                $speciality = $product['speciality'] ?? 'Standard';
                
                if (!isset($specialityGroups[$speciality])) {
                    $specialityGroups[$speciality] = [
                        'speciality' => $speciality,
                        'products' => []
                    ];
                }
                
                $specialityGroups[$speciality]['products'][] = $product;
            }
            
            return view('categories.woodfence-specs', [
                'specialityGroups' => $specialityGroups,
                'spacing' => $spacing,
                'styleTitle' => $category->cat_name,
                'categoryId' => $categoryId,
                'groupBy' => $groupBy,
                'products' => $formattedProducts
            ]);
        } else {
            // Since we don't have a speciality column, we'll just use style as the grouping
            $specialityGroups = array_reduce($formattedProducts, function($carry, $product) {
                $style = $product['style'];
                if (!isset($carry[$style])) {
                    $carry[$style] = [];
                }
                $carry[$style][] = $product;
                return $carry;
            }, []);

            return view('categories.woodfence-specs', [
                'category' => [
                    'id' => $category->id,
                    'name' => $category->cat_name,
                    'description' => $category->cat_desc_long ?? 'No description available',
                    'seo_name' => $category->seo_name,
                ],
                'groupBy' => 'speciality',
                'specialityGroups' => array_map(function($group, $style) {
                    return [
                        'speciality' => $style, // Using style as speciality
                        'products' => $group
                    ];
                }, $specialityGroups, array_keys($specialityGroups)),
                'spacing' => $spacing,
                'styleTitle' => $styleTitle,
            ]);
        }
    }
}
