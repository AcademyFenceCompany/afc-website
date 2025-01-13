<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'item_no',
        'description',
        'cost',
        'price_per_unit',
        'family_category_id',
        'shipable',
        'subcategory_id',
        'shippable' 

    ];

    // Relationships
    public function media()
    {
        return $this->hasOne(ProductMedia::class, 'product_id', 'product_id');
    }

    public function details()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'product_id');
    }

    public function shippingDetails()
    {
        return $this->hasOne(ShippingDetail::class, 'product_id', 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(InventoryDetail::class, 'product_id', 'product_id');
    }

    public function familyCategory()
    {
        return $this->belongsTo(FamilyCategory::class, 'family_category_id', 'family_category_id');
    }
}
