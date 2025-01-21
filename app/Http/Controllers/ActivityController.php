<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerOrder;
use App\Models\OrderItem;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        // Base query for fetching orders with relationships
        $query = CustomerOrder::with(['customer', 'address', 'order', 'products'])
            ->orderBy('created_at', 'desc');

        // Apply filters based on request inputs
        if ($request->has('search') && $request->input('search') !== '') {
            $search = $request->input('search');
            $query->where('id', 'like', "%$search%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                  });
        }

        if ($request->has('activity_date') && $request->input('activity_date') !== '') {
            $query->whereDate('created_at', $request->input('activity_date'));
        }

        if ($request->has('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        // Paginate orders (10 per page)
        $orders = $query->paginate(10);

        // Return the view with the paginated data
        return view('ams.activity', compact('orders'));
    }
}
