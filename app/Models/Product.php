<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'item_no', 'price_per_unit', 'shippable', 'family_category_id', 'description'];

    public function familyCategory()
    {
        return $this->belongsTo(FamilyCategory::class);
    }

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function inventoryDetail()
    {
        return $this->hasOne(InventoryDetail::class);
    }

    public function productAssociations()
    {
        return $this->hasMany(ProductAssociation::class);
    }

    public function shippingDetail()
    {
        return $this->hasOne(ShippingDetail::class);
    }
}
