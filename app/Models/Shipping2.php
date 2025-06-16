<?php

namespace App\Models;

use App\Services\TForceAuthService;
use App\Services\UPSService;
use App\Services\RLCarriersService;
use Illuminate\Support\Facades\Log;

class Shipping2{
    protected $upsService;
    protected $tForceAuthService;
    protected $rlCarriersService;

    public function __construct()
    {
        $this->upsService = new UPSService();
        $this->tForceAuthService = new TForceAuthService();
        $this->rlCarriersService = new RLCarriersService();
    }

    //This method will handle UPS shipping rates
    public function getUPSShippingRates($validated): array
    {
        // Check if any product is from category_id=82 : Wood Post Caps
        $hasCategory82 = false;
        if (isset($validated['category_ids']) && is_array($validated['category_ids'])) {
            $hasCategory82 = in_array(82, $validated['category_ids']);
        }

        // Pass the category information to the UPS service
        $validated['use_alternative_shipper'] = $hasCategory82;
        
        $rates = $this->upsService->getShippingRates($validated);
    
        if (isset($rates['error'])) {
            return ['error' => $rates['error']];
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
        return $response;
    }
    // This method will handle TForce shipping rates
    public function getTForceShippingRates($validated): array
    {
        $rates = $this->tForceAuthService->getRates($validated);

        if (isset($rates['error'])) {
            return ['error' => $rates['error']];
        }

        // Add shipper information to the response
        $shipperInfo = [
            'name' => config('shipper.name'),
            'address' => config('shipper.address'),
            'city' => config('shipper.city'),
            'state' => config('shipper.state'),
            'zip' => config('shipper.zip'),
            'phone' => config('shipper.phone'),
            'email' => config('shipper.email'),
        ];

        // Merge the shipper info with the rates response
        $response = array_merge($rates);
        return $response;
    }
    // This method will handle R&L Carriers shipping rates
    public function getRLCarriersShippingRates($validated): array
    {
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

        if (isset($rates['error'])) {
            return ['error' => $rates['error']];
        }

        // Add shipper information to the response
        $shipperInfo = [
            'name' => config('shipper.name'),
            'address' => config('shipper.address'),
            'city' => config('shipper.city'),
            'state' => config('shipper.state'),
            'zip' => config('shipper.zip'),
            'phone' => config('shipper.phone'),
            'email' => config('shipper.email'),
        ];

        // Merge the shipper info with the rates response
        $response = array_merge($rates);
        return $response;
    }
    // Calculate Final Cost
    public function calculateFinalCost($cart, $shippingRate): float
    {
        // Calculate subtotal
        $subtotal = array_sum(array_column($cart, 'total'));
        $tax = $subtotal * 0.06625; // NJ tax rate
        $total = $subtotal + $tax + $shippingRate;

        return round($total, 2);
    }
    // Prepare Shipping Data
    public function prepareShippingData($cart): array
    {
        $packages = [];
        foreach ($cart as $item) {
            $packages[] = [
                'weight' => $item['weight'],
                'dimensions' => [
                    'length' => $item['length'],
                    'width' => $item['width'],
                    'height' => $item['height'],
                ],
            ];
        }
        return $packages;
    }

}