<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'size1', 'size2', 'size3', 'style', 'speciality', 'material', 'spacing', 'color', 'coating'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
}
