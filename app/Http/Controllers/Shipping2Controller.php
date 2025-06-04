<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping2;

class Shipping2Controller extends Controller
{
    // This method returns a view of the shipping rates page
    public function index()
    {
        // You can return a view here if needed
        // return view('shipping2.index');
        return view('ams.shipping-module', [
            'title' => 'Shipping Rates',
            'description' => 'Get shipping rates for your packages.',
        ]);
    }
    //This method will handle the shipping rates retrieval
    public function getShippingRates(Request $request)
    {

        // $validatedOld = $request->validate([
        //     'recipient_address' => 'required|string',
        //     'recipient_city' => 'required|string',
        //     'recipient_state' => 'required|string|max:2',
        //     'recipient_postal' => 'required|string|max:5',
        //     'packages' => 'required|array',
        //     'packages.*.weight' => 'required|numeric',
        //     'packages.*.dimensions.width' => 'required|numeric',
        //     'packages.*.dimensions.height' => 'required|numeric',
        //     'packages.*.dimensions.length' => 'required|numeric',
        //     'category_ids' => 'sometimes|array', // Add validation for category_ids
        // ]);
        // Create dummy data for testing
        // Prepare data in the format expected by UPS Shipping Rates API
        $validated = [
            'recipient_address' => '78 Elmwood Ave',
            'recipient_city' => 'East Orange',
            'recipient_state' => 'NJ',
            'recipient_postal' => '07018',
            'packages' => [
                [
                    'weight' => 105,
                    'dimensions' => [
                        'length' => 16,
                        'width' => 49,
                        'height' => 16,
                    ],
                ],
                [
                    'weight' => 105,
                    'dimensions' => [
                        'length' => 16,
                        'width' => 49,
                        'height' => 16,
                    ],
                ],
                [
                    'weight' => 105,
                    'dimensions' => [
                        'length' => 16,
                        'width' => 49,
                        'height' => 16,
                    ],
                ],
                [
                    'weight' => 105,
                    'dimensions' => [
                        'length' => 16,
                        'width' => 49,
                        'height' => 16,
                    ],
                ],
                [
                    'weight' => 105,
                    'dimensions' => [
                        'length' => 16,
                        'width' => 49,
                        'height' => 16,
                    ],
                ]
            ],
            // Add category_ids if needed
        ];
        $rates = [];
        // Here you would call the appropriate service to get the rates
        $shippingMODEL = new Shipping2();
        // Use UPS when weight is less than 150 lbs
        // Calculate total weight of all packages
        $totalWeight = 0;
        if (isset($validated['packages']) && is_array($validated['packages'])) {
            foreach ($validated['packages'] as $package) {
                if (isset($package['weight'])) {
                    $totalWeight += $package['weight'];
                }
            }
        }
        $upsrates = $shippingMODEL->getUPSShippingRates($validated); //To Be Implemented

        if(!isset($upsrates['error'])) {
            
            // Extract Weight and TotalCharges MonetaryValue from UPS API response
            $rateResponse = $upsrates['RateResponse'] ?? [];
            $ratedShipments = $rateResponse['RatedShipment'] ?? [];

            $upsRatesList = [];
            foreach ($ratedShipments as $shipment) {
                $weight = $shipment['BillingWeight']['Weight'] ?? null;
                $totalCost = $shipment['TotalCharges']['MonetaryValue'] ?? null;
                $serviceCode = $shipment['Service']['Code'] ?? null;
                $serviceDescription = $shipment['Service']['Description'] ?? null;

                $upsRatesList[] = [
                    'service_code' => $serviceCode,
                    'service_description' => $serviceDescription,
                    'weight' => $weight,
                    'total_cost' => $totalCost,
                ];
            }

            $rates['ups'] = $upsRatesList;
        }
        @dd($upsrates);
        if ($totalWeight < 150) {
            //$upsrates = $shippingMODEL->getUPSShippingRates($validated); //To Be Implemented
            // For now, let's simulate UPS rates
            // $upsrates = [
            //     'rates' => [
            //         'ground' => 15.99,
            //         '2nd_day_air' => 25.99,
            //         'next_day_air' => 45.99,
            //     ],
            //     'total_weight' => $totalWeight,
            //     'currency' => 'USD',
            // ];
        } else {
            // If total weight is 150 lbs or more, use TForce
            $upsrates = [
                'error' => 'Total weight exceeds 150 lbs, please use TForce for shipping rates.'
            ];
        }
        
        //Get TForce rates
        $tForceRates = $shippingMODEL->getTForceShippingRates($validated);
        if (!isset($tForceRates['error'])) {
            $rates['tforce'] = $tForceRates;
        }

        // Get R&L Carriers rates
        $rlCarriersRates = $shippingMODEL->getRLCarriersShippingRates($validated);
        
        if (isset($upsrates['error'])) {
            return response()->json(['error' => $upsrates['error']], 400);
        }
        // Add shipper information to the response
        return response()->json($upsrates);
    }
}
