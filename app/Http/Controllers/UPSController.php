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
        $validated = $request->validate([
            'origin.address' => 'required|string',
            'origin.city' => 'required|string',
            'origin.state' => 'required|string|max:2',
            'origin.postal' => 'required|string|max:5',
            'destination.address' => 'required|string',
            'destination.city' => 'required|string',
            'destination.state' => 'required|string|max:2',
            'destination.postal' => 'required|string|max:5',
            'packages' => 'required|array',
            'packages.*.weight' => 'required|numeric',
            'packages.*.dimensions.length' => 'required|numeric',
            'packages.*.dimensions.width' => 'required|numeric',
            'packages.*.dimensions.height' => 'required|numeric',
        ]);

        $rates = $this->upsService->getRates(
            $validated['origin'],
            $validated['destination'],
            $validated['packages']
        );

        return response()->json($rates);
    }
}