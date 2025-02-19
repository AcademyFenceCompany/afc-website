<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCategory extends Model
{
    use HasFactory;

    // Define the associated table name in the database
    protected $table = 'family_categories';

    // Specify the primary key for the table
    protected $primaryKey = 'family_category_id'; 

    // Define the fillable fields for mass assignment
    protected $fillable = ['family_category_name', 'parent_category_id', 'category_description'];

    /**
     * Relationship: A category can have multiple subcategories (children).
     * This creates a self-referencing one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(FamilyCategory::class, 'parent_category_id', 'family_category_id');
    }

    /**
     * Relationship: A category may belong to a parent category.
     * This allows hierarchical structuring of categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(FamilyCategory::class, 'parent_category_id', 'family_category_id');
    }

    /**
     * Relationship: A category can have multiple products.
     * This links the category to the Product model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'family_category_id', 'family_category_id');
    }
}
