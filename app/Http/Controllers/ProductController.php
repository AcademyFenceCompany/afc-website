<?php

namespace App\Http\Controllers;

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
        return view('ams.add-product', compact('familyCategories'));
    }
    public function index()
    {
        $perPage = request()->get('per_page', 10);
        $products = Product::with(['media', 'details', 'shippingDetails', 'inventory', 'familyCategory'])
        ->orderBy('product_id', 'desc')
        ->paginate($perPage);
            
        return view('ams.view', compact('products'));
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
}

