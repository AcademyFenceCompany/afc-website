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
        'original_order_id',
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

    public function shippingAddress()
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'customer_id')
            ->where('shipping_flag', 1);
    }
    
    public function billingAddress()
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'customer_id')
            ->where('billing_flag', 1);
    }
    
    public function order()
    {
        return $this->hasMany(OrderItem::class, 'original_order_id', 'original_order_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderItem::class,
            'original_order_id',         // Foreign key on order_items table
            'product_id',                // Foreign key on products table
            'original_order_id', // Local key on customer_orders table
            'product_id'                 // Local key on order_items table
        )->with('details'); // Eager load the ProductDetail relationship
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'original_customer_order_id', 'original_order_id');
    }

    public function shippingDetails()
    {
        return $this->hasOne(OrderShippingDetail::class, 'original_order_id', 'original_order_id');
    }

}