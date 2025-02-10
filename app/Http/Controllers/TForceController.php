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
            'recipient_address' => 'required|string',
            'recipient_city' => 'required|string',
            'recipient_state' => 'required|string',
            'recipient_postal' => 'required|string',
            'packages' => 'required|array',
            'packages.*.weight' => 'required|numeric',
            'packages.*.dimensions.length' => 'required|numeric',
            'packages.*.dimensions.width' => 'required|numeric',
            'packages.*.dimensions.height' => 'required|numeric',
        ]);

        $rates = $this->authService->getRates($validated);

        return response()->json($rates);
    }
}
