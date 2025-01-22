<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerOrder;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Base query for fetching orders with relationships
        $query = CustomerOrder::with([
            'customer',
            'billingAddress',
            'shippingAddress',
            'order.product', // Include ProductDetail through Product
            'status',
        ]);

        // Search filter
        if ($request->filled('search')) { // `filled` checks if input is not null/empty
            $search = $request->input('search');
    
            // Search by customer_order_id or customer name
            $query->where(function ($q) use ($search) {
                $q->where('original_customer_order_id', 'like', "%$search%")
                  ->orWhereHas('customer', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%$search%");
                  });
            });
        }

        // Status filter
        if ($request->has('status') && $request->input('status') !== 'all') {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('status', $request->input('status'));
            });
        }

        // Order by most recent date: sold_date > quote_date > created_at
        $orders = $query->paginate(10);


        // Return the view with the paginated data
        return view('ams.activity', compact('orders'));
    }
}
