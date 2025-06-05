<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\FamilyCategory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryDetail;
use Illuminate\Http\Request;
use App\Models\ShoppingCart;

class ProductController extends Controller
{
    public function showWeldedWire()
    {
        // Fetch the Welded Wire category from the new database
        $weldedWireCategory = DB::connection('academyfence')
            ->table('categories')
            ->where('majorcategories_id', 44)
            ->first();

        if (!$weldedWireCategory) {
            abort(404, 'Welded Wire category not found.');
        }

        // Fetch products related to the Welded Wire category
        try {
            // Try to use productsqry view first
            $products_ww = DB::connection('academyfence')
                ->table('productsqry')
                ->where('categories_id', $weldedWireCategory->id)
                ->select('*')
                ->get();
        } catch (\Exception $e) {
            // Fall back to products table if view doesn't exist
            $products_ww = DB::connection('academyfence')
                ->table('products')
                ->where('categories_id', $weldedWireCategory->id)
                ->select('*')
                ->get();
        }

        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();
        return view('categories.weldedwire', compact('weldedWireCategory', 'products_ww', 'cart', 'majCategories', 'subCategories'));
    }

    public function create()
    {
        // Get categories from the new database
        $familyCategories = DB::connection('academyfence')
            ->table('categories')
            ->where('web_enabled', 1)
            ->orderBy('cat_name')
            ->get();
            
        \Log::info('Available categories:', $familyCategories->toArray());
        return view('ams.product.add-product', compact('familyCategories'));
    }

    public function index(Request $request)
    {
        try {
            // Load categories with nested structure
            $categories = DB::connection('academyfence')
                ->table('categories as c1')
                ->leftJoin('categories as c2', 'c1.id', '=', 'c2.majorcategories_id')
                ->whereNull('c1.majorcategories_id') // Only parent categories
                ->select('c1.id as family_category_id', 'c1.cat_name as family_category_name')
                ->distinct()
                ->get();

            // Add product counts and children to each category
            foreach ($categories as $category) {
                // Count products for this category
                $category->products_count = DB::connection('academyfence')
                    ->table('products')
                    ->where('categories_id', $category->family_category_id)
                    ->count();
                
                // Get child categories
                $category->children = DB::connection('academyfence')
                    ->table('categories')
                    ->where('majorcategories_id', $category->family_category_id)
                    ->select('id as family_category_id', 'cat_name as family_category_name')
                    ->get();
                
                // Add product counts to each child
                foreach ($category->children as $child) {
                    $child->products_count = DB::connection('academyfence')
                        ->table('products')
                        ->where('categories_id', $child->family_category_id)
                        ->count();
                }
            }

            // Handle AJAX requests for product data
            if ($request->ajax()) {
                $query = DB::connection('academyfence')->table('products');
                
                // Apply category filter
                if ($request->filled('category')) {
                    $categoryId = $request->category;
                    
                    // Get the category and check if it's a parent or child
                    $category = DB::connection('academyfence')
                        ->table('categories')
                        ->where('id', $categoryId)
                        ->first();
                    
                    if ($category) {
                        // Check if it has children
                        $childrenIds = DB::connection('academyfence')
                            ->table('categories')
                            ->where('majorcategories_id', $categoryId)
                            ->pluck('id')
                            ->toArray();
                        
                        if (count($childrenIds) > 0) {
                            // If it's a parent category, get products from it and all its children
                            $query->whereIn('categories_id', array_merge([$categoryId], $childrenIds));
                        } else {
                            // If it's a child category or has no children, just get its products
                            $query->where('categories_id', $categoryId);
                        }
                    }
                }

                // Apply other filters
                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('product_name', 'like', "%{$search}%")
                          ->orWhere('item_no', 'like', "%{$search}%");
                    });
                }

