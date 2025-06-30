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

            $url = $this->baseUrl . "RateQuoteService.asmx";

            // Create items XML
            $itemsXml = '';
            foreach ($shipmentData['packages'] as $package) {
                $itemsXml .= '
                    <Item>
                        <Weight>' . floatval($package['weight']) . '</Weight>
                        <Class>' . $this->calculateFreightClass(
                            floatval($package['weight']),
                            floatval($package['dimensions']['length']),
                            floatval($package['dimensions']['width']),
                            floatval($package['dimensions']['height'])
                        ) . '</Class>
                        <Length>' . floatval($package['dimensions']['length']) . '</Length>
                        <Width>' . floatval($package['dimensions']['width']) . '</Width>
                        <Height>' . floatval($package['dimensions']['height']) . '</Height>
                        <PackageType>BOX</PackageType>
                        <PiecesCount>1</PiecesCount>
                    </Item>';
            }

            // Create SOAP envelope
            $soapEnvelope = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <GetRateQuote xmlns="http://www.rlcarriers.com/">
            <APIKey>' . $this->apiKey . '</APIKey>
            <request>
                <Origin>
                    <City>' . $shipmentData['origin_city'] . '</City>
                    <StateOrProvince>' . $shipmentData['origin_state'] . '</StateOrProvince>
                    <ZipOrPostalCode>' . $shipmentData['origin_zip'] . '</ZipOrPostalCode>
                    <CountryCode>USA</CountryCode>
                </Origin>
                <Destination>
                    <City>' . $shipmentData['destination_city'] . '</City>
                    <StateOrProvince>' . $shipmentData['destination_state'] . '</StateOrProvince>
                    <ZipOrPostalCode>' . $shipmentData['destination_zip'] . '</ZipOrPostalCode>
                    <CountryCode>USA</CountryCode>
                </Destination>
                <Items>' . $itemsXml . '</Items>
                <IsResidentialDelivery>true</IsResidentialDelivery>
                <IsLiftGateDeliveryRequested>true</IsLiftGateDeliveryRequested>
                <IncludeDetailedPricing>true</IncludeDetailedPricing>
                <ShowAlternativeServices>true</ShowAlternativeServices>
                <IncludeFuelSurcharge>true</IncludeFuelSurcharge>
            </request>
        </GetRateQuote>
    </soap:Body>
