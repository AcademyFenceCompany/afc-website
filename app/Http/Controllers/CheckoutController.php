<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UPSFreightService;
use Exception;

class CheckoutController extends Controller
{
    private $upsFreightService;

    /**
     * Constructor to inject the UPSFreightService.
     */
    public function __construct(UPSFreightService $upsFreightService)
    {
        $this->upsFreightService = $upsFreightService;
    }

    /**
     * Displays the checkout page.
     */
    public function index(Request $request)
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_column($cart, 'total'));

        // Determine the tax based on state
        $state = $request->input('state', 'Other'); // Default state is 'Other'
        $tax = 0;

        if ($state === 'New Jersey') {
            $tax = $subtotal * 0.06625; // 6.625% tax for New Jersey
        }

        $total = $subtotal + $tax;

        return view('cart.checkout', compact('cart', 'subtotal', 'tax', 'total', 'state'));
    }

    /**
     * Calculates the shipping cost using UPS API.
     */
    public function calculateShippingCost(Request $request)
    {
        $validatedData = $request->validate([
            'zip' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
        ]);

        $shipmentData = [
            'Shipment' => [
                'Shipper' => [
                    'Address' => [
                        'PostalCode' => '07050', // Your business origin ZIP
                        'CountryCode' => 'US',
                    ],
                ],
                'ShipTo' => [
                    'Address' => [
                        'PostalCode' => $validatedData['zip'],
                        'CountryCode' => 'US',
                    ],
                ],
                'Package' => [
                    [
                        'PackagingType' => ['Code' => '02'], // Customer Supplied Package
                        'Dimensions' => [
                            'UnitOfMeasurement' => ['Code' => 'IN'],
                            'Length' => '10', // Example dimensions
                            'Width' => '10',
                            'Height' => '10',
                        ],
                        'PackageWeight' => [
                            'UnitOfMeasurement' => ['Code' => 'LBS'],
                            'Weight' => '5', // Example weight
                        ],
                    ],
                ],
            ],
        ];

        try {
            // Call UPSFreightService to get the freight rate
            $response = $this->upsFreightService->getFreightRate($shipmentData);

            if (!empty($response)) {
                return response()->json(['success' => true, 'data' => $response]);
            } else {
                throw new Exception('Invalid response from UPS API.');
            }
        } catch (Exception $e) {
            \Log::error('Error fetching shipping rates: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch shipping rates. Please try again later.'], 500);
        }
    }

    /**
     * Handles UPS API callbacks.
     */
    public function handleCallback(Request $request)
    {
        \Log::info('UPS Callback Data:', $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Callback received successfully.',
        ]);
    }
}
