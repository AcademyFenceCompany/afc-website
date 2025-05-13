<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class ShipperAddressService
{
    // Wood post caps category ID
    const WOOD_POST_CAPS_CATEGORY = 82;

    // Dropshipper address for wood post caps
    const WOOD_POST_CAPS_ADDRESS = [
        'address' => '1 Marc Road',
        'city' => 'Medway',
        'state' => 'MA',
        'zip' => '02053',
        'country' => 'US'
    ];

    /**
     * Check if any products in the cart belong to the wood post caps category
     * 
     * @return boolean
     */
    public function hasWoodPostCapsInCart()
    {
        $cart = Session::get('cart', []);
        
        foreach ($cart as $item) {
            if (isset($item['categories_id']) && $item['categories_id'] == self::WOOD_POST_CAPS_CATEGORY) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get the appropriate shipper address based on cart contents
     * 
     * @return array
     */
    public function getShipperAddress()
    {
        if ($this->hasWoodPostCapsInCart()) {
            return self::WOOD_POST_CAPS_ADDRESS;
        }
        
        // Return default address from config
        return [
            'address' => config('shipper.address'),
            'city' => config('shipper.city'),
            'state' => config('shipper.state'),
            'zip' => config('shipper.zip'),
            'country' => 'US'
        ];
    }

    /**
     * Get the city for the appropriate shipper
     * 
     * @return string
     */
    public function getShipperCity()
    {
        return $this->hasWoodPostCapsInCart() ? self::WOOD_POST_CAPS_ADDRESS['city'] : config('shipper.city');
    }

    /**
     * Get the state for the appropriate shipper
     * 
     * @return string
     */
    public function getShipperState()
    {
        return $this->hasWoodPostCapsInCart() ? self::WOOD_POST_CAPS_ADDRESS['state'] : config('shipper.state');
    }

    /**
     * Get the zip code for the appropriate shipper
     * 
     * @return string
     */
    public function getShipperZip()
    {
        return $this->hasWoodPostCapsInCart() ? self::WOOD_POST_CAPS_ADDRESS['zip'] : config('shipper.zip');
    }

    /**
     * Get the address line for the appropriate shipper
     * 
     * @return string
     */
    public function getShipperAddressLine()
    {
        return $this->hasWoodPostCapsInCart() ? self::WOOD_POST_CAPS_ADDRESS['address'] : config('shipper.address');
    }
}
