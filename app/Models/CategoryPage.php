<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryPage extends Model
{
    protected $fillable = [
        'family_category_id',
        'template',
        'title',
        'subtitle',
        'bulletin_board',
        'product_image',
        'product_text',
        'category_tidbit_1',
        'category_tidbit_2',
        'category_tidbit_3',
        'footer_subtitle',
        'footer_bulletin_board',
        'footer_product_image',
        'footer_product_text',
        'menu_type',
        'menu_order'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            $category = FamilyCategory::find($page->family_category_id);
            if ($category) {
                $page->slug = Str::slug($category->family_category_name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(FamilyCategory::class, 'family_category_id', 'family_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'family_category_id', 'family_category_id');
    }
}
