<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TForceService
{
    private $client;
    private $accessToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.tforcefreight.com', // Confirm this URL
            'timeout' => 30, // Timeout in seconds
        ]);

        // Set the access token from environment
        $this->accessToken = env('TFORCE_ACCESS_TOKEN');

        if (!$this->accessToken) {
            throw new \Exception('TForce Access Token not found. Ensure it is set in the .env file.');
        }
    }

    /**
     * Get Shipping Rates from TForce API
     */
    public function getShippingRates(array $requestData)
    {
        try {
            // Prepare the payload
            $payload = [
                'origin' => [
                    'zipCode' => $requestData['origin_zip'],
                    'countryCode' => 'US',
                ],
                'destination' => [
                    'zipCode' => $requestData['destination_zip'],
                    'countryCode' => 'US',
                ],
                'weight' => [
                    'value' => $requestData['weight'], // Assuming weight is numeric
                    'unit' => 'LBS', // Hardcoded unit
                ],
                'dimensions' => [
                    'length' => [
                        'value' => $requestData['dimensions']['length'],
                        'unit' => 'IN',
                    ],
                    'width' => [
                        'value' => $requestData['dimensions']['width'],
                        'unit' => 'IN',
                    ],
                    'height' => [
                        'value' => $requestData['dimensions']['height'],
                        'unit' => 'IN',
                    ],
                ],
            ];

            Log::info('Sending request to TForce API', ['payload' => $payload]);

            // Send request to TForce API
            $response = $this->client->post('/rating/getRate?api-version=v1', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            // Parse response
            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('Received response from TForce API', ['response' => $responseData]);

            return $responseData;
        } catch (\Exception $e) {
            Log::error('TForce API Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['error' => 'Unable to fetch rates from TForce API. Please try again later.'];
        }
    }
}