                if ($request->filled('stock_status')) {
                    switch ($request->stock_status) {
                        case 'in_stock':
                            $query->where(function($q) {
                                $q->where('inv_stocked', '>', 0)
                                  ->orWhere('inv_ordered', '>', 0);
                            });
                            break;
                        case 'low_stock':
                            $query->where(function($q) {
                                $q->where('inv_stocked', '<=', 5)
                                  ->where('inv_stocked', '>', 0);
                            });
                            break;
                    }
                }

                $products = $query->get()->map(function ($product) {
                    // Get category name
                    $category = DB::connection('academyfence')
                        ->table('categories')
                        ->where('id', $product->categories_id)
                        ->first();
                    
                    return [
                        'id' => $product->id,
                        'item_no' => $product->item_no,
                        'product_name' => $product->product_name,
                        'family_category' => [
                            'id' => $product->categories_id,
                            'name' => $category ? $category->cat_name : 'N/A'
                        ],
                        'price' => number_format($product->price ?? 0, 2),
                        'stock' => [
                            'hq' => (int)($product->inv_stocked ?? 0),
                            'warehouse' => (int)($product->inv_ordered ?? 0)
                        ],
                        'stock_status' => ($product->inv_stocked > 0 || $product->inv_ordered > 0) 
                            ? 'In Stock' 
                            : 'Out of Stock'
                    ];
                });

