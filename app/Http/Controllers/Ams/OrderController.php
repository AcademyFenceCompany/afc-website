<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerOrder;
use App\Models\OrderStatus;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\FamilyCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerAddress;

class OrderController extends Controller
{
    public function __construct()
    {
        DB::enableQueryLog(); // Enable query logging
    }

    /**
     * Show the form for creating a new order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $salesPersons = User::all();
        $customers = Customer::with(['addresses'])->get();
        $categories = FamilyCategory::whereNull('parent_category_id')->get();

        // Create a new empty order with just the numeric fields
        $order = CustomerOrder::create([
            'subtotal' => 0,
            'tax_amount' => 0,
            'shipping' => 0,
            'total' => 0
        ]);
        
        return view('ams.order.create-order', compact('salesPersons', 'customers', 'categories', 'order'));
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Create order
        $order = CustomerOrder::create([
            'customer_id' => $request->customer_id,
            'billing_address_id' => $request->billing_address_id,
            'shipping_address_id' => $request->shipping_address_id,
            'order_origin' => $request->origin,
            'call_date' => Carbon::now(),
        ]);

        // Create order status
        $orderStatus = OrderStatus::create([
            'customer_order_id' => $order->id,
            'call_date' => Carbon::now(),
            'processor_call_date_id' => auth()->id(),
        ]);

        // Create order items
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'original_order_id' => $order->original_order_id,
                    'product_id' => $item['product_id'],
                    'product_quantity' => $item['quantity'],
                    'product_price_at_time_of_purchase' => $item['price'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order' => $order
        ]);
    }

    /**
     * Get products based on category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        try {
            Log::info('Loading products for category: ' . $request->category);
            
            if (!$request->filled('category')) {
                Log::warning('No category ID provided');
                return response()->json([]);
            }

            // Get products with all necessary details
            $products = DB::table('products')
                ->select([
                    'products.product_id',
                    'products.item_no',
                    'products.description as product_name',
                    'products.price_per_unit',
                    'product_details.color',
                    'product_details.style',
                    'product_details.speciality',
                    'product_details.size1',
                    'product_details.size2',
                    'product_details.size3',
                    'inventory_details.in_stock_hq',
                    'inventory_details.in_stock_warehouse'
                ])
                ->leftJoin('product_details', 'products.product_id', '=', 'product_details.product_id')
                ->leftJoin('inventory_details', 'products.product_id', '=', 'inventory_details.product_id')
                ->where('products.family_category_id', $request->category)
                ->get();

            Log::info('Found ' . $products->count() . ' products');
            if ($products->isNotEmpty()) {
                Log::info('Sample product:', $products->first()->toArray());
            }

            // Format products for response
            $formattedProducts = $products->map(function ($product) {
                return [
                    'product_id' => $product->product_id,
                    'item_no' => $product->item_no,
                    'description' => $product->product_name,
                    'price_per_unit' => floatval($product->price_per_unit),
                    'details' => [
                        'color' => $product->color,
                        'style' => $product->style,
                        'specialty' => $product->speciality,
                        'size1' => $product->size1,
                        'size2' => $product->size2,
                        'size3' => $product->size3
                    ],
                    'inventory' => [
                        'quantity' => ($product->in_stock_hq ?? 0) + ($product->in_stock_warehouse ?? 0)
                    ]
                ];
            });

            return response()->json($formattedProducts);
            
        } catch (\Exception $e) {
            Log::error('Error in getProducts: ' . $e->getMessage(), [
                'category' => $request->category,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to load products',
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred while loading products'
            ], 500);
        }
    }

    /**
     * Get customer addresses
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerAddresses(Customer $customer)
    {
        try {
            $addresses = $customer->addresses()
                ->select([
                    'customer_address_id as address_id',
                    'customer_id',
                    'address_1',
                    'address_2',
                    'city',
                    'state',
                    'zipcode',
                    'billing_flag',
                    'shipping_flag'
                ])
                ->get();

            return response()->json([
                'success' => true,
                'addresses' => $addresses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching addresses'
            ], 500);
        }
    }

    /**
     * Update the status of an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerOrder  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, CustomerOrder $order)
    {
        $status = $request->status; // quote, sold, customer_confirmed, shipped_confirmed
        $date = Carbon::now();
        
        $updateData = [
            $status . '_date' => $date,
            'processor_' . $status . '_date_id' => auth()->id()
        ];
        
        OrderStatus::where('customer_order_id', $order->id)->update($updateData);
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($status) . ' status updated successfully'
        ]);
    }

    /**
     * Store a newly created address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAddress(Request $request, $customerId)
    {
        try {
            Log::info('Storing new address for customer', [
                'customer_id' => $customerId,
                'request_data' => $request->all()
            ]);

            // Validate input
            $validated = $request->validate([
                'address_1' => 'required|string|max:255',
                'address_2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:50',
                'zipcode' => 'required|string|max:20',
                'shipping_flag' => 'required|in:0,1',
                'billing_flag' => 'required|in:0,1',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            // Get customer details
            $customer = Customer::where('customer_id', $customerId)->first();

            if (!$customer) {
                Log::error('Customer not found', ['customer_id' => $customerId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found'
                ], 404);
            }

            try {
                // Create the address using the model
                $address = CustomerAddress::create([
                    'customer_id' => $customerId,
                    'original_customer_id' => $customerId, // Set original_customer_id same as customer_id
                    'address_1' => $validated['address_1'],
                    'address_2' => $validated['address_2'],
                    'address_name' => $customer->company ?: $customer->name, // Use company name if available, otherwise use customer name
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'zipcode' => $validated['zipcode'],
                    'shipping_flag' => $validated['shipping_flag'],
                    'billing_flag' => $validated['billing_flag']
                ]);

                // Set original_address_id to the same as customer_address_id
                $address->original_address_id = $address->customer_address_id;
                $address->save();

                Log::info('Address created successfully', ['address_id' => $address->customer_address_id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Address added successfully',
                    'data' => $address
                ]);
            } catch (\Exception $e) {
                Log::error('Database error while saving address', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected error while saving address', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while saving the address. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $customerId
     * @param  int  $addressId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(Request $request, $customerId, $addressId)
    {
        try {
            DB::table('customer_addresses')
                ->where('customer_id', $customerId)
                ->where('customer_address_id', $addressId)
                ->update([
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zipcode' => $request->zipcode,
                    'shipping_flag' => $request->shipping_flag,
                    'billing_flag' => $request->billing_flag,
                ]);

            return response()->json(['success' => true, 'message' => 'Address updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified address from storage.
     *
     * @param  int  $customerId
     * @param  int  $addressId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAddress($customerId, $addressId)
    {
        try {
            DB::table('customer_addresses')
                ->where('customer_id', $customerId)
                ->where('customer_address_id', $addressId)
                ->delete();

            return response()->json(['success' => true, 'message' => 'Address deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display all products organized by gauge/size/color.
     *
     * @return \Illuminate\View\View
     */
    public function getAllProducts()
    {
        // Get all products with their details and categories
        $products = Product::join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->select([
                'products.*',
                'product_details.size1',
                'product_details.size2',
                'product_details.size3',
                'product_details.color',
                'product_details.style',
                'product_details.material',
                'product_details.spacing',
                'product_details.coating'
            ])
            ->orderBy('product_details.size1')
            ->orderBy('product_details.color')
            ->get();

        // Group products by size and color
        $groupedProducts = $products->groupBy('details.size1')->map(function ($sizeGroup) {
            return $sizeGroup->groupBy('details.color');
        });

        // Get categories for the sidebar
        $categories = FamilyCategory::whereNull('parent_category_id')
            ->with('children')
            ->get();

        return view('ams.order.all-products', [
            'groupedProducts' => $groupedProducts,
            'categories' => $categories
        ]);
    }

