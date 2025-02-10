<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RLCarriersService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 10]);
        $this->apiKey = env('RL_API_KEY');
        $this->baseUrl = env('RL_API_BASE_URL');
    }

    /**
     * Get shipping rates from R&L Carriers
     *
     * @param array $shipmentData
     * @return array
     */
    public function getRates(array $shipmentData)
    {
        try {
            Log::info('Received shipment data:', ['shipmentData' => $shipmentData]);

            $url = $this->baseUrl . "RateQuoteService.asmx/GetRateQuote";

            $payload = [
                "APIKey" => $this->apiKey,
                "request" => [
                    "QuoteType" => "Domestic",
                    "CODAmount" => 0,
                    "Origin" => [
                        "City" => $shipmentData['origin_city'],
                        "StateOrProvince" => $shipmentData['origin_state'],
                        "ZipOrPostalCode" => $shipmentData['origin_zip'],
                        "CountryCode" => "USA"
                    ],
                    "Destination" => [
                        "City" => $shipmentData['destination_city'],
                        "StateOrProvince" => $shipmentData['destination_state'],
                        "ZipOrPostalCode" => $shipmentData['destination_zip'],
                        "CountryCode" => "USA"
                    ],
                    "Items" => array_map(function ($item) {
                        return [
                            "Weight" => 25, 
                            "Length" => 15,  
                            "Width" => 10,    
                            "Height" => 25,
                            "HandlingUnits" => 1, 
                            "FreightClass" => "50.0", 
                            "PackagingType" => "BOX" 
                        ];
                    }, $shipmentData['packages']),
                    
                    "DeclaredValue" => 0,
                    "Accessorials" => [
                        "RQAccessorial" => "ResidentialDelivery"
                    ]
                ]
            ];

            Log::info('R&L Carriers API Request Payload:', ['payload' => $payload]);

            $response = $this->client->post($url, [
                'json' => $payload,
                'headers' => ['Content-Type' => 'application/json']
            ]);

            $responseData = json_decode($response->getBody(), true);

             Log::info('R&L Carriers API Raw Response:', ['raw_response' => (string) $response->getBody()]);

            return $responseData;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('R&L Carriers API Request Failed', [
                'error' => $e->getMessage(),
                'body' => $e->getResponse() ? (string) $e->getResponse()->getBody() : 'No response body'
            ]);

            return ['error' => 'R&L Carriers API Request Failed. ' . $e->getMessage()];
        }
    }
}
