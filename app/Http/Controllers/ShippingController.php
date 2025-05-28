<?php

namespace App\Http\Controllers;

use App\Services\TForceService;
use App\Services\UPSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    private $upsService;

    public function __construct(UPSService $upsService)
    {
        $this->upsService = $upsService;
    }

    public function getShippingRates(Request $request)
    {
        $validated = $request->validate([
            // 'shipper_address' => 'required|string',
            // 'shipper_city' => 'required|string',
            // 'shipper_state' => 'required|string',
            // 'shipper_postal' => 'required|string',
            'recipient_address' => 'required|string',
            'recipient_city' => 'required|string',
            'recipient_state' => 'required|string',
            'recipient_postal' => 'required|string',
            'packages' => 'required|array',
            'packages.*.weight' => 'required|numeric|max:150', // Validate max weight
            'packages.*.dimensions.length' => 'required|numeric',
            'packages.*.dimensions.width' => 'required|numeric',
            'packages.*.dimensions.height' => 'required|numeric',
            'category_ids' => 'sometimes|array', // Add validation for category_ids
        ]);

        // Check if any product is from category_id=82 : Wood Post Caps
        $hasCategory82 = false;
        if (isset($validated['category_ids']) && is_array($validated['category_ids'])) {
            $hasCategory82 = in_array(82, $validated['category_ids']);
        }

        // Pass the category information to the UPS service
        $validated['use_alternative_shipper'] = $hasCategory82;
        
        $rates = $this->upsService->getShippingRates($validated);
    
        if (isset($rates['error'])) {
            return response()->json(['error' => $rates['error']], 400);
        }
        
        // Add shipper information to the response
        // Use alternative shipper info if category 82 is present
        if ($hasCategory82 && config('alternative_shipper.category_82')) {
            $shipperInfo = [
                'name' => config('alternative_shipper.category_82.name'),
                'address' => config('alternative_shipper.category_82.address'),
                'city' => config('alternative_shipper.category_82.city'),
                'state' => config('alternative_shipper.category_82.state'),
                'zip' => config('alternative_shipper.category_82.zip'),
            ];
        } else {
            $shipperInfo = [
                'name' => config('shipper.name'),
                'address' => config('shipper.address'),
                'city' => config('shipper.city'),
                'state' => config('shipper.state'),
                'zip' => config('shipper.zip'),
                'phone' => config('shipper.phone'),
                'email' => config('shipper.email'),
            ];
        }
        
        // Merge the shipper info with the rates response
        $response = array_merge(['shipper' => $shipperInfo], $rates);
    
        return response()->json($response);
    }
}
