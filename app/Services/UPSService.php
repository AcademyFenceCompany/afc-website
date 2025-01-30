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
    private $accessToken;

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
    private function authenticate()
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
            Log::info('UPS OAuth Token Retrieved', ['token' => $this->accessToken]);
        } catch (\Exception $e) {
            Log::error('UPS OAuth Error', ['message' => $e->getMessage()]);
            throw new \Exception('Failed to authenticate with UPS API.');
        }
    }

    /**
     * Get shipping rates from UPS API.
     *
     * @param array $requestData
     * @return array
     */
    public function getShippingRates(array $requestData)
{
    try {
        $packages = [];
        foreach ($requestData['packages'] as $package) {
            $packages[] = [
                "PackagingType" => [
                    "Code" => "02",
                    "Description" => "Package",
                ],
                "Dimensions" => [
                    "UnitOfMeasurement" => [
                        "Code" => "IN",
                    ],
                    "Length" => $package['dimensions']['length'],
                    "Width" => $package['dimensions']['width'],
                    "Height" => $package['dimensions']['height'],
                ],
                "PackageWeight" => [
                    "UnitOfMeasurement" => [
                        "Code" => "LBS",
                    ],
                    "Weight" => $package['weight'],
                ],
            ];
        }

        $payload = [
            "RateRequest" => [
                "Request" => [
                    "TransactionReference" => [
                        "CustomerContext" => "Rating and Service",
                    ],
                ],
                "Shipment" => [
                    "Shipper" => [
                        "Name" => "Shipper Name",
                        "ShipperNumber" => $this->shipperNumber,
                        "Address" => [
                            "AddressLine" => [$requestData['shipper_address']],
                            "City" => $requestData['shipper_city'],
                            "StateProvinceCode" => $requestData['shipper_state'],
                            "PostalCode" => $requestData['shipper_postal'],
                            "CountryCode" => "US",
                        ],
                    ],
                    "ShipTo" => [
                        "Name" => "Recipient Name",
                        "Address" => [
                            "AddressLine" => [$requestData['recipient_address']],
                            "City" => $requestData['recipient_city'],
                            "StateProvinceCode" => $requestData['recipient_state'],
                            "PostalCode" => $requestData['recipient_postal'],
                            "CountryCode" => "US",
                        ],
                    ],
                    "Package" => $packages, // Send multiple packages
                ],
            ],
        ];

        $response = $this->client->post("{$this->baseUrl}/api/rating/v1/Shop", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    } catch (\Exception $e) {
        Log::error('UPS Shipping Rates Error', ['message' => $e->getMessage()]);
        return ['error' => 'Unable to fetch rates from UPS API.'];
    }
}
}