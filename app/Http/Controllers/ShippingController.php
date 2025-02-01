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
        ]);
    
        $rates = $this->upsService->getShippingRates($validated);
    
        if (isset($rates['error'])) {
            return response()->json(['error' => $rates['error']], 400);
        }
    
        return response()->json($rates);
    }
}
