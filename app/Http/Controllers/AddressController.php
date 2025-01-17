<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function show(CustomerAddress $address)
    {
        return response()->json($address);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'address_name' => 'nullable|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
        ]);

        $address = CustomerAddress::create([
            'customer_id' => $request->customer_id,
            'address_name' => $request->address_name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'billing_flag' => $request->has('billing_flag'),
            'shipping_flag' => $request->has('shipping_flag'),
        ]);

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    public function update(Request $request, CustomerAddress $address)
    {
        $request->validate([
            'address_name' => 'nullable|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
        ]);

        $address->update([
            'address_name' => $request->address_name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'billing_flag' => $request->has('billing_flag'),
            'shipping_flag' => $request->has('shipping_flag'),
        ]);

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    public function destroy(CustomerAddress $address)
    {
        $address->delete();
        return response()->json(['success' => true]);
    }
}