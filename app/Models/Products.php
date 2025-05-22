<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'desc_short',
        'desc_long',
        'color',
        'item_no',
        'list',
        'cost',
        'price',
        'size',
        'img_large',
        'img_small',
        'size2',
        'size3',
        'gauge',
        'in_stock',
        'spacing',
        'coating',
        'material',
        'style',
        'speciality',
        'shippable',
        'notes',
        'enabled',
        'categories_id',
        'shipping_method',
        'display_size_2',
        'add_keywords',
        'ship_height',
        'ship_width',
        'ship_length',
        'product_accessories',
        'mod_by',
        'weight_lbs',
    ];
    // Cast the shippable column to a boolean
    protected $casts = [
        'shippable' => 'boolean',
    ];
    // Enable timestamps but use 'modified' as the updated_at column
    const UPDATED_AT = 'modified';
    // This function is used to get all distinct values for a column
    public function uniqueValsColumn($id, $column)
    {
        return \DB::table('products')
            ->where('categories_id', $id)
            ->distinct()
            ->pluck($column);
    }
}
