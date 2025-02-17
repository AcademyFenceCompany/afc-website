<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    protected $fillable = [
        'customer_id',
        'billing_address_id',
        'shipping_address_id',
        'order_origin',
        'original_customer_id',
        'original_customer_or',
        'payment_method',
        'discount_amount',
        'subtotal',
        'tax_amount',
        'total'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'billing_address_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id', 'id');
    }
}
