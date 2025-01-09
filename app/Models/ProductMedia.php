<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory;
    protected $table = 'product_media';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'general_image',
        'small_image',
        'large_image',
        'original_product_id',
        'family_category_id',
    ];

    /**
     * Define the relationship to the Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