    /**
     * Display the list of parent categories
     */
    public function categories()
    {
        $categories = FamilyCategory::whereNull('parent_category_id')
            ->withCount('children')
            ->withCount('products')
            ->get();

        return view('ams.order.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Display a category and its subcategories or products
     */
    public function showCategory(FamilyCategory $category)
    {
        // Load relationships
        $category->load(['parent', 'children' => function($query) {
            $query->withCount('children')->withCount('products');
        }]);

        // Get products if this category has any
        $products = Product::join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->leftJoin('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
            ->leftJoin('inventory_details', 'products.product_id', '=', 'inventory_details.product_id')
            ->where(function($query) use ($category) {
                $query->where('products.family_category_id', $category->family_category_id)
                      ->orWhere('products.subcategory_id', $category->family_category_id);
            })
            ->select([
                'products.product_id',
                'products.product_name',
                'products.item_no',
                'products.description',
                'products.price_per_unit',
                'product_details.size1',
                'product_details.size2',
                'product_details.size3',
                'product_details.coating',
                'product_details.color',
                'shipping_details.weight',
                DB::raw('COALESCE(inventory_details.in_stock_warehouse, 0) as in_stock_warehouse'),
                DB::raw('COALESCE(inventory_details.in_stock_hq, 0) as in_stock_hq')
            ])
            ->orderBy('product_details.size2')
            ->orderBy('product_details.coating')
            ->orderBy('product_details.color')
            ->orderBy('products.item_no')
            ->get();

        // Group products by size2, coating, size3, and color
        $groupedProducts = $products->groupBy(function($product) {
            $parts = [];
            if ($product->size2) $parts[] = $product->size2;
            if ($product->coating) $parts[] = $product->coating;
            if ($product->size3) $parts[] = $product->size3;
            if ($product->color) $parts[] = $product->color;
            return implode(' ', $parts) ?: 'Uncategorized';
        });

        // Split into columns while preserving keys
        $totalGroups = $groupedProducts->count();
        $groupsPerColumn = ceil($totalGroups / 3);
        
        $columns = collect();
        $currentColumn = collect();
        $count = 0;
        
        foreach ($groupedProducts as $title => $products) {
            $currentColumn->put($title, $products);
            $count++;
            
            if ($count % $groupsPerColumn === 0 || $count === $totalGroups) {
                $columns->push($currentColumn);
                $currentColumn = collect();
            }
        }

        return view('ams.order.categories.show', [
            'category' => $category,
            'columns' => $columns,
            'products' => $products
        ]);
    }
}
