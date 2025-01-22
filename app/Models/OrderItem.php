<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'original_order_id',
        'product_id',
        'original_product_id',
        'product_quantity',
        'product_price_at_time_of_purchase',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'original_order_id', 'original_customer_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
