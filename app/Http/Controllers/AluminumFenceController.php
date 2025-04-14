<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // Initialize selected fence type
        $selectedFenceType = null;
        
        // Get selected fence type and model from the request
        $selectedType = $request->input('type', $style);
        $selectedModel = $request->input('model');
        
        // Base query for aluminum fence products
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            })
            ->where('enabled', 1);
            
        // Get all fence types and models using the material and style columns
        $typesAndModels = DB::connection('mysql_second')
            ->select("
                SELECT 
                    material AS fence_type,
                    style AS model_name,
                    COUNT(*) AS total
                FROM productsqry
                WHERE (product_name LIKE 'OnGuard Aluminum Fence%'
                   OR product_name LIKE 'OnGuard Ornamental Aluminum Fence%'
                   OR product_name LIKE 'On Guard Ornamental Aluminum Fence%')
                   AND enabled = 1
                   AND material IN ('Residential', 'Commercial', 'Industrial')
                GROUP BY material, style
                ORDER BY material, style
            ");
        
        // Get OnGuard accessories
        $accessories = $this->getOnGuardAccessories();
        
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
        
        // Get Puppy Picket models from database
        $puppyPickets = DB::connection('mysql_second')
            ->table('productsqry')
            ->select('speciality', 'material', 'style', 'item_no', 'img_large')
            ->where('speciality', 'LIKE', 'puppy picket%')
            ->where('item_no', 'LIKE', '%PP')
            ->where('enabled', 1)
            ->orderBy('speciality')
            ->get();
        
        // Group puppy pickets by speciality
        $puppyPicketGroups = [];
        foreach ($puppyPickets as $picket) {
            $speciality = ucwords($picket->speciality); // Capitalize first letter of each word
            if (!isset($puppyPicketGroups[$speciality])) {
                $puppyPicketGroups[$speciality] = [
                    'name' => $speciality,
                    'total' => 0,
                    'material' => $picket->material,
                    'style' => $picket->style,
                    'item_no' => $picket->item_no,
                    'image' => $picket->img_large ? url('storage/products/' . $picket->img_large) : url('storage/products/default.png')
                ];
            }
            $puppyPicketGroups[$speciality]['total']++;
        }
        
        // Add puppy picket models to each fence type
        foreach ($fenceTypes as $type => &$fenceType) {
            foreach ($puppyPicketGroups as $speciality => $picketData) {
                $modelName = $speciality;
                $fenceType['models'][$modelName] = [
                    'name' => $modelName,
                    'total' => $picketData['total'],
                    'image' => $picketData['image'],
                    'item_no' => $picketData['item_no']
                ];
            }
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
                    ->where('material', $selectedFenceType)
                    ->where('style', $selectedModel)
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
                    ->where('material', $typeName)
                    ->where('style', $modelName)
                    ->select('img_large', 'img_small')
                    ->first();
                
                if ($representativeProduct && $representativeProduct->img_large) {
                    $representativeImages[$typeName][$modelName] = [
                        'main' => url('storage/products/' . $representativeProduct->img_large),
                        'hover' => $representativeProduct->img_small 
                            ? url('storage/products/' . $representativeProduct->img_small) 
                            : url('storage/products/aluminiumfence-bunting-res.JPG')
                    ];
                }
                else {
                    // Fallback to default image
                    $representativeImages[$typeName][$modelName] = [
                        'main' => url('storage/products/default.png'),
                        'hover' => url('storage/products/aluminiumfence-bunting-res.JPG')
                    ];
                }
            }
        }
        
        // Return the view with data
        return view('categories.aluminumfence', [
            'fenceTypes' => $fenceTypes,
            'selectedFenceType' => $selectedFenceType ?? null,
            'selectedModel' => $selectedModel,
            'products' => $products,
            'representativeImages' => $representativeImages,
            'accessories' => $accessories
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
        // Check if this is a puppy picket model
        $isPuppyPicket = stripos($model, 'puppy picket') !== false;
        
        // Base query for aluminum fence products
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            })
            ->where('enabled', 1);
            
        if ($isPuppyPicket) {
            // For puppy picket, use speciality field
            $speciality = strtolower($model); // Convert to lowercase for comparison
            $baseQuery->where('speciality', 'LIKE', $speciality)
                     ->where('item_no', 'LIKE', '%PP');
            
            // Get products based on selected type and puppy picket speciality
            $products = $baseQuery->get();
        } else {
            // For regular models, use the standard query
            $baseQuery->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            });
            
            // Get products based on selected type and model
            $products = $baseQuery
                ->where('material', $type)
                ->where('style', $model)
                ->get();
        }
        
        // Select a representative product for display
        $selectedProduct = $products->first();
        
        // Get available colors
        $colors = $products
            ->pluck('color')
            ->filter()
            ->unique()
            ->values()
            ->toArray();
        
        // Get available sizes
        $sizes = $products
            ->pluck('size')
            ->filter()
            ->unique()
            ->values()
            ->toArray();
        
        // Get representative image for the model
        $representativeImage = null;
        
        if ($isPuppyPicket) {
            // For puppy picket, get the image from the first product
            $representativeImage = $selectedProduct->img_large ?? null;
        } else {
            // For regular models, use the standard query
            $representativeImage = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('material', $type)
                ->where('style', $model)
                ->whereNotNull('img_large')
                ->value('img_large');
        }
        
        // If no image found, use default
        $modelImage = $representativeImage 
            ? url('storage/products/' . $representativeImage) 
            : url('storage/products/default.png');
        
        // Get model description
        $modelDescription = $this->getModelDescription($model);
        
        // Get all fence types and models for the navigation
        $allModels = DB::connection('mysql_second')
            ->select("
                SELECT 
                    material AS fence_type,
                    style AS model_name,
                    COUNT(*) AS total
                FROM productsqry
                WHERE (product_name LIKE 'OnGuard Aluminum Fence%'
                   OR product_name LIKE 'OnGuard Ornamental Aluminum Fence%'
                   OR product_name LIKE 'On Guard Ornamental Aluminum Fence%')
                   AND enabled = 1
                   AND material IN ('Residential', 'Commercial', 'Industrial')
                GROUP BY material, style
                ORDER BY material, style
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
     * Filter products by size and color for AJAX requests
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterProducts(Request $request)
    {
        // Log the request for debugging
        Log::info('Filter request:', $request->all());
        
        $type = $request->input('type');
        $model = $request->input('model');
        $size = $request->input('size');
        $color = $request->input('color');
        
        // Check if this is a puppy picket model
        $isPuppyPicket = stripos($model, 'puppy picket') !== false;
        
        // Get the product details from the database
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('enabled', 1);
            
        if ($isPuppyPicket) {
            // For puppy picket, use speciality field
            $speciality = strtolower($model); // Convert to lowercase for comparison
            $baseQuery->where('speciality', 'LIKE', $speciality)
                     ->where('item_no', 'LIKE', '%PP');
        } else {
            // For regular models, use the standard query
            $baseQuery->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            });
            
            // Add type and model filters
            $baseQuery->where('material', $type)
                     ->where('style', $model);
        }
        
        // Create a copy of the base query for debugging
        $countQuery = clone $baseQuery;
        $totalProducts = $countQuery->count();
        Log::info("Total products before size/color filters: {$totalProducts}");
        
        // Add size filter if provided
        if ($size) {
            $baseQuery->where('size', $size);
        }
        
        // Add color filter if provided
        if ($color) {
            $baseQuery->where('color', $color);
        }
        
        // Get the filtered product
        $product = $baseQuery->first();
        
        // Log the product found (if any)
        Log::info('Product found:', ['product' => $product ? $product->item_no : 'None']);
        
        // If no product found with both filters, try with just size
        if (!$product && $size && $color) {
            Log::info('No product found with both size and color, trying with just size');
            
            // Reset the query
            $baseQuery = DB::connection('mysql_second')
                ->table('productsqry')
                ->where('enabled', 1);
                
            if ($isPuppyPicket) {
                $baseQuery->where('speciality', 'LIKE', $speciality)
                         ->where('item_no', 'LIKE', '%PP');
            } else {
                $baseQuery->where(function($query) {
                    $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                          ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                          ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
                });
                
                $baseQuery->where('material', $type)
                         ->where('style', $model);
            }
            
            // Only filter by size
            if ($size) {
                $baseQuery->where('size', $size);
            }
            
            $product = $baseQuery->first();
            Log::info('Product found with just size:', ['product' => $product ? $product->item_no : 'None']);
        }
        
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
                    ->get()
                    ->map(function($product) {
                        // Add image URL using the proper format
                        $product->img_url = $product->img_large 
                            ? url('storage/products/' . $product->img_large) 
                            : url('storage/products/default.png');
                        return $product;
                    });
                
                if ($sectionProducts->count() > 0) {
                    $associatedSections[] = [
                        'title' => $section['title'],
                        'products' => $sectionProducts
                    ];
                }
            }
        }
        
        // Add image URL to the main product using the proper format
        if ($product) {
            $product->img_url = $product->img_large 
                ? url('storage/products/' . $product->img_large) 
                : url('storage/products/default.png');
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
    
    /**
     * Get OnGuard accessories
     * 
     * @return \Illuminate\Support\Collection
     */
    private function getOnGuardAccessories()
    {
        return DB::connection('mysql_second')
            ->table('productsqry')
            ->where('parent', 'LIKE', 'ONGAMM%')
            ->where('enabled', 1)
            ->select('id', 'item_no', 'product_name', 'price', 'size', 'color', 'img_large')
            ->get()
            ->map(function($product) {
                $product->img_url = $product->img_large 
                    ? url('storage/products/' . $product->img_large) 
                    : url('storage/products/default.png');
                return $product;
            });
    }
    
    /**
     * Display OnGuard accessories
     * 
     * @return \Illuminate\View\View
     */
    public function accessories()
    {
        // Get OnGuard accessories
        $accessories = $this->getOnGuardAccessories();
        
        // Group accessories by similar product names
        $groupedAccessories = [];
        $processedIds = [];
        
        foreach ($accessories as $accessory) {
            // Skip if already processed
            if (in_array($accessory->id, $processedIds)) {
                continue;
            }
            
            $similarProducts = [];
            $similarProducts[] = $accessory;
            $processedIds[] = $accessory->id;
            
            // Find similar products
            foreach ($accessories as $compareAccessory) {
                if ($accessory->id !== $compareAccessory->id && !in_array($compareAccessory->id, $processedIds)) {
                    // Calculate similarity between product names
                    $similarity = $this->calculateSimilarity($accessory->product_name, $compareAccessory->product_name);
                    
                    // If similarity is above threshold, add to group
                    if ($similarity >= 0.7) { // 70% similarity threshold
                        $similarProducts[] = $compareAccessory;
                        $processedIds[] = $compareAccessory->id;
                    }
                }
            }
            
            // Create a group name from the common part of the product names
            $groupName = $this->extractCommonName($similarProducts);
            
            // Add to grouped accessories
            $groupedAccessories[$groupName] = [
                'title' => $groupName,
                'products' => $similarProducts,
                'image' => $similarProducts[0]->img_url,
                'total' => count($similarProducts)
            ];
        }
        
        return view('categories.aluminumfence-accessories', [
            'accessoryGroups' => $groupedAccessories,
            'pageTitle' => 'OnGuard Aluminum Fence Accessories'
        ]);
    }
    
    /**
     * Calculate similarity between two strings
     * 
     * @param string $str1
     * @param string $str2
     * @return float
     */
    private function calculateSimilarity($str1, $str2)
    {
        // Convert to lowercase for case-insensitive comparison
        $str1 = strtolower($str1);
        $str2 = strtolower($str2);
        
        // Calculate Levenshtein distance
        $levenshtein = levenshtein($str1, $str2);
        
        // Calculate similarity as a percentage
        $maxLength = max(strlen($str1), strlen($str2));
        if ($maxLength === 0) {
            return 1.0; // Both strings are empty
        }
        
        return 1.0 - ($levenshtein / $maxLength);
    }
    
    /**
     * Extract common name from a group of products
     * 
     * @param array $products
     * @return string
     */
    private function extractCommonName($products)
    {
        if (count($products) === 1) {
            return $products[0]->product_name;
        }
        
        // Extract common words from product names
        $names = array_map(function($product) {
            return $product->product_name;
        }, $products);
        
        // Find the longest common substring
        $commonName = $this->findLongestCommonSubstring($names);
        
        // If common name is too short, use the first product's name
        if (strlen($commonName) < 10) {
            return $products[0]->product_name;
        }
        
        return trim($commonName);
    }
    
    /**
     * Find the longest common substring among an array of strings
     * 
     * @param array $strings
     * @return string
     */
    private function findLongestCommonSubstring($strings)
    {
        if (empty($strings)) {
            return '';
        }
        
        $shortest = min(array_map('strlen', $strings));
        $result = '';
        
        // Use the first string as reference
        $reference = $strings[0];
        
        for ($len = $shortest; $len > 0; $len--) {
            for ($pos = 0; $pos <= strlen($reference) - $len; $pos++) {
                $candidate = substr($reference, $pos, $len);
                $allContain = true;
                
                // Check if all strings contain this substring
                foreach ($strings as $str) {
                    if (stripos($str, $candidate) === false) {
                        $allContain = false;
                        break;
                    }
                }
                
                if ($allContain && strlen($candidate) > strlen($result)) {
                    $result = $candidate;
                }
            }
            
            if (!empty($result)) {
                break;
            }
        }
        
        return $result;
    }
}
