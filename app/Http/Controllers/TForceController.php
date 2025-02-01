<?php

namespace App\Http\Controllers;

use App\Services\TForceAuthService;
use Illuminate\Http\Request;

class TForceController extends Controller
{
    protected $authService;

    public function __construct(TForceAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getRate(Request $request)
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
        ]);

        $rates = $this->authService->getRates($validated);

        return response()->json($rates);
    }
}
