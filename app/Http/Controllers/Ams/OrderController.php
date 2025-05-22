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
        try {
            // Create a temporary order object with default values
            $order = (object)[
                'id' => time(), // Use timestamp as temporary ID
                'temp_id' => time(), // Use timestamp as temporary ID
                'created_by' => auth()->id() ?? 1,
                'created_at' => now(),
                'call_date' => now()->format('Y-m-d H:i:s'),
                'status' => 'new',
                'subtotal' => 0,
                'tax' => 0,
                'shipping' => 0,
                'total' => 0
            ];
            
            // Default empty collections
            $shippingAddresses = collect([]);
            $billingInfo = collect([]);
            $selectedCustomer = null;

            // If customer_id is provided, get all customer data
            if ($request->has('customer_id')) {
                // Get customer details
                $selectedCustomer = DB::connection('mysql_second')->table('customers')
                    ->where('id', $request->customer_id)
                    ->first();
                
                if ($selectedCustomer) {
                    // Set customer data in order
                    $order->cust_id_fk = $selectedCustomer->id;
                    $order->customer_name = $selectedCustomer->name;
                    $order->customer_company = $selectedCustomer->company;
                    $order->customer_email = $selectedCustomer->email;
                    $order->customer_phone = $selectedCustomer->phone;
                    
                    // Get customer shipping addresses
                    $shippingAddresses = DB::connection('mysql_second')->table('cust_addresses')
                        ->where(function($query) use ($selectedCustomer) {
                            $query->where('cust_id_fk', $selectedCustomer->id)
                                  ->orWhere('customers_id', $selectedCustomer->id);
                        })
                        ->get();
                    
                    // Get customer billing information
                    $billingInfo = DB::connection('mysql_second')->table('cust_billing')
                        ->where(function($query) use ($selectedCustomer) {
                            $query->where('cust_id_fk', $selectedCustomer->id)
                                  ->orWhere('customers_id', $selectedCustomer->id);
                        })
                        ->get();
                    
                    // If we have a primary shipping address, use it
                    if ($selectedCustomer->primary_addr_fk) {
                        $primaryAddress = $shippingAddresses->firstWhere('id', $selectedCustomer->primary_addr_fk);
                        if ($primaryAddress) {
                            $order->shipping_address = $primaryAddress;
                        }
                    }
                    
                    // If we have a primary billing address, use it
                    if ($selectedCustomer->primary_billing_fk) {
                        $primaryBilling = $billingInfo->firstWhere('id', $selectedCustomer->primary_billing_fk);
                        if ($primaryBilling) {
                            $order->billing_info = $primaryBilling;
                        }
                    }
                }
            }
            
            // Get all customers for the dropdown
            $customers = DB::connection('mysql_second')->table('customers')
                ->select('id', 'name', 'company', 'contact', 'email', 'phone', 'phone_alt', 'fax')
                ->whereNotNull('name')
                ->whereNotNull('company')
                ->whereNotNull('contact')
                ->whereNotNull('email')
                ->whereNotNull('phone')
                ->orderBy('id')
                ->get();
                
            // Get products with category_id 82 or class 'wpc'
            $specialProducts = DB::connection('mysql_second')->table('products')
                ->where('categories_id', 82)
                ->orWhere('class', 'wpc')
                ->select('id', 'product_name', 'categories_id', 'class')
                ->get();
                
            // Check if alternative shipper should be used
            $useAlternativeShipper = $specialProducts->isNotEmpty();

            return view('ams.order.create-order', [
                'order' => $order,
                'customers' => $customers,
                'selectedCustomer' => $selectedCustomer,
                'shippingAddresses' => $shippingAddresses,
                'billingInfo' => $billingInfo,
                'specialProducts' => $specialProducts,
                'useAlternativeShipper' => $useAlternativeShipper
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in OrderController@create: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Return a view with error message
            return view('ams.order.create-order', [
                'order' => (object)[
                    'id' => time(),
                    'temp_id' => time(),
                    'status' => 'new',
                    'subtotal' => 0,
                    'tax' => 0,
                    'shipping' => 0,
                    'total' => 0
                ],
                'customers' => collect([]),
                'selectedCustomer' => null,
                'shippingAddresses' => collect([]),
                'billingInfo' => collect([]),
                'error' => 'An error occurred while loading the order form: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Order Data Received:', $request->all());
            
            // Map the UI order status to the database enum values
            $statusMap = [
                'QUOTE' => 'email_quote',
                'NEW' => 'new',
                'PROCESSED' => 'completed',
                'PROCESSING' => 'processing',
                'DEPOSIT' => 'deposit',
                'MATERIAL' => 'processing' // Map MATERIAL to processing as a fallback
            ];
            
            $dbOrderStatus = isset($request->order_status) && isset($statusMap[$request->order_status]) 
                ? $statusMap[$request->order_status] 
                : 'new';
            
            // Prepare data array with only valid columns
            $orderData = [
                'cust_id_fk' => $request->customer_id,
                'customers_id' => $request->customer_id, // Add customers_id which is required
                'order_date' => now(),
                'order_mod' => now(),
                'order_mod_by' => auth()->id() ?? 1,
                'order_calldate' => $request->call_date ? date('Y-m-d H:i:s', strtotime($request->call_date)) : now(),
                'payment_method' => $request->payment_method ?? 'check',
                'order_status' => $dbOrderStatus,
                'order_type' => ($dbOrderStatus == 'email_quote' || $dbOrderStatus == 'net_quote') ? 'quote' : 'order',
                'order_subtot' => $request->subtotal ?? 0,
                'order_tax' => $request->tax_amount ?? 0,
                'order_shipcost' => $request->shipping_cost ?? 0,
                'order_tot' => $request->total ?? 0
            ];
            
            // Add notes if provided
            if (isset($request->notes)) {
                $orderData['order_notes'] = $request->notes;
            }
            
            // Add sales person if provided
            if (isset($request->sales_person)) {
                $orderData['sales_person'] = $request->sales_person;
            }
            
            \Log::info('Inserting order with data:', $orderData);
            
            // Create order
            $orderId = DB::connection('mysql_second')->table('orders')->insertGetId($orderData);
            
            \Log::info('Order created with ID: ' . $orderId);
            
            // Optionally: Store quote_number in order_quotedate field for reference
            if ($request->quote_number) {
                DB::connection('mysql_second')->table('orders')
                    ->where('id', $orderId)
                    ->update([
                        'order_quotedate' => now()
                    ]);
            }

            // Optionally: Store sold_number in order_solddate field for reference
            if ($request->sold_number) {
                DB::connection('mysql_second')->table('orders')
                    ->where('id', $orderId)
                    ->update([
                        'order_solddate' => now()
                    ]);
            }

            // Save order items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    DB::connection('mysql_second')->table('order_items')->insert([
                        'order_id_fk' => $orderId,
                        'product_id_fk' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'creation' => now(),
                        'modified' => now(),
                        'mod_by' => auth()->id() ?? 1
                    ]);
                }
            }

            // Save shipping address if provided
            if ($request->has('shipping_address_id')) {
                DB::connection('mysql_second')->table('orders')
                    ->where('id', $orderId)
                    ->update([
                        'shipping_address_id_fk' => $request->shipping_address_id
                    ]);
            }

            // Save billing address if provided
            if ($request->has('billing_address_id')) {
                DB::connection('mysql_second')->table('orders')
                    ->where('id', $orderId)
                    ->update([
                        'billing_address_id_fk' => $request->billing_address_id
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            Log::error('Error in OrderController@store: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating order: ' . $e->getMessage()
            ], 500);
        }
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
                        'speciality' => $product->speciality,
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
    
    /**
     * Display the specified order.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            // Get the order from the second database connection
            $orderData = DB::connection('mysql_second')->table('orders')
                ->where('id', $id)
                ->first();
                
            if (!$orderData) {
                return redirect()->route('ams.activity')->with('error', 'Order not found');
            }
            
            // Get customer details
            $customerData = DB::connection('mysql_second')->table('customers')
                ->where('id', $orderData->cust_id_fk)
                ->first();
                
            // Create customer object with expected properties
            $customer = null;
            if ($customerData) {
                $customer = (object)[
                    'id' => $customerData->id,
                    'name' => $customerData->name ?? 'N/A',
                    'company' => $customerData->company ?? 'N/A',
                    'email' => $customerData->email ?? 'N/A',
                    'phone' => $customerData->phone ?? 'N/A'
                ];
            }
            
            // Create a status object with dates that the view might be expecting
            $status = (object)[
                'sold_date' => $orderData->order_solddate ?? null,
                'quote_date' => $orderData->order_quotedate ?? null,
                'customer_confirmed_date' => null,
                'shipped_confirmed_date' => null
            ];
            
            // Get shipping address
            $shippingAddress = null;
            if (isset($orderData->shipping_address_id_fk)) {
                $shippingAddressData = DB::connection('mysql_second')->table('cust_addresses')
                    ->where('id', $orderData->shipping_address_id_fk)
                    ->first();
                    
                if ($shippingAddressData) {
                    $shippingAddress = (object)[
                        'address_1' => $shippingAddressData->addr_address ?? 'N/A',
                        'city' => $shippingAddressData->addr_city ?? 'N/A',
                        'state' => $shippingAddressData->addr_state ?? 'N/A',
                        'zipcode' => $shippingAddressData->addr_zip ?? 'N/A',
                    ];
                }
            }
            
            // Get billing address
            $billingAddress = null;
            if (isset($orderData->billing_address_id_fk)) {
                $billingAddressData = DB::connection('mysql_second')->table('cust_billing')
                    ->where('id', $orderData->billing_address_id_fk)
                    ->first();
                    
                if ($billingAddressData) {
                    $billingAddress = (object)[
                        'address_1' => $billingAddressData->addr_address ?? 'N/A',
                        'city' => $billingAddressData->addr_city ?? 'N/A',
                        'state' => $billingAddressData->addr_state ?? 'N/A',
                        'zipcode' => $billingAddressData->addr_zip ?? 'N/A',
                    ];
                }
            }
            
            // Get shipping details
            $shippingDetails = null;
            $shippingDetailsData = DB::connection('mysql_second')->table('order_shipping_details')
                ->where('order_id_fk', $id)
                ->first();
                
            if ($shippingDetailsData) {
                $shippingDetails = (object)[
                    'carrier' => $shippingDetailsData->carrier ?? 'N/A',
                    'shipby' => $shippingDetailsData->shipby ?? 'N/A',
                    'status' => $shippingDetailsData->status ?? 'N/A',
                    'tracking_no' => $shippingDetailsData->tracking_no ?? 'N/A',
                    'actual_shipping_cost' => $shippingDetailsData->actual_shipping_cost ?? 0,
                    'shipping_cost_markup' => $shippingDetailsData->shipping_cost_markup ?? 0
                ];
            }
                
            // Create an object with the fields the view is expecting
            $orderObject = (object)[
                'original_order_id' => $orderData->id,
                'customer_id' => $orderData->cust_id_fk,
                'total' => $orderData->order_tot,
                'payment_method' => $orderData->payment_method,
                'order_status' => $orderData->order_status,
                'customer' => $customer, // Include customer as a nested property
                'status' => $status, // Include status as a nested property
                'shippingDetails' => $shippingDetails, // Include shipping details as a nested property
                'shippingAddress' => $shippingAddress, // Include shipping address as a nested property
                'billingAddress' => $billingAddress // Include billing address as a nested property
            ];
                
            // Get order items
            $orderItems = DB::connection('mysql_second')->table('order_items')
                ->where('order_id_fk', $id)
                ->get();
        
            // Get other orders by the same customer
            $customerOrders = collect();
            if ($customer) {
                $otherOrdersData = DB::connection('mysql_second')->table('orders')
                    ->where('cust_id_fk', $customer->id)
                    ->where('id', '!=', $id)
                    ->orderBy('order_date', 'desc')
                    ->limit(5)
                    ->get();
                
                foreach ($otherOrdersData as $otherOrder) {
                    $customerOrders->push((object)[
                        'original_order_id' => $otherOrder->id,
                        'total' => $otherOrder->order_tot,
                        'status' => (object)[
                            'sold_date' => $otherOrder->order_solddate,
                            'quote_date' => $otherOrder->order_quotedate
                        ]
                    ]);
                }
            }
        
            \Log::info('Rendering order details with data', [
                'order_id' => $id,
                'has_customer' => !is_null($customer),
                'has_shipping' => !is_null($shippingAddress),
                'has_shipping_details' => !is_null($shippingDetails),
                'has_billing' => !is_null($billingAddress),
                'item_count' => $orderItems->count(),
                'other_orders' => $customerOrders->count()
            ]);
        
            return view('ams.order.order-details', [
                'order' => $orderObject,
                'orderItems' => $orderItems,
                'customerOrders' => $customerOrders
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in OrderController@show: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->route('ams.activity')->with('error', 'Error loading order details: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of the orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activity(Request $request)
    {
        $activityDate = $request->input('activity_date', now()->toDateString());
        $status = $request->input('status', 'all');
        $dateRange = $request->input('daterange', 0);

        // Determine the date to filter by
        if ($request->has('activity_date')) {
            // If a specific date is provided in the URL, use that for filtering
            $filterDate = \Carbon\Carbon::parse($activityDate);
            $startDate = $filterDate->copy()->startOfDay();
            $endDate = $filterDate->copy()->endOfDay();
        } else if ($dateRange > 0) {
            // If a date range is specified, calculate the start date
            $startDate = now()->subDays($dateRange)->startOfDay();
            $endDate = now()->endOfDay();
        } else {
            // Default to today
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        }

        // Base query to get orders
        $query = DB::connection('mysql_second')->table('orders')
            ->leftJoin('customers', 'orders.cust_id_fk', '=', 'customers.id')
            ->select(
                'orders.id',
                'orders.order_status as status',
                'orders.order_date as created_at',
                'orders.order_tot as total',
                'orders.order_mod as updated_at',
                'orders.order_mod_by as modified_by',
                'orders.order_quotedate as quote_date',
                'orders.order_solddate as sold_date',
                'orders.order_calldate as call_date',
                'orders.order_calluser as called_by',
                'orders.order_quoteuser as quoted_by',
                'orders.order_solduser as sold_by',
                'orders.order_notes as notes',
                'orders.order_shipby as shipping_method',
                'orders.order_origin as shipping_origin',
                'orders.order_ship as shipping_cost',
                'orders.source',
                'orders.sales_person',
                'orders.payment_method',
                'customers.id as customer_id',
                'customers.name as customer_first_name',
                'customers.company as customer_company',
                'customers.city as customer_city',
                'customers.state as customer_state'
            )
            ->whereBetween('orders.order_date', [$startDate, $endDate]);

        // Filter by status if specified
        if ($status != 'all') {
            $query->where('orders.order_status', $status);
        }

        // Get the orders with pagination
        $orders = $query->orderBy('orders.order_date', 'desc')->paginate(20);

        // Process each order to format and include necessary data
        foreach ($orders as $order) {
            // 1. Customer Information
            $order->customer = (object)[
                'id' => $order->customer_id,
                'name' => $order->customer_first_name,
                'company' => $order->customer_company,
                'city' => $order->customer_city,
                'state' => $order->customer_state
            ];

            // 2. Order Status Information
            $order->status = (object)[
                'status' => $order->status,
                'quote_date' => $order->quote_date,
                'sold_date' => $order->sold_date,
                'customer_confirmed_date' => null, // Will need to add if you have this field
                'shipping_confirmed_date' => null  // Will need to add if you have this field
            ];
            
            // 3. Get Shipping Address from cust_addresses
            $shippingAddress = DB::connection('mysql_second')->table('cust_addresses')
                ->where('cust_id_fk', $order->customer_id)
                ->where('addr_shipping', 1)
                ->first();

            if ($shippingAddress) {
                $order->shippingAddress = (object)[
                    'address_1' => $shippingAddress->addr_address ?? 'N/A',
                    'address_2' => $shippingAddress->addr_address2 ?? '',
                    'city' => $shippingAddress->addr_city ?? 'N/A',
                    'state' => $shippingAddress->addr_state ?? 'N/A',
                    'zipcode' => $shippingAddress->addr_postcode ?? 'N/A',
                    'phone' => $shippingAddress->addr_phone ?? 'N/A'
                ];
            } else {
                $order->shippingAddress = null;
            }

            // 4. Get Billing Address from cust_billing
            $billingAddress = DB::connection('mysql_second')->table('cust_billing')
                ->where('cust_id_fk', $order->customer_id)
                ->first();

            if ($billingAddress) {
                $order->billingAddress = (object)[
                    'name' => $billingAddress->name ?? 'N/A',
                    'company' => $billingAddress->company ?? '',
                    'cc_type' => $billingAddress->cc_type ?? '',
                    'cc_last4' => $billingAddress->cc_last4 ?? ''
                ];
            } else {
                $order->billingAddress = null;
            }

            // 5. Get Order Items
            $orderItems = DB::connection('mysql_second')->table('order_items')
                ->where('order_id_fk', $order->id)
                ->where('enabled', 1)
                ->orderBy('sort', 'asc')
                ->get();

            $formattedItems = [];
            foreach ($orderItems as $item) {
                $product = DB::connection('mysql_second')->table('products')
                    ->where('id', $item->product_id_fk)
                    ->first();

                $formattedItem = (object)[
                    'product_quantity' => $item->item_quantity,
                    'product_price_at_time_of_purchase' => $item->item_price ?: ($product->price ?? 0),
                    'product' => (object)[
                        'id' => $product->product_id ?? null,
                        'product_name' => !empty($item->item_mod) ? $item->product_name : ($product->product_name ?? 'Unknown Product'),
                        'item_no' => !empty($item->item_mod) ? $item->item_no : ($product->item_no ?? 'N/A'),
                        'details' => (object)[
                            'size1' => !empty($item->item_mod) ? $item->size : ($product->size ?? 'N/A'),
                            'size2' => !empty($item->item_mod) ? $item->display_size2 : ($product->display_size_2 ?? 'N/A'),
                            'color' => !empty($item->item_mod) ? $item->color : ($product->color ?? 'N/A'),
                            'weight_lbs' => !empty($item->item_mod) ? $item->weight_lbs : ($product->weight_lbs ?? 0)
                        ]
                    ]
                ];

                $formattedItems[] = $formattedItem;
            }

            $order->order = $formattedItems;

            // 6. Add shipping details directly to the order
            $order->shipping_details = (object)[
                'carrier' => $order->shipping_method ?? 'N/A',
                'tracking_no' => '' // Add tracking number field if available
            ];
        }

        // Calculate order and quote totals
        $orderTotal = 0;
        $quoteTotal = 0;
        foreach ($orders as $order) {
            if ($order->status->status == 'completed') {
                $orderTotal += $order->total;
            }
            if ($order->status->status == 'email_quote') {
                $quoteTotal += $order->total;
            }
        }

        return view('ams.activity', [
            'orders' => $orders,
            'activityDate' => $activityDate,
            'orderTotal' => $orderTotal,
            'quoteTotal' => $quoteTotal
        ]);
    }

    /**
     * Edit an existing order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            // Get order data
            $order = DB::connection('mysql_second')->table('orders')
                ->where('id', $id)
                ->first();
                
            if (!$order) {
                return redirect()->route('ams.activity')->with('error', 'Order not found');
            }
            
            // Get customer data
            $customer = DB::connection('mysql_second')->table('customers')
                ->where('id', $order->cust_id_fk)
                ->first();
                
            // Get shipping address
            $shippingAddress = DB::connection('mysql_second')->table('cust_addresses')
                ->where('cust_id_fk', $order->cust_id_fk)
                ->where('addr_shipping', 1)
                ->first();
                
            // Get billing address
            $billingAddress = DB::connection('mysql_second')->table('cust_billing')
                ->where('cust_id_fk', $order->cust_id_fk)
                ->first();
                
            // Get order items
            $orderItems = DB::connection('mysql_second')->table('order_items')
                ->where('order_id_fk', $id)
                ->where('enabled', 1)
                ->orderBy('sort', 'asc')
                ->get();
                
            $formattedItems = [];
            foreach ($orderItems as $item) {
                $product = DB::connection('mysql_second')->table('products')
                    ->where('id', $item->product_id_fk)
                    ->first();
                    
                if ($product) {
                    $formattedItem = (object)[
                        'product_id' => $product->id,
                        'product_name' => !empty($item->item_mod) ? $item->product_name : $product->product_name,
                        'item_no' => !empty($item->item_mod) ? $item->item_no : $product->item_no,
                        'quantity' => $item->item_quantity,
                        'price' => $item->item_price ?: $product->price,
                        'size' => !empty($item->item_mod) ? $item->size : $product->size,
                        'color' => !empty($item->item_mod) ? $item->color : $product->color,
                        'weight_lbs' => !empty($item->item_mod) ? $item->weight_lbs : $product->weight_lbs
                    ];
                    
                    $formattedItems[] = $formattedItem;
                }
            }
            
            // Get all customers for the dropdown - same as in create method
            $customers = DB::connection('mysql_second')->table('customers')
                ->select('id', 'name', 'company', 'contact', 'email', 'phone', 'phone_alt', 'fax')
                ->whereNotNull('name')
                ->whereNotNull('company')
                ->whereNotNull('contact')
                ->whereNotNull('email')
                ->whereNotNull('phone')
                ->orderBy('id')
                ->get();
            
            // Return edit view with data
            return view('ams.order.create-order', [
                'order' => $order,
                'customer' => $customer,
                'customers' => $customers, // Added customers for the dropdown
                'selectedCustomer' => $customer,
                'shippingAddress' => $shippingAddress,
                'billingAddress' => $billingAddress,
                'orderItems' => $formattedItems,
                'isEdit' => true
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in edit method: ' . $e->getMessage());
            return redirect()->route('ams.activity')->with('error', 'Error loading order for editing: ' . $e->getMessage());
        }
    }
}