                return response()->json([
                    'success' => true,
                    'products' => $products
                ]);
            }

            // For initial page load, get all products
            $products = DB::connection('academyfence')
                ->table('products')
                ->paginate($request->get('per_page', 10));
            
            // Return view for non-AJAX requests
            return view('ams.product.view-product', compact('categories', 'products'));

        } catch (\Exception $e) {
            \Log::error('Error in ProductController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load products. Please try again.'
                ], 500);
            }

            return back()->with('error', 'Failed to load products. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            DB::connection('academyfence')->beginTransaction();
    
            // Create the main product
            $productData = $request->input('product');
            
            // Insert into products table
            $productId = DB::connection('academyfence')
                ->table('products')
                ->insertGetId([
                    'product_name' => $productData['product_name'],
                    'item_no' => $productData['item_no'],
                    'categories_id' => $productData['family_category_id'],
                    'price' => $productData['price_per_unit'] ?? 0,
                    'desc_short' => $productData['description'] ?? null,
                    'desc_long' => $productData['long_description'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            
            \Log::info('Created product with ID: ' . $productId);
    
            // Add product details if provided
            if ($request->has('details')) {
                $detailsData = $request->input('details');
                
                // Update the product with details
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $productId)
                    ->update([
                        'size' => $detailsData['size'] ?? null,
                        'color' => $detailsData['color'] ?? null,
                        'style' => $detailsData['style'] ?? null,
                        'speciality' => $detailsData['speciality'] ?? null,
                        'material' => $detailsData['material'] ?? null,
                        'spacing' => $detailsData['spacing'] ?? null
                    ]);
            }
    
            // Add shipping details if provided
            if ($request->has('shipping')) {
                $shippingData = $request->input('shipping');
                
                // Update the product with shipping details
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $productId)
                    ->update([
                        'weight_lbs' => $shippingData['weight'] ?? 0,
                        'ship_length' => $shippingData['length'] ?? null,
                        'ship_width' => $shippingData['width'] ?? null,
                        'ship_height' => $shippingData['height'] ?? null,
                        'free_shipping' => isset($shippingData['free_shipping']) ? 1 : 0,
                        'special_shipping' => isset($shippingData['special_shipping']) ? 1 : 0
                    ]);
            }
    
            // Handle media uploads
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $type => $file) {
                    $path = $file->store('products', 'public');
                    
                    // Update the appropriate image field
                    if ($type == 'main_image') {
                        DB::connection('academyfence')
                            ->table('products')
                            ->where('id', $productId)
                            ->update(['img_large' => basename($path)]);
                    } else if ($type == 'thumbnail') {
                        DB::connection('academyfence')
                            ->table('products')
                            ->where('id', $productId)
                            ->update(['img_small' => basename($path)]);
                    }
                }
            }
    
            // Add inventory data if provided
            if ($request->has('inventory')) {
                $inventoryData = $request->input('inventory');
                
                // Update inventory fields
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $productId)
                    ->update([
                        'inv_stocked' => $inventoryData['in_stock_hq'] ?? 0,
                        'inv_ordered' => $inventoryData['in_stock_warehouse'] ?? 0,
                        'inv_ordered_expect' => $inventoryData['inventory_ordered'] ?? 0
                    ]);
            }
    
            DB::connection('academyfence')->commit();
            \Log::info('Product creation successful');
    
            return redirect()->route('products.index')->with('success', 'Product created successfully');
    
        } catch (\Exception $e) {
            DB::connection('academyfence')->rollBack();
            \Log::error('Error creating product:');
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Get product from the new database
        $product = DB::connection('academyfence')
            ->table('products')
            ->where('id', $id)
            ->first();
            
        if (!$product) {
            abort(404, 'Product not found');
        }
        
        // Get all categories
        $familyCategories = DB::connection('academyfence')
            ->table('categories')
            ->where('web_enabled', 1)
            ->orderBy('cat_name')
            ->get();
        
        // Format product data to match the expected structure in the view
        $formattedProduct = (object)[
            'product_id' => $product->id,
            'item_no' => $product->item_no,
            'product_name' => $product->product_name,
            'family_category_id' => $product->categories_id,
            'price_per_unit' => $product->price,
            'description' => $product->desc_short,
            'long_description' => $product->desc_long,
            'details' => (object)[
                'size' => $product->size,
                'color' => $product->color,
                'style' => $product->style,
                'speciality' => $product->speciality,
                'material' => $product->material,
                'spacing' => $product->spacing
            ],
            'shippingDetails' => (object)[
                'weight' => $product->weight_lbs,
                'length' => $product->ship_length,
                'width' => $product->ship_width,
                'height' => $product->ship_height,
                'free_shipping' => $product->free_shipping,
                'special_shipping' => $product->special_shipping
            ],
            'inventory' => (object)[
                'in_stock_hq' => $product->inv_stocked,
                'in_stock_warehouse' => $product->inv_ordered,
                'inventory_ordered' => $product->inv_ordered_expect
            ],
            'media' => (object)[
                'main_image' => $product->img_large,
                'thumbnail' => $product->img_small
            ]
        ];
        
        return view('ams.product.edit-product', [
            'product' => $formattedProduct,
            'familyCategories' => $familyCategories
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::connection('academyfence')->beginTransaction();

            // Get the product
            $product = DB::connection('academyfence')
                ->table('products')
                ->where('id', $id)
                ->first();
                
            if (!$product) {
                throw new \Exception('Product not found');
            }
            
            // Update main product
            $productData = $request->input('product');
            DB::connection('academyfence')
                ->table('products')
                ->where('id', $id)
                ->update([
                    'product_name' => $productData['product_name'],
                    'item_no' => $productData['item_no'],
                    'categories_id' => $productData['family_category_id'],
                    'price' => $productData['price_per_unit'] ?? 0,
                    'desc_short' => $productData['description'] ?? null,
                    'desc_long' => $productData['long_description'] ?? null,
                    'updated_at' => now()
                ]);

            // Update details
            if ($request->has('details')) {
                $detailsData = $request->input('details');
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $id)
                    ->update([
                        'size' => $detailsData['size'] ?? null,
                        'color' => $detailsData['color'] ?? null,
                        'style' => $detailsData['style'] ?? null,
                        'speciality' => $detailsData['speciality'] ?? null,
                        'material' => $detailsData['material'] ?? null,
                        'spacing' => $detailsData['spacing'] ?? null
                    ]);
            }

            // Update shipping
            if ($request->has('shipping')) {
                $shippingData = $request->input('shipping');
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $id)
                    ->update([
                        'weight_lbs' => $shippingData['weight'] ?? 0,
                        'ship_length' => $shippingData['length'] ?? null,
                        'ship_width' => $shippingData['width'] ?? null,
                        'ship_height' => $shippingData['height'] ?? null,
                        'free_shipping' => isset($shippingData['free_shipping']) ? 1 : 0,
                        'special_shipping' => isset($shippingData['special_shipping']) ? 1 : 0
                    ]);
            }

            // Update inventory
            if ($request->has('inventory')) {
                $inventoryData = $request->input('inventory');
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $id)
                    ->update([
                        'inv_stocked' => $inventoryData['in_stock_hq'] ?? 0,
                        'inv_ordered' => $inventoryData['in_stock_warehouse'] ?? 0,
                        'inv_ordered_expect' => $inventoryData['inventory_ordered'] ?? 0
                    ]);
            }

            // Handle media updates
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $type => $file) {
                    $path = $file->store('products', 'public');
                    
                    // Update the appropriate image field
                    if ($type == 'main_image') {
                        DB::connection('academyfence')
                            ->table('products')
                            ->where('id', $id)
                            ->update(['img_large' => basename($path)]);
                    } else if ($type == 'thumbnail') {
                        DB::connection('academyfence')
                            ->table('products')
                            ->where('id', $id)
                            ->update(['img_small' => basename($path)]);
                    }
                }
            }

            DB::connection('academyfence')->commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully');

        } catch (\Exception $e) {
            DB::connection('academyfence')->rollBack();
            \Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function deleteImage($id, $type)
    {
        try {
            // Get the product
            $product = DB::connection('academyfence')
                ->table('products')
                ->where('id', $id)
                ->first();
                
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }

            // Determine which image field to clear
            $imageField = null;
            $imagePath = null;
            
            if ($type == 'main_image') {
                $imageField = 'img_large';
                $imagePath = $product->img_large;
            } else if ($type == 'thumbnail') {
                $imageField = 'img_small';
                $imagePath = $product->img_small;
            }
            
            if ($imageField && $imagePath) {
                // Delete the file if it exists
                if (Storage::disk('public')->exists('products/' . $imagePath)) {
                    Storage::disk('public')->delete('products/' . $imagePath);
                }
                
                // Update the database record
                DB::connection('academyfence')
                    ->table('products')
                    ->where('id', $id)
                    ->update([$imageField => null]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductsByCategory($categoryId, Request $request)
    {
        try {
            // Get products for the specified category
            $products = DB::connection('academyfence')
                ->table('products')
                ->where('categories_id', $categoryId)
                ->get();

            \Log::info('Products query for category:', [
                'category_id' => $categoryId,
                'count' => $products->count()
            ]);

            return response()->json([
                'success' => true,
                'total' => $products->count(),
                'data' => $products
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting products:', [
                'category_id' => $categoryId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error loading products: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getByCategory($categoryId)
    {
        try {
            // Get category name
            $category = DB::connection('academyfence')
                ->table('categories')
                ->where('id', $categoryId)
                ->first();
                
            // Get products for this category
            $products = DB::connection('academyfence')
                ->table('products')
                ->where('categories_id', $categoryId)
                ->get()
                ->map(function ($product) use ($category) {
                    return [
                        'id' => $product->id,
                        'item_no' => $product->item_no,
                        'product_name' => $product->product_name,
                        'family_category' => [
                            'id' => $product->categories_id,
                            'name' => $category ? $category->cat_name : 'N/A'
                        ],
                        'stock_status' => ($product->inv_stocked > 0 || $product->inv_ordered > 0) 
                            ? 'In Stock' 
                            : 'Out of Stock'
                    ];
                });

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching products by category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load products. Please try again.'
            ], 500);
        }
    }
}