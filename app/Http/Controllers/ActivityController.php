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
            'order.product.details', // Include ProductDetail through Product
            'status',
        ]);

        // Search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('customer_order_id', 'like', "%$search%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
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
