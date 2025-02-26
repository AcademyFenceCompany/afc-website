<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\FamilyCategory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showWeldedWire()
    {
        // Fetch the Welded Wire category
        $weldedWireCategory = FamilyCategory::where('family_category_name', 'Welded Wire')->first();

        if (!$weldedWireCategory) {
            abort(404, 'Welded Wire category not found.');
        }

        // Fetch products related to the Welded Wire category
        // $products = Product::where('family_category_id', $weldedWireCategory->product_id)
        //     ->with(['productDetail', 'productMedia'])
        //     ->get();

        $general_products_ww = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id');

        $products_ww = DB::table('products')
            ->select($columns = ['*'])
            ->get();

        $general_ww_mesh_size_imgs = $general_products_ww
            ->join('general_media', 'product_details.size2', '=', 'general_media.size_portrayed')
            ->select($columns = ['general_media.image', 'general_media.size_portrayed', 'product_details.size2'])
            ->groupBy('general_media.size_portrayed', 'general_media.image')
            ->get();

        return view('categories.weldedwire', compact('weldedWireCategory', 'products_ww', 'general_ww_mesh_size_imgs'));
    }

    public function create()
    {
        // Debug: Log available categories
        $familyCategories = FamilyCategory::all();
        \Log::info('Available categories:', $familyCategories->toArray());
        return view('ams.product.add-product', compact('familyCategories'));
    }

    public function index(Request $request)
    {
        try {
            // Load categories with nested structure
            $categories = FamilyCategory::select([
                'family_category_id',
                'parent_category_id',
                'family_category_name'
            ])
            ->withCount(['products' => function($query) {
                // Count products where this category is either the main category or subcategory
                $query->where(function($q) {
                    $q->where('family_category_id', '=', DB::raw('family_categories.family_category_id'))
                      ->orWhere('subcategory_id', '=', DB::raw('family_categories.family_category_id'));
                });
            }])
            ->with(['children' => function($query) {
                $query->select([
                    'family_category_id',
                    'parent_category_id',
                    'family_category_name'
                ])->withCount(['products' => function($query) {
                    $query->where(function($q) {
                        $q->where('family_category_id', '=', DB::raw('family_categories.family_category_id'))
                          ->orWhere('subcategory_id', '=', DB::raw('family_categories.family_category_id'));
                    });
                }]);
            }])
            ->whereNull('parent_category_id')
            ->get();

            // Handle AJAX requests for product data
            if ($request->ajax()) {
                $query = Product::with([
                    'familyCategory:family_category_id,family_category_name',
                    'subcategory:family_category_id,family_category_name',
                    'inventory:product_id,in_stock_hq,in_stock_warehouse'
                ]);

                // Apply category filter
                if ($request->filled('category')) {
                    $categoryId = $request->category;
                    
                    // Get the category and check if it's a parent or child
                    $category = FamilyCategory::with('children')->find($categoryId);
                    
                    if ($category) {
                        if ($category->children->count() > 0) {
                            // If it's a parent category, get products from it and all its children
                            $childrenIds = $category->children->pluck('family_category_id')->toArray();
                            $query->where(function($q) use ($categoryId, $childrenIds) {
                                $q->where('family_category_id', $categoryId)
                                  ->orWhere('subcategory_id', $categoryId)
                                  ->orWhereIn('family_category_id', $childrenIds)
                                  ->orWhereIn('subcategory_id', $childrenIds);
                            });
                        } else {
                            // If it's a child category or has no children, just get its products
                            $query->where(function($q) use ($categoryId) {
                                $q->where('family_category_id', $categoryId)
                                  ->orWhere('subcategory_id', $categoryId);
                            });
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
                            $query->whereHas('inventory', function($q) {
                                $q->where('in_stock_hq', '>', 0)
                                  ->orWhere('in_stock_warehouse', '>', 0);
                            });
                            break;
                        case 'low_stock':
                            $query->whereHas('inventory', function($q) {
                                $q->where('in_stock_hq', '<=', 5)
                                  ->where('in_stock_warehouse', '<=', 5)
                                  ->where(function($sq) {
                                      $sq->where('in_stock_hq', '>', 0)
                                         ->orWhere('in_stock_warehouse', '>', 0);
                                  });
                            });
                            break;
                    }
                }

                $products = $query->get()->map(function ($product) {
                    $category = $product->familyCategory ?? $product->subcategory;
                    return [
                        'id' => $product->product_id,
                        'item_no' => $product->item_no,
                        'product_name' => $product->product_name,
                        'family_category' => [
                            'id' => $category->family_category_id ?? null,
                            'name' => $category->family_category_name ?? 'N/A'
                        ],
                        'price' => number_format($product->price_per_unit ?? 0, 2),
                        'stock' => [
                            'hq' => (int)($product->inventory->in_stock_hq ?? 0),
                            'warehouse' => (int)($product->inventory->in_stock_warehouse ?? 0)
                        ],
                        'stock_status' => $product->inventory 
                            ? ($product->inventory->in_stock_hq > 0 || $product->inventory->in_stock_warehouse > 0 
                                ? 'In Stock' 
                                : 'Out of Stock')
                            : 'N/A'
                    ];
                });

                return response()->json([
                    'success' => true,
                    'products' => $products
                ]);
            }

            // For initial page load, get all products
            $query = Product::with([
                'familyCategory:family_category_id,family_category_name',
                'subcategory:family_category_id,family_category_name',
                'inventory:product_id,in_stock_hq,in_stock_warehouse'
            ]);
            
            $products = $query->paginate($request->get('per_page', 10));

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
    
            DB::beginTransaction();
    
            // Create the main product
            $product = Product::create($request->input('product'));
            \Log::info('Created product:', $product->toArray());
    
            // Debug each section
            if ($request->has('details')) {
                $detailsData = $request->input('details');
                $detailsData['product_id'] = $product->product_id; 
                \Log::info('Creating product details with:', $detailsData);
                
                $product->details()->create($detailsData);
            }
    
            if ($request->has('shipping')) {
                $shippingData = $request->input('shipping');
                $shippingData['product_id'] = $product->product_id; // Explicitly set product_id
                \Log::info('Creating shipping details with:', $shippingData);
                
                $product->shippingDetails()->create($shippingData);
            }
    
            if ($request->hasFile('media')) {
                $mediaData = [];
                foreach ($request->file('media') as $type => $file) {
                    $path = $file->store('products', 'public');
                    $mediaData[$type] = $path;
                }
                $mediaData['product_id'] = $product->product_id; // Explicitly set product_id
                
                \Log::info('Creating media with:', $mediaData);
                $product->media()->create($mediaData);
            }
    
            if ($request->has('inventory')) {
                $inventoryData = $request->input('inventory');
                
                // Create inventory using the relationship
                $inventory = $product->inventory()->create([
                    'in_stock_hq' => $inventoryData['in_stock_hq'],
                    'in_stock_warehouse' => $inventoryData['in_stock_warehouse'],
                    'inventory_ordered' => $inventoryData['inventory_ordered'] ?? 0,
                    'product_id' => $product->product_id  
                ]);
                
                \Log::info('Created inventory:', ['inventory' => $inventory->toArray()]);
            }
    
            DB::commit();
            \Log::info('Product creation successful');
    
            return redirect()->route('products.index')->with('success', 'Product created successfully');
    
        } catch (\Exception $e) {
            DB::rollBack();
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
        $product = Product::with(['details', 'shippingDetails', 'inventory', 'media'])
            ->findOrFail($id);
        $familyCategories = FamilyCategory::all();
        
        return view('ams.product.edit-product', compact('product', 'familyCategories'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            
            // Update main product
            $product->update($request->input('product'));
            \Log::info('Updated product:', $product->toArray());

            // Update details
            if ($request->has('details')) {
                $product->details()->update($request->input('details'));
            }

            // Update shipping
            if ($request->has('shipping')) {
                $product->shippingDetails()->update($request->input('shipping'));
            }

            // Update inventory
            if ($request->has('inventory')) {
                $product->inventory()->update($request->input('inventory'));
            }

            // Handle media updates
            if ($request->hasFile('media')) {
                $mediaData = [];
                foreach ($request->file('media') as $type => $file) {
                    $path = $file->store('products', 'public');
                    $mediaData[$type] = $path;
                }
                
                if ($product->media) {
                    $product->media()->update($mediaData);
                } else {
                    $mediaData['product_id'] = $product->product_id;
                    $product->media()->create($mediaData);
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function deleteImage($id, $type)
    {
        try {
            $product = Product::with('media')->findOrFail($id);
            
            if (!$product->media) {
                return response()->json(['success' => false, 'message' => 'No media found']);
            }

            $imagePath = $product->media->{$type};
            
            if ($imagePath) {
                // Delete the file if it exists
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                
                // Update the database record
                $product->media()->update([
                    $type => null
                ]);
                
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
            $perPage = $request->get('per_page', 10);

            // Query using model relationships and check both category fields
            $products =  DB::table('products')
            ->join("product_details", "products.product_id", "=", "product_details.product_id")
            ->where('subcategory_id', $categoryId)
            ->select('*')
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
            $products = Product::with([
                'familyCategory:family_category_id,family_category_name',
                'inventory:product_id,in_stock_hq,in_stock_warehouse'
            ])
            ->where('family_category_id', $categoryId)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->product_id,
                    'item_no' => $product->item_no,
                    'product_name' => $product->product_name,
                    'family_category' => [
                        'id' => $product->familyCategory->family_category_id,
                        'name' => $product->familyCategory->family_category_name
                    ],
                    'stock_status' => $product->inventory 
                        ? ($product->inventory->in_stock_hq > 0 || $product->inventory->in_stock_warehouse > 0 
                            ? 'In Stock' 
                            : 'Out of Stock')
                        : 'N/A'
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