<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyCategory extends Model
{
    protected $table = 'family_categories';
    protected $primaryKey = 'family_category_id';
    public $timestamps = false; // If the table doesn’t have created_at/updated_at columns

    protected $fillable = [
        'family_category_name',
        'parent_category_id',
        'category_description',
    ];

    // Define relationship with children categories
    public function children()
    {
        return $this->hasMany(FamilyCategory::class, 'parent_category_id', 'family_category_id');
    }

    // Define relationship with the parent category
    public function parent()
    {
        return $this->belongsTo(FamilyCategory::class, 'parent_category_id', 'family_category_id');
    }
}
