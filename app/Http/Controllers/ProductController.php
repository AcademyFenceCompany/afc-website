<?php

namespace App\Http\Controllers;

use App\Models\FamilyCategory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
            // Debug incoming data
            \Log::info('Product store method called');
            \Log::info('All request data:', $request->all());
    
            DB::beginTransaction();
    
            // Debug the product data specifically
            \Log::info('Product data:', $request->input('product', []));
    
            // Create the main product
            $product = Product::create($request->input('product'));
            \Log::info('Created product:', $product->toArray());
    
            // Debug each section
            if ($request->has('details')) {
                \Log::info('Product details:', $request->input('details'));
                $product->details()->create($request->input('details'));
            }
    
            if ($request->has('shipping')) {
                \Log::info('Shipping details:', $request->input('shipping'));
                $product->shippingDetails()->create($request->input('shipping'));
            }
    
            if ($request->hasFile('media')) {
                \Log::info('Media files present');
                $mediaData = [];
                foreach ($request->file('media') as $type => $file) {
                    $path = $file->store('products', 'public');
                    $mediaData[$type] = $path;
                }
                $product->media()->create($mediaData);
            }
    
            if ($request->has('inventory')) {
                \Log::info('Inventory details:', $request->input('inventory'));
                $product->inventory()->create($request->input('inventory'));
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

