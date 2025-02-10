<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RLCarriersService;

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
            'origin_city' => 'required|string',
            'origin_state' => 'required|string|max:2',
            'origin_zip' => 'required|string|max:5',
            'destination_city' => 'required|string',
            'destination_state' => 'required|string|max:2',
            'destination_zip' => 'required|string|max:5',
            'packages' => 'required|array',
            'packages.*.weight' => 'required|numeric',
            'packages.*.width' => 'required|numeric',
            'packages.*.height' => 'required|numeric',
            'packages.*.length' => 'required|numeric',
        ]);

        $rates = $this->rlCarriersService->getRates($validated);

        return response()->json($rates);
    }
}
