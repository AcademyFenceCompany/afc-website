<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'weight', 'shipping_length', 'shipping_width', 'shipping_height', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
