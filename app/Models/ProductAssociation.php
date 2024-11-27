<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAssociation extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'associated_product', 'association_header'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
