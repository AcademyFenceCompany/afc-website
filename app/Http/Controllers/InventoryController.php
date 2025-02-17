<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\InventoryDetail; // Ensure you have an Inventory model

class InventoryController extends Controller
{
    /**
     * Display the inventory list.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 'inventory_index'); // Default page parameter

        // Fetch all inventory items (adjust based on your database schema)
        $inventoryItems = InventoryDetail::all();

        return view('ams.inventory', compact('inventoryItems', 'page'));

    }
}
