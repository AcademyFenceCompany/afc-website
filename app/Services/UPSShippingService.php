<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class UPSShippingService
{
    private $client;
    private $accessToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://onlinetools.ups.com', // UPS API Base URL
            'timeout' => 30, // Timeout in seconds
            'verify' => true, // Verify SSL certificates
        ]);

        $this->authenticate();
    }

    /**
     * Get OAuth Access Token (Uses Base64 Encoding)
     */
    private function authenticate()
    {
        try {
            $clientId = config('services.ups.client_id');  // Load from .env
            $clientSecret = config('services.ups.client_secret');  // Load from .env

            $response = $this->client->post('/security/v1/oauth/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret"),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            $this->accessToken = $result['access_token'];

            Log::info('UPS OAuth Token Retrieved', ['token' => $this->accessToken]);

        } catch (\Exception $e) {
            Log::error('UPS OAuth Token Error', ['message' => $e->getMessage()]);
            throw new \Exception('Failed to authenticate with UPS API.');
        }
    }
    public function validateAddressWithOAuth(array $address)
{
    try {
        $requestPayload = [
            "XAVRequest" => [
                "Request" => [
                    "RequestOption" => "1",
                    "TransactionReference" => [
                        "CustomerContext" => "Address Validation"
                    ]
                ],
                "AddressKeyFormat" => [
                    "ConsigneeName" => $address['name'] ?? "N/A",
                    "AddressLine" => $address['address_line'],
                    "PoliticalDivision2" => $address['city'],
                    "PoliticalDivision1" => $address['state'],
                    "PostcodePrimaryLow" => $address['zip'],
                    "CountryCode" => $address['country']
                ]
            ]
        ];

        $response = $this->client->post('/api/addressvalidation/v1/1', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,  // No Base64 here!
                'Content-Type' => 'application/json',
            ],
            'json' => $requestPayload,
        ]);

        return json_decode($response->getBody()->getContents(), true);

    } catch (\Exception $e) {
        Log::error('UPS Address Validation Error', ['message' => $e->getMessage()]);
        return ['error' => 'Unable to validate address.'];
    }
}

}
