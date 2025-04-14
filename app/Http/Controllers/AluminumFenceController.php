<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AluminumFenceController extends Controller
{
    public function main()
    {
        // Get aluminum fence categories from the database
        $aluminumCategories = DB::connection('mysql_second')
            ->table('categories')
            ->where('majorcategories_id', 43) // Aluminum fence major category ID
            ->where('web_enabled', 1)
            ->select('id', 'cat_name as family_category_name', 'cat_desc_long', 'seo_name', 'img')
            ->get();
            
        // Format the categories with images
        $formattedCategories = [];
        foreach ($aluminumCategories as $category) {
            $formattedCategories[] = [
                'family_category_id' => $category->id,
                'family_category_name' => $category->family_category_name,
                'cat_desc_long' => $category->cat_desc_long,
                'seo_name' => $category->seo_name,
                'image' => $category->img ? url('storage/categories/' . $category->img) : url('storage/categories/default.png'),
            ];
        }
        
        return view('categories.aluminumfence-main', [
            'aluminum_categories' => collect($formattedCategories)
        ]);
    }
    
    public function index(Request $request, $style = null)
    {
        // Get selected fence type and model from the request
        $selectedType = $request->input('type', $style);
        
        // Base query for aluminum fence products
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            })
            ->where('enabled', 1);
            
        // Get all fence types and models using the query
        $typesAndModels = DB::connection('mysql_second')
            ->select("
                SELECT 
                    CASE 
                        WHEN product_name LIKE '%Residential%' THEN 'Residential'
                        WHEN product_name LIKE '%Commercial%' THEN 'Commercial'
                        WHEN product_name LIKE '%Industrial%' THEN 'Industrial'
                        ELSE 'Unknown'
                    END AS fence_type,
                    TRIM(SUBSTRING_INDEX(product_name, '-', -1)) AS model_name,
                    COUNT(*) AS total
                FROM productsqry
                WHERE (product_name LIKE 'OnGuard Aluminum Fence%'
                   OR product_name LIKE 'OnGuard Ornamental Aluminum Fence%'
                   OR product_name LIKE 'On Guard Ornamental Aluminum Fence%')
                   AND enabled = 1
                GROUP BY fence_type, model_name
                ORDER BY fence_type, model_name
            ");
        
        // Organize types and models into a structured array
        $fenceTypes = [
            'Residential' => [
                'title' => 'Residential',
                'models' => [],
                'description' => $this->getTypeDescription('Residential'),
                'specs' => $this->getTypeSpecs('Residential')
            ],
            'Commercial' => [
                'title' => 'Commercial',
                'models' => [],
                'description' => $this->getTypeDescription('Commercial'),
                'specs' => $this->getTypeSpecs('Commercial')
            ],
            'Industrial' => [
                'title' => 'Industrial',
                'models' => [],
                'description' => $this->getTypeDescription('Industrial'),
                'specs' => $this->getTypeSpecs('Industrial')
            ]
        ];
        
        foreach ($typesAndModels as $item) {
            if (isset($fenceTypes[$item->fence_type])) {
                $fenceTypes[$item->fence_type]['models'][$item->model_name] = [
                    'name' => $item->model_name,
                    'total' => $item->total
                ];
            }
        }
        
        // Manually add Puppy Picket models to each fence type
        foreach ($fenceTypes as $type => &$fenceType) {
            // Add Puppy Picket models
            $fenceType['models']['Puppy Picket 1*'] = [
                'name' => 'Puppy Picket 1*',
                'total' => 1,
                'image' => url('storage/products/puppy1.jpg')
            ];
            
            $fenceType['models']['Puppy Picket 2*'] = [
                'name' => 'Puppy Picket 2*',
                'total' => 1,
                'image' => url('storage/products/puppy2.jpg')
            ];
            
            $fenceType['models']['Puppy Picket 3*'] = [
                'name' => 'Puppy Picket 3*',
                'total' => 1,
                'image' => url('storage/products/puppy3.jpg')
            ];
        }
        
        // Get products based on selected type and model
        $products = [];
        if ($selectedType) {
            // Parse the selected type to get fence_type and model
            $parts = explode('-', $selectedType);
            $selectedFenceType = $parts[0] ?? null;
            $selectedModel = $parts[1] ?? null;
            
            if ($selectedFenceType && $selectedModel) {
                // Query products for the selected type and model
                $products = $baseQuery
                    ->where('product_name', 'LIKE', '%' . $selectedFenceType . '%')
                    ->where('product_name', 'LIKE', '%' . $selectedModel . '%')
                    ->get();
            }
        }
        
        // Get representative images for each model
        $representativeImages = [];
        foreach ($fenceTypes as $typeName => $typeData) {
            $representativeImages[$typeName] = [];
            foreach ($typeData['models'] as $modelName => $modelData) {
                // Find a product from this model to get its image
                $representativeProduct = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->where('product_name', 'LIKE', '%' . $typeName . '%')
                    ->where('product_name', 'LIKE', '%' . $modelName . '%')
                    ->select('img_large')
                    ->first();
                
                if ($representativeProduct && $representativeProduct->img_large) {
                    $representativeImages[$typeName][$modelName] = url('storage/products/' . $representativeProduct->img_large);
                }
                else {
                    // Fallback to default image
                    $representativeImages[$typeName][$modelName] = url('storage/products/default.png');
                }
            }
        }
        
        // Return the view with data
        return view('categories.aluminumfence', [
            'fenceTypes' => $fenceTypes,
            'representativeImages' => $representativeImages,
            'products' => $products,
            'selectedType' => $selectedType,
            'selectedFenceType' => $selectedFenceType ?? null,
            'selectedModel' => $selectedModel ?? null
        ]);
    }
    
    /**
     * Display the product details for a specific OnGuard aluminum fence product
     * 
     * @param Request $request
     * @param string $type
     * @param string $model
     * @return \Illuminate\View\View
     */
    public function productDetails(Request $request, $type, $model)
    {
        // Get the product details from the database
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            })
            ->where('enabled', 1);
        
        // Get products based on selected type and model
        $products = $baseQuery
            ->where('product_name', 'LIKE', '%' . $type . '%')
            ->where('product_name', 'LIKE', '%' . $model . '%')
            ->get();
        
        // Select a representative product for display
        $selectedProduct = $products->first();
        
        // Get available colors
        $colors = $baseQuery
            ->where('product_name', 'LIKE', '%' . $type . '%')
            ->where('product_name', 'LIKE', '%' . $model . '%')
            ->select('color')
            ->distinct()
            ->pluck('color')
            ->filter()
            ->toArray();
        
        // Get available sizes
        $sizes = $baseQuery
            ->where('product_name', 'LIKE', '%' . $type . '%')
            ->where('product_name', 'LIKE', '%' . $model . '%')
            ->select('size')
            ->distinct()
            ->pluck('size')
            ->filter()
            ->toArray();
        
        // Get representative image for the model
        $representativeImage = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('product_name', 'LIKE', '%' . $type . '%')
            ->where('product_name', 'LIKE', '%' . $model . '%')
            ->whereNotNull('img_large')
            ->value('img_large');
        
        // If no image found, use default
        $modelImage = $representativeImage 
            ? url('storage/products/' . $representativeImage) 
            : url('storage/products/default.png');
        
        // Get model description
        $modelDescription = $this->getModelDescription($model);
        
        // Process associated products from product_assoc field
        $associatedSections = [];
        if ($selectedProduct && !empty($selectedProduct->product_assoc)) {
            $assocData = $selectedProduct->product_assoc;
            $sections = [];
            $currentTitle = null;
            $currentItems = [];
            
            // Split the string using comma as delimiter
            $parts = explode(',', $assocData);
            
            foreach ($parts as $part) {
                // Check if it's a section title (enclosed in --)
                if (preg_match('/--(.+?)--/', $part, $matches)) {
                    // If we already have a title and items, save them
                    if ($currentTitle !== null && count($currentItems) > 0) {
                        $sections[] = [
                            'title' => $currentTitle,
                            'items' => $currentItems
                        ];
                        $currentItems = []; // Reset items array
                    }
                    $currentTitle = $matches[1]; // Save the new title
                } else {
                    // It's an item number, add to current section
                    $currentItems[] = trim($part);
                }
            }
            
            // Add the last section if it exists
            if ($currentTitle !== null && count($currentItems) > 0) {
                $sections[] = [
                    'title' => $currentTitle,
                    'items' => $currentItems
                ];
            }
            
            // Now fetch all these products from database
            foreach ($sections as $section) {
                $sectionProducts = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->whereIn('item_no', $section['items'])
                    ->where('enabled', 1)
                    ->get();
                
                if ($sectionProducts->count() > 0) {
                    $associatedSections[] = [
                        'title' => $section['title'],
                        'products' => $sectionProducts
                    ];
                }
            }
        }
        
        // Get all available models for the sidebar
        $allModels = DB::connection('mysql_second')
            ->select("
                SELECT 
                    CASE 
                        WHEN product_name LIKE '%Residential%' THEN 'Residential'
                        WHEN product_name LIKE '%Commercial%' THEN 'Commercial'
                        WHEN product_name LIKE '%Industrial%' THEN 'Industrial'
                        ELSE 'Unknown'
                    END AS fence_type,
                    TRIM(SUBSTRING_INDEX(product_name, '-', -1)) AS model_name,
                    COUNT(*) AS total
                FROM productsqry
                WHERE (product_name LIKE 'OnGuard Aluminum Fence%'
                   OR product_name LIKE 'OnGuard Ornamental Aluminum Fence%'
                   OR product_name LIKE 'On Guard Ornamental Aluminum Fence%')
                   AND enabled = 1
                GROUP BY fence_type, model_name
                ORDER BY fence_type, model_name
            ");
        
        // Organize models by type
        $fenceTypes = [
            'Residential' => [
                'title' => 'Residential',
                'models' => [],
            ],
            'Commercial' => [
                'title' => 'Commercial',
                'models' => [],
            ],
            'Industrial' => [
                'title' => 'Industrial',
                'models' => [],
            ]
        ];
        
        foreach ($allModels as $item) {
            if (isset($fenceTypes[$item->fence_type])) {
                $fenceTypes[$item->fence_type]['models'][$item->model_name] = [
                    'name' => $item->model_name,
                    'total' => $item->total
                ];
            }
        }
        
        return view('categories.aluminumfence-product', [
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'type' => $type,
            'model' => $model,
            'colors' => $colors,
            'sizes' => $sizes,
            'modelImage' => $modelImage,
            'modelDescription' => $modelDescription,
            'associatedSections' => $associatedSections,
            'fenceTypes' => $fenceTypes
        ]);
    }
    
    /**
     * Filter products by size for AJAX requests
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterProducts(Request $request)
    {
        $type = $request->input('type');
        $model = $request->input('model');
        $size = $request->input('size');
        
        // Get the product details from the database
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            })
            ->where('enabled', 1);
        
        // Get product based on selected type, model and size
        $product = $baseQuery
            ->where('product_name', 'LIKE', '%' . $type . '%')
            ->where('product_name', 'LIKE', '%' . $model . '%')
            ->where('size', $size)
            ->first();
        
        // Process associated products from product_assoc field
        $associatedSections = [];
        if ($product && !empty($product->product_assoc)) {
            $assocData = $product->product_assoc;
            $sections = [];
            $currentTitle = null;
            $currentItems = [];
            
            // Split the string using comma as delimiter
            $parts = explode(',', $assocData);
            
            foreach ($parts as $part) {
                // Check if it's a section title (enclosed in --)
                if (preg_match('/--(.+?)--/', $part, $matches)) {
                    // If we already have a title and items, save them
                    if ($currentTitle !== null && count($currentItems) > 0) {
                        $sections[] = [
                            'title' => $currentTitle,
                            'items' => $currentItems
                        ];
                        $currentItems = []; // Reset items array
                    }
                    $currentTitle = $matches[1]; // Save the new title
                } else {
                    // It's an item number, add to current section
                    $currentItems[] = trim($part);
                }
            }
            
            // Add the last section if it exists
            if ($currentTitle !== null && count($currentItems) > 0) {
                $sections[] = [
                    'title' => $currentTitle,
                    'items' => $currentItems
                ];
            }
            
            // Now fetch all these products from database
            foreach ($sections as $section) {
                $sectionProducts = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->whereIn('item_no', $section['items'])
                    ->where('enabled', 1)
                    ->get();
                
                if ($sectionProducts->count() > 0) {
                    $associatedSections[] = [
                        'title' => $section['title'],
                        'products' => $sectionProducts
                    ];
                }
            }
        }
        
        return response()->json([
            'product' => $product,
            'associatedSections' => $associatedSections
        ]);
    }
    
    /**
     * Get description for a specific model
     * 
     * @param string $model
     * @return string
     */
    private function getModelDescription($model)
    {
        $descriptions = [
            'Heron' => 'The Heron style features a classic design with straight pickets and a clean, timeless appearance. Perfect for residential properties seeking a traditional look.',
            'Falcon' => 'The Falcon style offers a contemporary design with slightly arched pickets, providing an elegant and modern aesthetic for your property.',
            'Eagle' => 'The Eagle style showcases a distinctive arched top with decorative finials, adding a touch of sophistication and luxury to any property.',
            'Starling' => 'The Starling style features a unique design with alternating picket heights, creating a dynamic and visually interesting fence line.',
            'Puppy Picket 1*' => 'The Puppy Picket 1* style features additional lower pickets to prevent small pets from escaping, while maintaining an elegant appearance.',
            'Puppy Picket 2*' => 'The Puppy Picket 2* style offers enhanced security for small pets with closely spaced lower pickets and a stylish overall design.',
            'Puppy Picket 3*' => 'The Puppy Picket 3* style provides maximum security for small pets with the closest picket spacing at the bottom, while preserving aesthetic appeal.'
        ];
        
        return $descriptions[$model] ?? 'A high-quality aluminum fence model from OnGuard, designed for durability and aesthetic appeal.';
    }
    
    /**
     * Get description for a fence type
     */
    private function getTypeDescription($type)
    {
        $descriptions = [
            'Residential' => 'OnGuard\'s family of Residential Aluminum Picket Fence products are offered in a wide array of beautiful designs and classic finish options',
            'Commercial' => 'OnGuard Commercial Aluminum Picket Fence is built with high-quality aluminum fence components, where long-lasting durability and beauty are required.',
            'Industrial' => 'OnGuard Industrial Aluminum Fence provides maximum security and strength for industrial applications, built with the heaviest gauge aluminum components.'
        ];
        
        return $descriptions[$type] ?? 'High-quality aluminum fence products from OnGuard';
    }
    
    /**
     * Get specifications for a fence type
     */
    private function getTypeSpecs($type)
    {
        $specs = [
            'Residential' => 'Pickets - 5/8" x .050" thick, Rails - Topwalls - 1 1/8" x .062" thick, Rails - Sidewalls - 1" x .080" thick',
            'Commercial' => 'Pickets - 3/4" x .050" thick, Rails - Topwalls - 1 3/8" x .065" thick, Rails - Sidewalls - 1 1/4" x .088" thick',
            'Industrial' => 'Pickets - 1" x .062" thick, Rails - Topwalls - 1 5/8" x .070" thick, Rails - Sidewalls - 1 1/2" x .100" thick'
        ];
        
        return $specs[$type] ?? '';
    }
    
    /**
     * Display aluminum fence products available for pickup
     */
    public function pickup()
    {
        // Get aluminum fence products available for pickup
        $pickupProducts = [
            'Heron' => [
                'title' => 'Heron 48" Height',
                'image' => url('storage/products/1744373828.gif'),
                'items' => [
                    [
                        'name' => 'Section',
                        'size' => '48in H x 6ft W',
                        'price' => 75.00
                    ],
                    [
                        'name' => 'Post',
                        'size' => '2in x 2 x 72in',
                        'price' => 26.00
                    ],
                    [
                        'name' => 'Gate Post',
                        'size' => '2in x 2 x 72in',
                        'price' => 50.00
                    ],
                    [
                        'name' => 'Gate',
                        'size' => '48in h x 36in W',
                        'price' => 300.00
                    ]
                ]
            ],
            'Siskin' => [
                'title' => 'Siskin 54" Height',
                'image' => url('storage/products/1744373828.gif'),
                'items' => [
                    [
                        'name' => 'Section',
                        'size' => '54in H x 6ft W',
                        'price' => 85.00
                    ],
                    [
                        'name' => 'Post',
                        'size' => '2in x 2 x 84in',
                        'price' => 27.00
                    ],
                    [
                        'name' => 'Gate Post',
                        'size' => '2in x 2 x 84in',
                        'price' => 50.00
                    ],
                    [
                        'name' => 'Gate',
                        'size' => '54in h x 36in W',
                        'price' => 325.00
                    ]
                ]
            ],
            'Starling48' => [
                'title' => 'Starling 48" Height',
                'image' => url('storage/products/1744373828.gif'),
                'items' => [
                    [
                        'name' => 'Section',
                        'size' => '48in H x 6ft W',
                        'price' => 80.00
                    ],
                    [
                        'name' => 'Post',
                        'size' => '2in x 2 x 72in',
                        'price' => 27.00
                    ],
                    [
                        'name' => 'Gate Post',
                        'size' => '2in x 2 x 72in',
                        'price' => 45.00
                    ],
                    [
                        'name' => 'Gate',
                        'size' => '48in h x 36in W',
                        'price' => 300.00
                    ]
                ]
            ],
            'Starling54' => [
                'title' => 'Starling 54" Height',
                'image' => url('storage/products/1744373828.gif'),
                'items' => [
                    [
                        'name' => 'Section',
                        'size' => '54in H x 6ft W',
                        'price' => 85.00
                    ],
                    [
                        'name' => 'Post',
                        'size' => '2in x 2 x 84in',
                        'price' => 27.00
                    ],
                    [
                        'name' => 'Gate Post',
                        'size' => '2in x 2 x 84in',
                        'price' => 50.00
                    ],
                    [
                        'name' => 'Gate',
                        'size' => '54in h x 36in W',
                        'price' => 325.00
                    ]
                ]
            ],
            'Longspur48' => [
                'title' => 'Longspur 48" Height',
                'image' => url('storage/products/1744373828.gif'),
                'items' => [
                    [
                        'name' => 'Section',
                        'size' => '48in H x 6ft W',
                        'price' => 80.00
                    ],
                    [
                        'name' => 'Post',
                        'size' => '2in x 2 x 72in',
                        'price' => 27.00
                    ],
                    [
                        'name' => 'Gate Post',
                        'size' => '2in x 2 x 72in',
                        'price' => 50.00
                    ],
                    [
                        'name' => 'Gate',
                        'size' => '48in h x 36in W',
                        'price' => 300.00
                    ]
                ]
            ],
            'Longspur72' => [
                'title' => 'Longspur 72" Height',
                'image' => url('storage/products/1744373828.gif'),
                'items' => [
                    [
                        'name' => 'Section',
                        'size' => '72in H x 6ft W',
                        'price' => 110.00
                    ],
                    [
                        'name' => 'Post',
                        'size' => '2 1/2in x 2 1/2 x 96in',
                        'price' => 50.00
                    ],
                    [
                        'name' => 'Gate Post',
                        'size' => '2 1/2in x 2 1/2 x 96in',
                        'price' => 50.00
                    ],
                    [
                        'name' => 'Gate',
                        'size' => '72in h x 36in W',
                        'price' => 350.00
                    ]
                ]
            ]
        ];
        
        return view('categories.aluminumfence-pickup', [
            'pickupProducts' => $pickupProducts
        ]);
    }
}
