<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping2;
use App\Models\ShoppingCart;

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
        // Here you would call the appropriate service to get the rates
        $shippingMODEL = new Shipping2();
        $cart = new ShoppingCart();
        $cartData = $cart->getCart();
        // $formDataOld = $request->validate([
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
        $formData = [
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
        $formData['packages'] = $shippingMODEL->prepareShippingData($cartData['items']);
        
        $rates = [];
        $upsrates = [];
        $tForceRates = [];
        $rlCarriersRates = [];

        // Use UPS when weight is less than 150 lbs
        // Calculate total weight of all packages
        $totalWeight = 160;
        if (isset($formData['packages']) && is_array($formData['packages'])) {
            foreach ($formData['packages'] as $package) {
                if (isset($package['weight'])) {
                    $totalWeight += $package['weight'];
                }
            }
        }

        // If total weight is less than or equal to 150 lbs, use UPS
        if ($totalWeight < 150) {
            $upsrates = $shippingMODEL->getUPSShippingRates($formData); //To Be Implemented
            // Check if the UPS API response contains an error
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
        } else {
            // If total weight is 150 lbs or more, use TForce
            $upsrates = [
                'error' => 'Total weight exceeds 150 lbs, please use Freight for shipping rates.'
            ];
            //Get TForce rates
            $tForceRates = $shippingMODEL->getTForceShippingRates($formData);
            if (!isset($tForceRates['error'])) {
                $rates['tforce'] = $tForceRates;
            }

            // Get R&L Carriers rates
            $rlCarriersRates = $shippingMODEL->getRLCarriersShippingRates($formData);
            if (!isset($rlCarriersRates['error'])) {
                $rates['rl_carriers'] = $rlCarriersRates;
            }
        }
        
        // This is where you return the lowest rate
        //$lowestUpsRate = $this->getLowestUPSRate($rates['ups'] ?? []); //Get the lowest UPS rate
        //@dd($tForceRates, $rlCarriersRates);
        return view('components.cart-shipping-insert', [
            //'upsrates' => $lowestUpsRate,
            'tForceRates' => $tForceRates,
            'rlCarriersRates' => $rlCarriersRates,
            'packages' => $formData['packages'],
        ]);
        // Add shipper information to the response
        return response()->json($upsrates);
    }
    //This method will handle the shipping rates retrieval
    public function getShippingRatesAMS(Request $request)
    {
        return view('components.cart-shipping-insert', [
            //'upsrates' => $lowestUpsRate,
            'tForceRates' =>'',
            'rlCarriersRates' => '',
            'packages' => '',
        ]);
        // Here you would call the appropriate service to get the rates
        $shippingMODEL = new Shipping2();
        $cart = new ShoppingCart();
        $cartData = $cart->getCart();
        // $formDataOld = $request->validate([
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
        $formData = [
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
        $formData['packages'] = $shippingMODEL->prepareShippingData($cartData['items']);
        
        $rates = [];
        $upsrates = [];
        $tForceRates = [];
        $rlCarriersRates = [];

        // Use UPS when weight is less than 150 lbs
        // Calculate total weight of all packages
        $totalWeight = 160;
        if (isset($formData['packages']) && is_array($formData['packages'])) {
            foreach ($formData['packages'] as $package) {
                if (isset($package['weight'])) {
                    $totalWeight += $package['weight'];
                }
            }
        }

        // If total weight is less than or equal to 150 lbs, use UPS
        if ($totalWeight < 150) {
            $upsrates = $shippingMODEL->getUPSShippingRates($formData); //To Be Implemented
            // Check if the UPS API response contains an error
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
        } else {
            // If total weight is 150 lbs or more, use TForce
            $upsrates = [
                'error' => 'Total weight exceeds 150 lbs, please use Freight for shipping rates.'
            ];
            //Get TForce rates
            $tForceRates = $shippingMODEL->getTForceShippingRates($formData);
            if (!isset($tForceRates['error'])) {
                $rates['tforce'] = $tForceRates;
            }

            // Get R&L Carriers rates
            $rlCarriersRates = $shippingMODEL->getRLCarriersShippingRates($formData);
            if (!isset($rlCarriersRates['error'])) {
                $rates['rl_carriers'] = $rlCarriersRates;
            }
        }
        
        // This is where you return the lowest rate
        //$lowestUpsRate = $this->getLowestUPSRate($rates['ups'] ?? []); //Get the lowest UPS rate
        //@dd($tForceRates, $rlCarriersRates);
        return view('components.cart-shipping-insert', [
            //'upsrates' => $lowestUpsRate,
            'tForceRates' => $tForceRates,
            'rlCarriersRates' => $rlCarriersRates,
            'packages' => $formData['packages'],
        ]);
        // Add shipper information to the response
        return response()->json($upsrates);
    }
    // This method is used to get the lowest shipping rate
    public function getLowestUPSRate($rates)
    {
        if (empty($rates) || !is_array($rates)) {
            return null;
        }

        $lowest = null;
        foreach ($rates as $rate) {
            if (!isset($rate['total_cost'])) {
                continue;
            }
            $cost = floatval($rate['total_cost']);
            if ($lowest === null || $cost < floatval($lowest['total_cost'])) {
                $lowest = $rate;
            }
        }
        return $lowest;
    }
}
