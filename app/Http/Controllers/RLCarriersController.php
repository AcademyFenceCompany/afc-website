<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RLCarriersService;
use Illuminate\Support\Facades\Log;

class RLCarriersController extends Controller
{
    protected $rlCarriersService;

    public function __construct(RLCarriersService $rlCarriersService)
    {
        $this->rlCarriersService = $rlCarriersService;
    }

    /**
     * Fetch shipping rates from R&L Carriers API.
     */
    public function getRates(Request $request)
    {
        $validated = $request->validate([
            'recipient_address' => 'required|string',
            'recipient_city' => 'required|string',
            'recipient_state' => 'required|string|max:2',
            'recipient_postal' => 'required|string|max:5',
            'packages' => 'required|array',
            'packages.*.weight' => 'required|numeric',
            'packages.*.dimensions.width' => 'required|numeric',
            'packages.*.dimensions.height' => 'required|numeric',
            'packages.*.dimensions.length' => 'required|numeric',
        ]);

        // Transform the data to match service expectations
        $serviceData = [
            'origin_city' => 'Orange',
            'origin_state' => 'NJ',
            'origin_zip' => '07050',
            'destination_city' => $validated['recipient_city'],
            'destination_state' => $validated['recipient_state'],
            'destination_zip' => $validated['recipient_postal'],
            'packages' => array_map(function($package) {
                return [
                    'weight' => $package['weight'],
                    'dimensions' => [
                        'length' => $package['dimensions']['length'],
                        'width' => $package['dimensions']['width'],
                        'height' => $package['dimensions']['height']
                    ]
                ];
            }, $validated['packages'])
        ];

        Log::info('Transformed data for R&L:', ['data' => $serviceData]);

        $rates = $this->rlCarriersService->getRates($serviceData);

        return response()->json($rates);
    }
}
