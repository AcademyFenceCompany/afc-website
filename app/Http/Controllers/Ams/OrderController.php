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


class OrderController extends Controller
{
    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $salesPersons = User::all();
        $customers = Customer::with(['addresses'])->get();

        // Load categories with nested structure
        $categories = FamilyCategory::select([
            'family_category_id',
            'parent_category_id',
            'family_category_name',
            DB::raw('(SELECT COUNT(*) FROM products WHERE products.family_category_id = family_categories.family_category_id) as products_count')
        ])
        ->with(['children' => function($query) {
            $query->select([
                'family_category_id',
                'parent_category_id',
                'family_category_name'
            ])->withCount('products');
        }])
        ->whereNull('parent_category_id')
        ->get();
        
        return view('ams.order.create-order', compact('salesPersons', 'customers', 'categories'));
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
     * Get customer addresses.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerAddresses(Customer $customer)
    {
        $addresses = $customer->addresses()
            ->select([
                'id',
                'address_line1',
                'address_line2',
                'city',
                'state',
                'zip_code',
                'shipping_flag',
                'billing_flag'
            ])
            ->get();

        return response()->json($addresses);
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
}
