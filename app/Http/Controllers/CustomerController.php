<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with(['orders', 'addresses'])
        ->whereNotNull('name') 
        ->orWhereNotNull('company')
        ->paginate(10);
        
            return view('ams.customers.index', compact('customers'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        // Log the query for debugging
        \Log::info('Search query:', ['query' => $query]);
    
        $customers = Customer::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('company', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('phone', 'like', "%{$query}%")
              ->orWhereRaw("REPLACE(REPLACE(phone, '-', ''), ' ', '') LIKE ?", ["%{$query}%"]);
        })
        ->with(['addresses' => function ($q) {
            $q->where('billing_flag', 1)
              ->orWhere('shipping_flag', 1);
        }])
        ->withCount('orders')
        ->take(10)
        ->get();
    
        \Log::info('Search results:', ['customers' => $customers]);
    
        return response()->json($customers);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:25',
            'phone_ext' => 'nullable|string|max:10',
            'alt_phone' => 'nullable|string|max:25',
            'alt_phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:25',
            
            // Address validation
            'address_name' => 'nullable|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
        ]);

        try {
            DB::beginTransaction();

            // Create customer
            $customer = Customer::create([
                'name' => $request->name,
                'company' => $request->company,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_ext' => $request->phone_ext,
                'alt_phone' => $request->alt_phone,
                'alt_phone_ext' => $request->alt_phone_ext,
                'fax' => $request->fax,
            ]);

            // Create address
            $customer->addresses()->create([
                'address_name' => $request->address_name,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
                'billing_flag' => $request->has('billing_flag'),
                'shipping_flag' => $request->has('shipping_flag'),
            ]);

            DB::commit();

            return redirect()
                ->route('customers.show', $customer)
                ->with('success', 'Customer created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Error creating customer. Please try again.');
        }
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'addresses',
            'orders' => function($query) {
                $query->latest();
            }
        ]);
        
        return view('ams.customers.view', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $customer->load('addresses');
        return view('ams.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:25',
            'phone_ext' => 'nullable|string|max:10',
            'alt_phone' => 'nullable|string|max:25',
            'alt_phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:25',
        ]);

        $customer->update($request->all());

        return redirect()
            ->route('ams.customers.index', $customer)
            ->with('success', 'Customer updated successfully!');
    }
}