</soap:Envelope>';

            Log::info('R&L Carriers API Request Payload:', ['payload' => $soapEnvelope]);

            $response = $this->client->post($url, [
                'body' => $soapEnvelope,
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'SOAPAction' => 'http://www.rlcarriers.com/GetRateQuote',
                    'Content-Length' => strlen($soapEnvelope)
                ]
            ]);

            // Parse SOAP response
            $xml = simplexml_load_string($response->getBody());
            $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
            $xml->registerXPathNamespace('rlc', 'http://www.rlcarriers.com/');

            $result = $xml->xpath('//rlc:GetRateQuoteResult');
            $responseData = json_decode(json_encode($result[0]), true);

            Log::info('R&L Carriers API Raw Response:', ['raw_response' => (string) $response->getBody()]);

            // Transform response to match frontend expectations
            if ($responseData['WasSuccess'] === 'true' && isset($responseData['Result'])) {
                $result = $responseData['Result'];
                $charges = [];

                // Extract all charges from the response
                if (isset($result['Charges']['Charge'])) {
                    foreach ($result['Charges']['Charge'] as $charge) {
                        // Skip charges with empty type
                        if (empty($charge['Type'])) {
                            continue;
                        }
                        $charges[$charge['Type']] = [
                            'Title' => $charge['Title'],
                            'Amount' => $charge['Amount']
                        ];
                    }
                }

                // Find standard service
                $standardService = null;
                foreach ($result['ServiceLevels']['ServiceLevel'] as $service) {
                    if ($service['Code'] === 'STD') {
                        $standardService = $service;
                        break;
                    }
                }

                if ($standardService) {
                    // Get base freight charge (discounted)
                    $baseCharge = floatval(str_replace(['$', ','], '', $charges['DISCNF']['Amount'] ?? '0'));

                    // Get fuel surcharge
                    $fuelSurcharge = floatval(str_replace(['$', ','], '', $charges['FUEL']['Amount'] ?? '0'));

                    // Add residential and lift gate fees
                    $residentialFee = 118.00;
                    $liftGateFee = 33.00;

                    // Calculate total
                    $totalCharge = $baseCharge + $fuelSurcharge + $residentialFee + $liftGateFee;

                    // Log the calculation for debugging
                    Log::info('R&L Rate Calculation', [
                        'baseCharge' => $baseCharge,
                        'fuelSurcharge' => $fuelSurcharge,
                        'residentialFee' => $residentialFee,
                        'liftGateFee' => $liftGateFee,
                        'totalCharge' => $totalCharge,
                        'allCharges' => $charges
                    ]);
                    @dump($standardService);
                    return [
                        'd' => [
                            'Result' => [
                                'ServiceLevels' => [
                                    [
                                        'Title' => $standardService['Title'],
                                        'Code' => $standardService['Code'],
                                        'NetCharge' => '$' . number_format($totalCharge, 2),
                                        'ServiceDays' => $standardService['ServiceDays'],
                                        'Details' => [
                                            'BaseCharge' => '$' . number_format($baseCharge, 2),
                                            'FuelSurcharge' => '$' . number_format($fuelSurcharge, 2),
                                            'LiftGateFee' => '$' . number_format($liftGateFee, 2),
                                            'ResidentialFee' => '$' . number_format($residentialFee, 2)
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ];
                }
            }

            return $responseData;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('R&L Carriers API Request Failed', [
                'error' => $e->getMessage(),
                'request' => $soapEnvelope ?? null,
                'response' => $e->getResponse() ? (string) $e->getResponse()->getBody() : 'No response body',
                'request_headers' => $e->getRequest()->getHeaders(),
                'response_headers' => $e->getResponse() ? $e->getResponse()->getHeaders() : []
            ]);

            return ['error' => 'R&L Carriers API Request Failed. ' . $e->getMessage()];
        }
    }

    /**
     * Calculate freight class based on weight and density
     *
     * @param float $weight Total weight in pounds
     * @param float $length Length in inches
     * @param float $width Width in inches
     * @param float $height Height in inches
     * @return string Freight class (e.g., "50", "55", "60", etc.)
     */
    private function calculateFreightClass($weight, $length, $width, $height)
    {
        // R&L Carriers density calculation:
        // Density = weight (lbs) / (length * width * height / 1728)
        // All dimensions must be in inches.
        // If any dimension is zero or negative, return "500.0" (lowest class).
        if ($weight <= 0 || $length <= 0 || $width <= 0 || $height <= 0) {
            return "500.0";
        }

        $cubicFeet = ($length * $width * $height) / 1728;
        if ($cubicFeet <= 0) {
            return "500.0";
        }
        $density = $weight / $cubicFeet;
        //@dump($density); // Debugging line
        // R&L Carriers official freight class table (as of 2024):
        if ($density >= 50) return "50.0";
        if ($density >= 35) return "55.0";
        if ($density >= 30) return "60.0";
        if ($density >= 22.5) return "65.0";
        if ($density >= 15) return "70.0";
        if ($density >= 13.5) return "77.5";
        if ($density >= 12) return "85.0";
        if ($density >= 10.5) return "92.5";
        if ($density >= 9) return "100.0";
        if ($density >= 8) return "110.0";
        if ($density >= 7) return "125.0";
        if ($density >= 6) return "150.0";
        if ($density >= 5) return "175.0";
        if ($density >= 4) return "200.0";
        if ($density >= 3) return "250.0";
        if ($density >= 2) return "300.0";
        if ($density >= 1) return "400.0";

        return "500.0"; // Default for very low density items
    }
}
