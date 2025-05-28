<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UPSService;

class UPSController extends Controller
{
    protected $upsService;

    public function __construct(UPSService $upsService)
    {
        $this->upsService = $upsService;
    }

    public function getRates(Request $request)
    {
        // $validated = $request->validate([
        //     'origin.address' => 'required|string',
        //     'origin.city' => 'required|string',
        //     'origin.state' => 'required|string|max:2',
        //     'origin.postal' => 'required|string|max:5',
        //     'destination.address' => 'required|string',
        //     'destination.city' => 'required|string',
        //     'destination.state' => 'required|string|max:2',
        //     'destination.postal' => 'required|string|max:5',
        //     'packages' => 'required|array',
        //     'packages.*.weight' => 'required|numeric',
        //     'packages.*.dimensions.length' => 'required|numeric',
        //     'packages.*.dimensions.width' => 'required|numeric',
        //     'packages.*.dimensions.height' => 'required|numeric',
        // ]);
        //Insrt dummy data for testing
        $validated['origin'] = [
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'NJ',
            'postal' => '07050'
        ];
        $validated['destination'] = [
            'address' => '456 Elm St',
            'city' => 'East Orange',
            'state' => 'NJ',
            'postal' => '07018'
        ];
        $validated['packages'] = [
            [
                'weight' => 10,
                'dimensions' => [
                    'length' => 12,
                    'width' => 8,
                    'height' => 6
                ]
            ],
            [
                'weight' => 5,
                'dimensions' => [
                    'length' => 10,
                    'width' => 6,
                    'height' => 4
                ]
            ]
        ];
        $rates = $this->upsService->getRates(
            $validated['origin'],
            $validated['destination'],
            $validated['packages']
        );

        return response()->json($rates);
    }
}