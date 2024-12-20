<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCategory extends Model
{
    use HasFactory;

    protected $fillable = ['family_category_name', 'parent_category_id'];

    public function products()
    {
        return $this->hasMany(Product::class, 'family_category_id');
    }
}

