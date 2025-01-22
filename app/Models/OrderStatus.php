<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'customer_order_id',
        'call_date',
        'quote_date',
        'sold_date',
        'shipped_confirmed_date',
    ];

    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id', 'customer_order_id');
    }
}

