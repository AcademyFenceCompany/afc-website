<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RLShippingService
{
    private $client;
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => true, // Ensure SSL verification
        ]);

        $this->apiUrl = config('services.rl.api_url'); // Load from config
        $this->apiKey = config('services.rl.api_key'); // Load from config
    }

    /**
     * Fetch shipping rates from R&L API.
     *
     * @param array $payload
     * @return array
     */
    public function getRates(array $payload): array
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'APIKey' => $this->apiKey,
                ],
                'json' => $payload,
            ]);

            return json_decode($response->getBody()->getContents(), true);

        } catch (\Exception $e) {
            Log::error('R&L Shipping API Error', [
                'message' => $e->getMessage(),
            ]);

            return ['error' => 'Unable to fetch rates from R&L API.'];
        }
    }
}
