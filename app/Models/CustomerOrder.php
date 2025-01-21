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
        'original_customer_order_id',
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

    public function address()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_id', 'customer_id');
    }
    
    public function order()
    {
        return $this->hasMany(OrderItem::class, 'original_order_id', 'original_customer_order_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'original_order_id', 'product_id', 'original_customer_order_id', 'product_id');
    }
}
