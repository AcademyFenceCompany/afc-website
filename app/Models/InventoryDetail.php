<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
    use HasFactory;
    protected $table = 'inventory_details';
    public $timestamps = false;

    protected $fillable = ['product_id', 'in_stock_hq', 'in_stock_warehouse', 'inventory_ordered', 'inventory_expected_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

