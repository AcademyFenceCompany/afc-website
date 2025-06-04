<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerOrder;


class ActivityController extends Controller
{
    public function index(Request $request)
{
    // Get the current date from the request or default to today
    $activityDate = $request->input('activity_date', now()->toDateString());

    $query = CustomerOrder::with([
        'customer',
        'billingAddress',
        'shippingAddress',
        'order.product',
        'status',
    ]);

    // Search filter
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('original_order_id', 'like', "%$search%")
              ->orWhereHas('customer', function ($subQuery) use ($search) {
                  $subQuery->where('name', 'like', "%$search%");
              });
        });
    }

    // Status filter
    if ($request->has('status') && $request->input('status') !== 'all') {
        $status = $request->input('status');

        $query->whereHas('status', function ($q) use ($status) {
            if ($status === 'sold') {
                $q->whereNotNull('sold_date'); // Only sold orders
            } elseif ($status === 'quote') {
                $q->whereNotNull('quote_date')->whereNull('sold_date'); // Only quoted orders
            } elseif ($status === 'both') {
                $q->whereNotNull('quote_date')->whereNotNull('sold_date'); // Quoted and sold
            } elseif ($status === 'new') {
                $q->whereDate('sold_date', now()->toDateString())
                    ->orWhereDate('quote_date', now()->toDateString()); // Orders with today's sold_date or quote_date
            }
        });
    }

    // Date filter (sold_date or quote_date)
    $query->whereHas('status', function ($q) use ($activityDate) {
        $q->whereDate('sold_date', $activityDate)
          ->orWhereDate('quote_date', $activityDate);
    });

    //$orders = $query->paginate(10);

    //return view('ams.activity', compact('orders', 'activityDate'));
}

    // This method gets all orders
    public function getOders()
    {
        // Fetch all orders with their relationships
        $orders = \DB::table('orders')->limit(10)->get();
        //@dd($orders);
        // Return the view with the orders
        return view('ams.activity', compact('orders'));
    }

public function show($orderId)
{
    // Fetch the order details with all relationships
    $order = CustomerOrder::with([
        'customer',
        'billingAddress',
        'shippingAddress',
        'order.product',
        'status',
        'shippingDetails',
        
    ])->where('original_order_id', $orderId)->firstOrFail();

    // Fetch other orders for the same customer, excluding the current order
    $customerOrders = CustomerOrder::where('customer_id', $order->customer_id)
        ->with('status')
        ->get();

    // Return the order details view
    return view('ams.order.order-details', compact('order', 'customerOrders'));
}
}
