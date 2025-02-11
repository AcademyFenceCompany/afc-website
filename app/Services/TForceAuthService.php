<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
            
            // Build the request payload
            $payload = [
                "requestOptions" => [
                    "serviceCode" => "308",
                    "pickupDate" => date('Y-m-d'),
                    "type" => "L",
                    "densityEligible" => true,
                    "timeInTransit" => true,
                    "quoteNumber" => true,
                    "customerContext" => "Checkout API",
                    "accessorials" => [
                        "LIFTG" => true,  // Lift gate delivery
                        "RESD" => true,   // Residential delivery
                    ],
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
                        "residential" => true
                    ],
                ],
                "payment" => [
                    "payer" => [
                        "type" => "S",
                        "accountNumber" => config('tforce.account_number'),
                        "address" => [
                            "city" => config('shipper.city'),
                            "stateProvinceCode" => config('shipper.state'),
                            "postalCode" => config('shipper.zip'),
                            "country" => "US",
                        ]
                    ],
                    "billingCode" => "10",
                ],
                "serviceOptions" => [
                    "delivery" => [
                        "LIFD", // Lift Gate Delivery
                        "RESD"  // Inside Delivery
                    ]
                ],
                "commodities" => array_map(function ($package) {
                    // Calculate density for proper freight class
                    $volume = ($package['dimensions']['length'] * $package['dimensions']['width'] * $package['dimensions']['height']) / 1728;
                    $density = $package['weight'] / $volume;
                    
                    // Determine freight class based on density
                    $freightClass = $this->getFreightClassByDensity($density);
                    
                    // Log the density calculation
                    Log::channel('daily')->info('Package density calculation', [
                        'dimensions' => $package['dimensions'],
                        'weight' => $package['weight'],
                        'volume' => $volume,
                        'density' => $density,
                        'freightClass' => $freightClass
                    ]);
                    
                    return [
                        "handlingUnits" => 1,
                        "pieces" => 1,
                        "weight" => [
                            "weight" => (int) $package['weight'],
                            "weightUnit" => "LBS"
                        ],
                        "dimensions" => [
                            "length" => (int) $package['dimensions']['length'],
                            "width" => (int) $package['dimensions']['width'],
                            "height" => (int) $package['dimensions']['height'],
                            "unit" => "IN",
                        ],
                        "class" => $freightClass,
                        "packagingType" => "BOX",
                    ];
                }, $requestData['packages']),
            ];

            // Log request
            Log::channel('daily')->info('TForce Request', [
                'payload' => $payload,
                'url' => "https://api.tforcefreight.com/rating/getRate?api-version=v1"
            ]);

            $response = $client->post("https://api.tforcefreight.com/rating/getRate?api-version=v1", [
                'headers' => [
                    'Authorization' => "Bearer $accessToken",
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $responseData = json_decode($response->getBody(), true);
            
            // Log response
            Log::channel('daily')->info('TForce Response', [
                'data' => $responseData
            ]);

            return $responseData;
        } catch (RequestException $e) {
            $errorResponse = '';
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                if ($response) {
                    $errorResponse = $response->getBody()->getContents();
                }
            }
            
            // Log error
            Log::channel('daily')->error('TForce API Error', [
                'error' => $e->getMessage(),
                'response' => $errorResponse,
                'request' => $requestData,
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'error' => 'Unable to fetch rates from TForce API. ' . $e->getMessage(),
                'details' => $errorResponse
            ];
        }
    }

    /**
     * Determine freight class based on density
     *
     * @param float $density Density in pounds per cubic foot
     * @return string Freight class
     */
    private function getFreightClassByDensity($density)
    {
        // Valid TForce freight classes
        $validClasses = [
            '50', '55', '60', '65', '70', '77.5', '85', '92.5',
            '100', '110', '125', '150', '175', '200', '250', '300', '400', '500'
        ];

        // Freight class determination based on density
        $class = '500'; // Default to highest class
        
        if ($density >= 50) $class = '50';
        elseif ($density >= 35) $class = '55';
        elseif ($density >= 30) $class = '60';
        elseif ($density >= 22.5) $class = '65';
        elseif ($density >= 15) $class = '70';
        elseif ($density >= 13.5) $class = '77.5';
        elseif ($density >= 12) $class = '85';
        elseif ($density >= 10.5) $class = '92.5';
        elseif ($density >= 9) $class = '100';
        elseif ($density >= 8) $class = '110';
        elseif ($density >= 7) $class = '125';
        elseif ($density >= 6) $class = '150';
        elseif ($density >= 5) $class = '175';
        elseif ($density >= 4) $class = '200';
        elseif ($density >= 3) $class = '250';
        elseif ($density >= 2) $class = '300';
        elseif ($density >= 1) $class = '400';

        // Ensure we're returning a valid class
        if (!in_array($class, $validClasses)) {
            $class = '500'; // Default to highest class if something goes wrong
        }

        return $class;
    }
}
