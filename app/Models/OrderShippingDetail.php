<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShippingDetail extends Model
{
    protected $table = 'order_shipping_details';

    protected $fillable = [
        'carrier',
        'shipby',
        'status',
        'tracking_no',
        'actual_shipping_cost',
        'shipping_cost_markup',
        'original_order_id',
        'customer_id',
        'shipping_address_id',
        'order_id',
    ];
}

