<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCategory extends Model
{
    use HasFactory;
    protected $table = 'family_categories';
    protected $primaryKey = 'family_category_id'; 
    protected $fillable = ['family_category_name', 'parent_category_id'];

    public function products()
    {
        return $this->hasMany(Product::class, 'family_category_id', 'family_category_id');
    }
    public function children()
    {
        return $this->hasMany(FamilyCategory::class, 'parent_category_id', 'family_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(FamilyCategory::class, 'parent_category_id', 'family_category_id');
    }
}

