<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class TForceAuthService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 10]);
    }

    /**
     * Get the access token, either from cache or by requesting a new one.
     *
     * @return string
     * @throws \Exception
     */
    public function getAccessToken()
    {
        // Check if a valid token is already cached
        if (Cache::has('tforce_access_token')) {
            return Cache::get('tforce_access_token');
        }

        // Otherwise, request a new token
        $response = $this->requestNewToken();

        // Extract the token and expiration
        $accessToken = $response['access_token'];
        $expiresIn = $response['expires_in'];

        // Cache the token with an expiration buffer
        Cache::put('tforce_access_token', $accessToken, now()->addSeconds($expiresIn - 60));

        return $accessToken;
    }

    /**
     * Request a new access token from the TForce OAuth endpoint.
     *
     * @return array
     * @throws \Exception
     */
    private function requestNewToken()
    {
        try {
            $response = $this->client->post(env('TFORCE_TOKEN_URL'), [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => env('TFORCE_CLIENT_ID'),
                    'client_secret' => env('TFORCE_CLIENT_SECRET'),
                    'scope' => env('TFORCE_SCOPE'),
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw new \Exception('Failed to retrieve access token: ' . $e->getMessage());
        }
    }
    public function getRates(array $requestData)
{
    try {
        $accessToken = $this->getAccessToken(); // Retrieve the valid access token

        $client = new Client();
        $response = $client->post("https://api.tforcefreight.com/rating/getRate?api-version=v1", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "requestOptions" => [
                    "serviceCode" => "308",
                    "pickupDate" => date('Y-m-d'), // Ensure correct date format
                    "type" => "L",
                    "densityEligible" => false,
                    "timeInTransit" => true,
                    "quoteNumber" => true,
                    "customerContext" => "Checkout API",
                ],
                "shipFrom" => [
                    "address" => [
                        "city" => config('shipper.city'),
                        "stateProvinceCode" => config('shipper.state'),
                        "postalCode" => config('shipper.zip'),
                        "country" => "US",
                    ],
                ],
                "shipTo" => [
                    "address" => [
                        "city" => $requestData['recipient_city'],
                        "stateProvinceCode" => $requestData['recipient_state'],
                        "postalCode" => $requestData['recipient_postal'],
                        "country" => "US",
                    ],
                ],
                "payment" => [
                    "payer" => [
                        "address" => [
                            "city" => config('shipper.city'),
                            "stateProvinceCode" => config('shipper.state'),
                            "postalCode" => config('shipper.zip'),
                            "country" => "US",
                        ],
                    ],
                    "billingCode" => "30",
                ],
                "serviceOptions" => [
                    "pickup" => ["INPU", "LIFO"],
                    "delivery" => ["INDE", "LIFD"],
                ],
                "commodities" => array_map(function ($package) {
                    return [
                        "class" => "100", // Ensure the freight class is valid
                        "pieces" => 1, // Ensure each package has a valid piece count
                        "weight" => [
                            "weight" => (int) $package['weight'], // Ensure weight is an integer
                            "weightUnit" => "LBS",
                        ],
                        "packagingType" => "BOX",
                        "dimensions" => [
                            "length" => (int) $package['dimensions']['length'], // Ensure integer values
                            "width" => (int) $package['dimensions']['width'],
                            "height" => (int) $package['dimensions']['height'],
                            "unit" => "IN",
                        ],
                    ];
                }, $requestData['packages']),
            ],
        ]);

        return json_decode($response->getBody(), true);
    } catch (\Exception $e) {
        return [
            'error' => 'Unable to fetch rates from TForce API. ' . $e->getMessage(),
        ];
    }
        
        \Log::info('tforce Request:', ['request' => $requestData]);
        \Log::info('tforce Response:', ['response' => $response->json()]);

}

}
