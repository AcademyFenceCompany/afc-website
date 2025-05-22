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
            ->where('web_enabled', 1) // Only show web-enabled categories
            ->select('id', 'cat_name', 'cat_desc_long', 'seo_name', 'image', 'web_enabled')
            ->orderBy('page_template', 'desc')
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
            
            // Force specific categories to be put in accessories group regardless of content
            if (in_array($category->id, [82, 147, 791])) {
                $categoryGroup = 'accessories';
            }

            $categoriesWithDetails[] = [
                'id' => $category->id,
                'name' => $category->cat_name,
                'description' => $category->cat_desc_long ?? 'No description available',
                'image' => $category->image ? url('storage/categories/' . $category->image) : url('storage/categories/default.png'),
                'spacing_options' => $spacingOptions,
                'seo_name' => $category->seo_name,
                'category_group' => $categoryGroup,
                'family_category_id' => $category->id, // Use the actual category ID
                'family_category_name' => $category->cat_name, // Use the actual category name
                'spacing' => $spacingOptions, // For backward compatibility with template
                'web_enabled' => $category->web_enabled,
            ];
        }
        
        // Group categories by category_group
        $groupedCategories = collect($categoriesWithDetails)->groupBy('category_group');
        
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

        // Check if the category exists
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->first();
        
        if (!$category) {
            return redirect()->route('woodfence.mysql2.index')->with('error', 'Category not found');
        }
        
        // If this is category ID 7 (Board On Board), redirect to the dedicated controller
        if ($categoryId == 7) {
            return redirect()->route('solidboard');
        }
        
        // Special handling for category ID 6 (Spaced Picket)
        $isSpacedPicket = ($categoryId == 6);
        
        // Special handling for category ID 7 (Board On Board)
        $isBoardOnBoard = ($categoryId == 7);
        
        // Create a product ID map for specific styles and specialities
        $productIdMap = [];
        
        // Set up product ID mapping for Solid Board (Board On Board)
        if ($isBoardOnBoard) {
            $productIdMap = [
                'Straight On Top' => [
                    'Slant Ear' => 'product/3028',
                    'Gothic Point' => 'product/3150',
                    'French Gothic' => 'product/3220'
                ],
                'Concave' => [
                    'Flat Picket' => 'product/3118',
                    'Gothic Point' => 'product/3167',
                    'French Gothic' => 'product/3236'
                ],
                'Convex' => [
                    'Flat Picket' => 'product/3135',
                    'Gothic Point' => 'product/3176',
                    'French Gothic' => 'product/3253'
                ]
            ];
        }
        
        // Base query
        try {
            $query = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('categories_id', $categoryId)
                ->where('enabled', 1);
        } catch (\Exception $e) {
            // If productsqry view doesn't exist, fall back to products table
            $query = DB::connection('mysql_second')
                ->table('products')
                ->where('categories_id', $categoryId)
                ->where('enabled', 1);
        }

        // Apply spacing filter if provided and not category 7
        if ($spacing && !$isBoardOnBoard) {
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
            'speciality',  // Use speciality as the column name
            'material',    
            'spacing',     
            'img_small',   
            'img_large',
            'desc_short',
            'product_assoc',
            'enabled as web_enabled' // Map enabled to web_enabled
        )->get();

        // Join the products with category data manually since we don't have the view
        $category = DB::connection('mysql_second')
            ->table('categories')
            ->where('id', $categoryId)
            ->first();

        // Convert the database result to a proper array to avoid type issues
        $productsArray = [];
        foreach ($products as $product) {
            // Extract pickets per section from product name or description
            $picketsPerSection = '17 (16 + 1 Cover Picket)'; // Default value
            $productName = $product->product_name ?? '';
            $description = $product->desc_short ?? '';
            
            if (preg_match('/(\d+)\s*pickets?/i', $productName, $matches) || 
                preg_match('/(\d+)\s*pickets?/i', $description, $matches)) {
                $picketsPerSection = $matches[1] . ' Pickets';
            }
            
            // Standardize style names for category ID 6 and 7
            $style = $product->style ?? 'Standard';
            if ($isSpacedPicket || $isBoardOnBoard) {
                if (stripos($style, 'straight') !== false) {
                    $style = 'Straight On Top';
                } elseif (stripos($style, 'concave') !== false) {
                    $style = 'Concave';
                } elseif (stripos($style, 'convex') !== false) {
                    $style = 'Convex';
                }
            }
            
            // Standardize speciality names for category ID 6 and 7
            $speciality = $product->speciality ?? null;
            if (($isSpacedPicket || $isBoardOnBoard) && $speciality) {
                if (stripos($speciality, 'slant') !== false || stripos($speciality, 'ear') !== false) {
                    $speciality = 'Slant Ear';
                } elseif (stripos($speciality, 'gothic') !== false && stripos($speciality, 'french') !== false) {
                    $speciality = 'French Gothic';
                } elseif (stripos($speciality, 'gothic') !== false) {
                    $speciality = 'Gothic Point';
                } elseif (stripos($speciality, 'flat') !== false) {
                    $speciality = 'Flat Picket';
                }
            }
            
            $productsArray[] = [
                'product_id' => $product->product_id,
                'item_no' => $product->item_no,
                'categories_id' => $product->categories_id,
                'parent' => $product->parent,
                'product_name' => $product->product_name,
                'price' => $product->price,
                'size' => $product->size,
                'color' => $product->color,
                'style' => $style,
                'speciality' => $speciality, 
                'general_image' => $product->img_large ? url('storage/products/' . $product->img_large) : url('storage/products/default.png'),
                'spacing' => $product->spacing ?? $spacing ?? null, 
                'family_category_id' => $categoryId, 
                'material' => $product->material ?? 'Wood', 
                'web_enabled' => $product->web_enabled,
                'picketsPerSection' => $picketsPerSection,
                'description' => $product->desc_short ?? '',
                'product_assoc' => $product->product_assoc ?? null,
            ];
        }

        $formattedProducts = $productsArray;

        // Add the image to the category object
        $category->image = $category->image ? url('storage/categories/' . $category->image) : url('storage/categories/default.png');

        // Group products according to groupBy parameter
        if ($groupBy === 'style') {
            // First group products by style (Section Top Style)
            $styleGroups = [];

            // Define common fence styles to ensure they're all represented
            $commonStyles = ['Straight On Top', 'Concave', 'Convex'];
            
            // First, categorize products by style and speciality
            foreach ($formattedProducts as $product) {
                $style = $product['style'] ?? 'Standard';
                
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
            
            // For category ID 6 (Spaced Picket) or 7 (Board On Board), ensure specific speciality order
            if ($isSpacedPicket || $isBoardOnBoard) {
                // Define the speciality order for each style
                $specialityOrderMap = [
                    'Straight On Top' => ['Slant Ear', 'Gothic Point', 'French Gothic'],
                    'Concave' => ['Flat Picket', 'Gothic Point', 'French Gothic'],
                    'Convex' => ['Flat Picket', 'Gothic Point', 'French Gothic']
                ];
                
                // Reorder specialities within each style
                foreach ($commonStyles as $style) {
                    if (isset($styleGroups[$style]) && !empty($styleGroups[$style])) {
                        $orderedSpecialities = [];
                        $specialityOrder = $specialityOrderMap[$style] ?? [];
                        
                        // First add specialities in the preferred order
                        foreach ($specialityOrder as $specialityName) {
                            if (isset($styleGroups[$style][$specialityName])) {
                                $orderedSpecialities[$specialityName] = $styleGroups[$style][$specialityName];
                            } else {
                                // Create empty placeholder to maintain order
                                $orderedSpecialities[$specialityName] = [];
                            }
                        }
                        
                        // Then add any remaining specialities
                        foreach ($styleGroups[$style] as $speciality => $products) {
                            if (!in_array($speciality, $specialityOrder)) {
                                $orderedSpecialities[$speciality] = $products;
                            }
                        }
                        
                        // Replace with ordered specialities
                        $styleGroups[$style] = $orderedSpecialities;
                    }
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
                    'image' => $category->image,
                ],
                'groupBy' => 'style',
                'styleGroups' => $formattedStyleGroups,
                'spacing' => $spacing,
                'styleTitle' => $styleTitle,
                'isSpacedPicket' => $isSpacedPicket,
                'productIdMap' => $productIdMap
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
                'isSpacedPicket' => $isSpacedPicket,
                'productIdMap' => $productIdMap
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
                    'image' => $category->image,
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
                'isSpacedPicket' => $isSpacedPicket,
                'productIdMap' => $productIdMap
            ]);
        }
    }

    /**
     * Display all wood fence products with grouping options
     */
    public function specsAll(Request $request)
    {
        $groupBy = $request->input('groupBy', 'style');

        // Get all wood fence products
        try {
            $query = DB::connection('mysql_second')
                ->table('productsqry')
                ->whereIn('categories_id', function($query) {
                    $query->select('id')
                        ->from('categories')
                        ->where('majorcategories_id', 1)
                        ->where('web_enabled', 1);
                });
        } catch (\Exception $e) {
            // If productsqry view doesn't exist, fall back to products table
            $query = DB::connection('mysql_second')
                ->table('products')
                ->whereIn('categories_id', function($query) {
                    $query->select('id')
                        ->from('categories')
                        ->where('majorcategories_id', 1)
                        ->where('web_enabled', 1);
                });
        }

        // Get all products for wood fence categories
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
            'speciality', // Use speciality as the column name
            'material',
            'spacing',
            'img_small',
            'img_large',
            'enabled as web_enabled' // Map enabled to web_enabled
        )->get();

        // Convert the database result to a proper array to avoid type issues
        $productsArray = [];
        foreach ($products as $product) {
            $productsArray[] = [
                'product_id' => $product->product_id,
                'item_no' => $product->item_no,
                'categories_id' => $product->categories_id,
                'parent' => $product->parent,
                'title' => $product->product_name, // Add title field for compatibility
                'product_name' => $product->product_name,
                'price' => $product->price,
                'size' => $product->size,
                'color' => $product->color,
                'style' => $product->style ?? 'Standard',
                'speciality' => $product->speciality ?? null, 
                'general_image' => $product->img_large ? '/' . $product->img_large : '/default-product.png',
                'spacing' => $product->spacing ?? null,
                'material' => $product->material ?? 'Wood',
                'web_enabled' => $product->web_enabled,
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
                'groupBy' => 'style',
                'styleGroups' => $formattedStyleGroups,
                'spacing' => null,
                'styleTitle' => 'Wood Fence Specifications',
                'productIdMap' => []
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
                'spacing' => null,
                'styleTitle' => 'Wood Fence Specifications',
                'groupBy' => $groupBy,
                'products' => $formattedProducts,
                'productIdMap' => []
            ]);
        } else {
            return view('categories.woodfence-specs', [
                'groupBy' => null,
                'products' => $formattedProducts,
                'spacing' => null,
                'styleTitle' => 'Wood Fence Specifications',
                'productIdMap' => []
            ]);
        }
    }
}
