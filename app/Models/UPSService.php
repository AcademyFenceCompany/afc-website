<?php

namespace App\Services;

use Ups\Rate;
use Ups\Entity\Address;
use Ups\Entity\Shipment;
use Ups\Entity\ShipFrom;
use Ups\Entity\ShipTo;
use Ups\Entity\Package;

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

    public function getRates($origin, $destination, $packages)
    {
        $shipment = new Shipment();

        // Set origin address
        $shipFrom = new ShipFrom();
        $shipFrom->setAddress(new Address($origin['address'], $origin['city'], $origin['state'], $origin['postal']));
        $shipment->setShipFrom($shipFrom);

        // Set destination address
        $shipTo = new ShipTo();
        $shipTo->setAddress(new Address($destination['address'], $destination['city'], $destination['state'], $destination['postal']));
        $shipment->setShipTo($shipTo);

        // Add packages
        foreach ($packages as $packageData) {
            $package = new Package();
            $package->getPackagingType()->setCode(Package::PACKAGE_TYPE_YOUR_PACKAGING);
            $package->getPackageWeight()->setWeight($packageData['weight']);
            $package->setDimensions($packageData['length'], $packageData['width'], $packageData['height']);
            $shipment->addPackage($package);
        }

        // Get rates
        return $this->rate->shopRates($shipment);
    }
}