<?php
namespace App\Services;

use SoapClient;
use Exception;

class UPSFreightService
{
    private $access;
    private $userid;
    private $passwd;
    private $wsdl;
    private $endpoint;

    public function __construct()
    {
        $this->access = "5CAC915FAA7295B0";
        $this->userid = "academyfence";
        $this->passwd = "FenceAFC@119";
        $this->wsdl = storage_path('UPSFiles/FreightRate.wsdl');
        $this->endpoint = 'https://onlinetools.ups.com/webservices/FreightRate';
    }

    public function getFreightRate($shipmentData)
    {
        try {
            // Initialize SOAP client
            $client = new SoapClient($this->wsdl, [
                'trace' => true,
                'exceptions' => true,
            ]);

            // Build the request payload
            $request = [
                'AccessRequest' => [
                    'AccessLicenseNumber' => $this->access,
                    'UserId' => $this->userid,
                    'Password' => $this->passwd,
                ],
                'FreightRateRequest' => $shipmentData,
            ];

            // Call the API operation
            $response = $client->__soapCall('ProcessFreightRate', [$request]);

            return $response;
        } catch (Exception $e) {
            // Log the error for debugging
            \Log::error("UPS Freight API Error: " . $e->getMessage());
            throw $e;
        }
    }
}
