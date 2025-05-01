<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get customers with direct DB query using mysql_second connection
            $perPage = 20;
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;
            
            // Count total records for pagination
            $totalCustomers = DB::connection('mysql_second')->table('customers')
                ->count();
                
            // Get customers for current page
            $customers = DB::connection('mysql_second')->table('customers')
                ->select('id', 'name', 'company', 'contact', 
                         'email', 'phone', 'phone_alt', 'fax')
                ->whereNotNull('name')
                ->whereNotNull('company')
                ->whereNotNull('contact')
                ->whereNotNull('email')
                ->whereNotNull('id')
                ->orderBy('id')
                ->limit($perPage)
                ->offset($offset)
                ->get();
            
            // Add default orders_count
            foreach ($customers as $customer) {
                $customer->orders_count = 0;
            }
            
            // Create pagination manually
            $lastPage = ceil($totalCustomers / $perPage);
            $pagination = [
                'current_page' => (int)$page,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'total' => $totalCustomers,
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $totalCustomers)
            ];
            
            return view('ams.customers.index', [
                'customers' => $customers,
                'pagination' => $pagination
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading customers: ' . $e->getMessage());
            return view('ams.customers.index', [
                'customers' => collect([]),
                'error' => 'Error loading customers: ' . $e->getMessage()
            ]);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('query');
            
            // Log the query for debugging
            Log::info('Search query:', ['query' => $query]);
        
            // Search customers using direct DB query with mysql_second connection
            $customers = DB::connection('mysql_second')->table('customers')
                ->select('id', 'name', 'company', 'contact', 'email', 'phone', 'phone_alt', 'fax')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('company', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->orWhere('phone', 'like', "%{$query}%")
                      ->orWhereRaw("REPLACE(REPLACE(phone, '-', ''), ' ', '') LIKE ?", ["%{$query}%"]);
                })
                ->orderBy('name')
                ->limit(10)
                ->get();
        
            // Add default orders_count
            foreach ($customers as $customer) {
                $customer->orders_count = 0;
            }
            
            // Get addresses for each customer
            foreach ($customers as $customer) {
                $customer->addresses = DB::connection('mysql_second')->table('cust_addresses')
                    ->where('cust_id_fk', $customer->id)
                    ->where(function ($q) {
                        $q->where('addr_shipping', 1)
                          ->orWhere('addr_billing', 1);
                    })
                    ->get();
            }
        
            Log::info('Search results:', ['count' => count($customers)]);
        
            return response()->json($customers);
        } catch (\Exception $e) {
            Log::error('Error searching customers: ' . $e->getMessage());
            return response()->json(['error' => 'Error searching customers: ' . $e->getMessage()], 500);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'company' => 'nullable|string|max:128',
            'contact' => 'nullable|string|max:128',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:32',
            'phone_alt' => 'nullable|string|max:32',
            'alt_phone' => 'nullable|string|max:32',
            'ext' => 'nullable|string|max:13',
            'fax' => 'nullable|string|max:32',
            
            // Address validation
            'addr_name' => 'nullable|string|max:128',
            'addr_company' => 'nullable|string|max:128',
            'addr_contact' => 'nullable|string|max:128',
            'addr_address' => 'required|string|max:128',
            'addr_address2' => 'nullable|string|max:128',
            'addr_city' => 'required|string|max:128',
            'addr_state' => 'required|string|max:64',
            'addr_postcode' => 'required|string|max:64',
            'addr_country' => 'nullable|string|max:64',
            'addr_phone' => 'nullable|string|max:32',
        ]);

        try {
            DB::beginTransaction();

            // Create customer with direct DB insert using mysql_second connection
            $customerId = DB::connection('mysql_second')->table('customers')->insertGetId([
                'name' => $request->name,
                'company' => $request->company,
                'contact' => $request->contact,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_alt' => $request->phone_alt,
                'alt_phone' => $request->alt_phone,
                'ext' => $request->ext,
                'fax' => $request->fax,
                'creation' => now(),
                'modified' => now(),
                'mod_by' => auth()->id() ?? 1
            ]);

            // Create address with direct DB insert using mysql_second connection
            $addressId = DB::connection('mysql_second')->table('cust_addresses')->insertGetId([
                'cust_id_fk' => $customerId,
                'addr_name' => $request->addr_name,
                'addr_company' => $request->addr_company,
                'addr_contact' => $request->addr_contact,
                'addr_address' => $request->addr_address,
                'addr_address2' => $request->addr_address2,
                'addr_city' => $request->addr_city,
                'addr_state' => $request->addr_state,
                'addr_postcode' => $request->addr_postcode,
                'addr_country' => $request->addr_country ?? 'USA',
                'addr_phone' => $request->addr_phone,
                'addr_shipping' => $request->has('addr_shipping') ? 1 : 0,
                'addr_billing' => $request->has('addr_billing') ? 1 : 0,
                'creation' => now(),
                'modified' => now(),
                'mod_by' => auth()->id() ?? 1,
                'customers_id' => $customerId
            ]);

            // Update customer with primary address using mysql_second connection
            DB::connection('mysql_second')->table('customers')
                ->where('id', $customerId)
                ->update([
                    'primary_addr_fk' => $addressId,
                    'primary_billing_fk' => $request->has('addr_billing') ? $addressId : null,
                    'primary_billaddr_fk' => $request->has('addr_billing') ? $addressId : null
                ]);

            DB::commit();

            return redirect()
                ->route('ams.customers.index')
                ->with('success', 'Customer created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating customer: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error creating customer: ' . $e->getMessage());
        }
    }

    public function show($customerId)
    {
        try {
            // Get customer with direct DB query using mysql_second connection
            $customer = DB::connection('mysql_second')->table('customers')
                ->where('id', $customerId)
                ->first();
            
            if (!$customer) {
                return redirect()->route('ams.customers.index')
                    ->with('error', 'Customer not found');
            }
            
            // Get customer addresses with direct DB query using mysql_second connection
            $addresses = DB::connection('mysql_second')->table('cust_addresses')
                ->where('cust_id_fk', $customerId)
                ->orWhere('customers_id', $customerId)
                ->get();
                
            // Get customer billing info with direct DB query using mysql_second connection
            $billingInfo = DB::connection('mysql_second')->table('cust_billing')
                ->where('cust_id_fk', $customerId)
                ->orWhere('customers_id', $customerId)
                ->get();
                
            // Create empty collection for orders
            $orders = collect([]);
            
            return view('ams.customers.view', compact('customer', 'addresses', 'billingInfo', 'orders'));
        } catch (\Exception $e) {
            Log::error('Error viewing customer: ' . $e->getMessage());
            return redirect()->route('ams.customers.index')
                ->with('error', 'Error viewing customer: ' . $e->getMessage());
        }
    }

    public function edit($customerId)
    {
        try {
            // Get customer with direct DB query using mysql_second connection
            $customer = DB::connection('mysql_second')->table('customers')
                ->where('id', $customerId)
                ->first();
            
            if (!$customer) {
                return redirect()->route('ams.customers.index')
                    ->with('error', 'Customer not found');
            }
            
            // Get customer addresses with direct DB query using mysql_second connection
            $addresses = DB::connection('mysql_second')->table('cust_addresses')
                ->where('cust_id_fk', $customerId)
                ->orWhere('customers_id', $customerId)
                ->get();
                
            // Get customer billing info with direct DB query using mysql_second connection
            $billingInfo = DB::connection('mysql_second')->table('cust_billing')
                ->where('cust_id_fk', $customerId)
                ->orWhere('customers_id', $customerId)
                ->get();
            
            return view('ams.customers.edit', compact('customer', 'addresses', 'billingInfo'));
        } catch (\Exception $e) {
            Log::error('Error editing customer: ' . $e->getMessage());
            return redirect()->route('ams.customers.index')
                ->with('error', 'Error editing customer: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $customerId)
    {
        $request->validate([
            'name' => 'required|string|max:128',
            'company' => 'nullable|string|max:128',
            'contact' => 'nullable|string|max:128',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:32',
            'phone_alt' => 'nullable|string|max:32',
            'alt_phone' => 'nullable|string|max:32',
            'ext' => 'nullable|string|max:13',
            'fax' => 'nullable|string|max:32',
        ]);

        try {
            // Update customer with direct DB query using mysql_second connection
            DB::connection('mysql_second')->table('customers')
                ->where('id', $customerId)
                ->update([
                    'name' => $request->name,
                    'company' => $request->company,
                    'contact' => $request->contact,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'phone_alt' => $request->phone_alt,
                    'alt_phone' => $request->alt_phone,
                    'ext' => $request->ext,
                    'fax' => $request->fax,
                    'modified' => now(),
                    'mod_by' => auth()->id() ?? 1
                ]);

            return redirect()
                ->route('ams.customers.index')
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating customer: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error updating customer: ' . $e->getMessage());
        }
    }
}