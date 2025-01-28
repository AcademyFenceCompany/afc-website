<?php

namespace App\Services;

use Ups\Rate;
use Ups\Entity\Shipment;
use Ups\Entity\Address;
use Ups\Entity\Package;
use Ups\Entity\PackagingType;

class UPSService
{
    protected $rate;

    public function __construct()
    {
        $this->rate = new Rate(
            env('UPS_ACCESS_KEY'),
            env('UPS_USERNAME'),
            env('UPS_PASSWORD')
        );
    }

    public function getRates($destination, $cart)
    {
        $shipment = new Shipment();

        // Origin Address (ship-from)
        $shipFrom = $shipment->getShipFrom();
        $shipFrom->setAddress(new Address());
        $shipFrom->getAddress()
            ->setPostalCode(env('UPS_ORIGIN_ZIP'))
            ->setCity('ORANGE')
            ->setStateProvinceCode('NJ')
            ->setCountryCode('US');

        // Destination Address (ship-to)
        $shipTo = $shipment->getShipTo();
        $shipTo->setAddress(new Address());
        $shipTo->getAddress()
            ->setPostalCode($destination['zip'])
            ->setCity($destination['city'])
            ->setStateProvinceCode($destination['state'])
            ->setCountryCode('US');

        // Add Packages from Cart
        foreach ($cart as $item) {
            $package = new Package();
            $package->getPackagingType()->setCode(PackagingType::PT_PACKAGE);
            $package->getPackageWeight()->setWeight($item['weight']);

            if (isset($item['shipping_length'], $item['shipping_width'], $item['shipping_height'])) {
                $package->getDimensions()
                    ->setWidth($item['shipping_width'])
                    ->setHeight($item['shipping_height'])
                    ->setLength($item['shipping_length']);
            }

            $shipment->addPackage($package);
        }

        // Fetch Rates
        try {
            return $this->rate->shopRates($shipment)->RatedShipment;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching UPS rates: " . $e->getMessage());
        }
    }
}
