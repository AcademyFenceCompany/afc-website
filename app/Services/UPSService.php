<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class UPSService
{
    private $client;
    private $baseUrl;
    private $clientId;
    private $clientSecret;
    private $shipperNumber;
    public $accessToken;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 30]);
        $this->baseUrl = config('services.ups.base_url', env('UPS_API_BASE_URL'));
        $this->clientId = env('UPS_CLIENT_ID');
        $this->clientSecret = env('UPS_CLIENT_SECRET');
        $this->shipperNumber = env('UPS_SHIPPER_NUMBER');
        $this->authenticate();

    }
    /**
     * Authenticate and retrieve OAuth token.
     */
    public function authenticate()
    {
       
        try {
            $response = $this->client->post("{$this->baseUrl}/security/v1/oauth/token", [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'auth' => [$this->clientId, $this->clientSecret],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->accessToken = $data['access_token'];
            session()->put('ups_access_token', $this->accessToken);
            Log::info('UPS OAuth Token Retrieved', ['token' => $this->accessToken]);
            return $this->accessToken;
        } catch (\Exception $e) {
            Log::error('UPS OAuth Error', ['message' => $e->getMessage()]);
            session()->put('ups_access_token', null); // Clear the session token on failure
            return null;
            
        }
       
    }
    /**
     * Authenticate with UPS API using retries.
     *
     * @return string|null
     * @throws \Exception
     */
    public function authenticate2()
    {
        // Check if access token exists and is valid
        $accessToken = session()->get('ups_access_token');
        @dump($accessToken);
        if (!empty($accessToken)) {
            try {
                $response = $this->client->get("{$this->baseUrl}/security/v1/token/details", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ],
                ]);
                if ($response->getStatusCode() === 200) {
                    $this->accessToken = $accessToken;
                    return $this->accessToken;
                }
            } catch (\Exception $e) {
                Log::warning('UPS Access Token Invalid in authenticate2', ['message' => $e->getMessage()]);
            }
        }

        // If token is missing or invalid, authenticate again
        $this->accessToken = $this->authenticate();
        return $this->accessToken;
    }
    /**
     * Get shipping rates from UPS API.
     *
     * @param array $requestData
     * @return array
     */
    public function getShippingRates(array $requestData)
    {
        $this->accessToken = session()->get('ups_access_token', null);
        try {
            $packages = [];
            foreach ($requestData['packages'] as $package) {
                $length = isset($package['dimensions']['length']) ? (string) $package['dimensions']['length'] : '1';
                $width  = isset($package['dimensions']['width'])  ? (string) $package['dimensions']['width']  : '1';
                $height = isset($package['dimensions']['height']) ? (string) $package['dimensions']['height'] : '1';

                // Ensure all dimensions are > 0
                if ($length === '0' || $width === '0' || $height === '0') {
                    $length = $width = $height = '1';
                }

                $weight = isset($package['weight']) ? (string) $package['weight'] : '1';
                if ($weight === '0' || empty($weight)) {
                    $weight = '1';
                }
                $packages[] = [
                    "PackagingType" => [
                        "Code" => "02",
                        "Description" => "Package",
                    ],
                    "Dimensions" => [
                        "UnitOfMeasurement" => [
                            "Code" => "IN",
                        ],
                        "Length" => $length,
                        "Width" => $width,
                        "Height" => $height,
                    ],
                    "PackageWeight" => [
                        "UnitOfMeasurement" => [
                            "Code" => "LBS",
                        ],
                        "Weight" => $weight,
                    ],
                ];
            }

            // Determine which shipper address to use
            $useAlternativeShipper = isset($requestData['use_alternative_shipper']) && $requestData['use_alternative_shipper'] === true;
            
            // Get the appropriate shipper configuration
            // if ($useAlternativeShipper && config('alternative_shipper.category_82')) {
            //     $shipperName = config('alternative_shipper.category_82.name');
            //     $shipperAddress = config('alternative_shipper.category_82.address');
            //     $shipperCity = config('alternative_shipper.category_82.city');
            //     $shipperState = config('alternative_shipper.category_82.state');
            //     $shipperZip = config('alternative_shipper.category_82.zip');
            // } else {
            //     $shipperName = config('shipper.name');
            //     $shipperAddress = config('shipper.address');
            //     $shipperCity = config('shipper.city');
            //     $shipperState = config('shipper.state');
            //     $shipperZip = config('shipper.zip');
            // }
            $shipperName = config('shipper.name');
            $shipperAddress = config('shipper.address');
            $shipperCity = config('shipper.city');
            $shipperState = config('shipper.state');
            $shipperZip = config('shipper.zip');

            $payload = [
                "RateRequest" => [
                    "Request" => [
                        "TransactionReference" => [
                            "CustomerContext" => "Rating and Service",
                        ],
                    ],
                    "Shipment" => [
                        "Shipper" => [
                            "Name" => $requestData['sender_name'] ?? 'Academy Fence Company',
                            "ShipperNumber" => $this->shipperNumber,
                            "Address" => [
                                "AddressLine" =>  $requestData['sender_address'] ?? '119 N Day Street',
                                "City" => $requestData['sender_city'] ?? 'Orange',
                                "StateProvinceCode" => $requestData['sender_state'] ?? 'NJ',
                                "PostalCode" => $requestData['sender_postal'] ?? '07050',
                                "CountryCode" => $requestData['sender_country'] ?? 'US',
                            ],
                        ],
                        "ShipTo" => [
                            "Name" => "Recipient Name",
                            "Address" => [
                                "AddressLine" => $requestData['recipient_address'],
                                "City" => $requestData['recipient_city'],
                                "StateProvinceCode" => $requestData['recipient_state'],
                                "PostalCode" => $requestData['recipient_postal'],
                                "CountryCode" => $requestData['recipient_country'] ?? 'US',
                            ],
                        ],
                        "Package" => $packages, // Send multiple packages
                    ],
                ],
            ];

            \Log::info('UPS Request Payload:', ['payload' => $payload]);

            $response = $this->client->post("{$this->baseUrl}/api/rating/v1/Shop", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            
            \Log::info('UPS Response:', ['response' => $responseData]);

            return $responseData;
        } catch (\Exception $e) {
            \Log::error('UPS Shipping Rates Error', [
                'message' => $e->getMessage(),
                'request' => $requestData
            ]);

            return ['error' => $e->getMessage()];
        }
    }
}