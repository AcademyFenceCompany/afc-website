<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public $family_category_tree = [];

    public function showTree()
    {
        $familyCategories = DB::select("
    WITH RECURSIVE family_category_tree AS (
        SELECT 
            family_category_id,
            parent_category_id,
            family_category_name,
            CAST(family_category_name AS CHAR(1000)) AS path
        FROM family_categories
        WHERE parent_category_id is null

        UNION ALL

        SELECT 
            c.family_category_id,
            c.parent_category_id,
            c.family_category_name,
            CONCAT(fct.path, ' > ', c.family_category_name) AS path
        FROM family_categories c
        INNER JOIN family_category_tree fct ON fct.family_category_id = c.parent_category_id
    )
    SELECT * FROM family_category_tree;
");

        $categoriesById = [];
        $tree = [];

        // Build an associative array by category id for easy access
        foreach ($familyCategories as $category) {
            $categoriesById[$category->family_category_id] = $category;
        }

        // Function to recursively build the category tree (including children, grandchildren, etc.)
        function buildCategoryTree($category, $categoriesById)
        {
            // Initialize children array
            $children = [];

            // Find children for the current category
            foreach ($categoriesById as $potentialChild) {
                if ($potentialChild->parent_category_id === $category->family_category_id) {
                    // Recursively add children of this category
                    $children[] = buildCategoryTree($potentialChild, $categoriesById);
                }
            }

            // Add children to the current category
            $category->children = $children;

            return $category;
        }

        // Build the tree recursively starting from the root categories
        foreach ($categoriesById as $category) {
            if ($category->parent_category_id === null) {
                // This is a root category, start the tree from here
                $tree[] = buildCategoryTree($category, $categoriesById);
            }
        }



        $tree = collect((array) $tree);

        $this->family_category_tree = $tree;
        return view('ams.category-management.categories', ['categories' => $tree]);
    }

    // public function showProducts($category_id)
    // {
    //     // Fetch the category and its products

    //     $category = DB::table('family_categories')
    //         ->where('family_category_id', $category_id)
    //         ->value('family_category_name');

    //     $products =  DB::table('products')
    //         ->where('subcategory_id', $category_id)
    //         ->select('*')
    //         ->get();

    //     // Return the view with category and products
    //     return view('ams.display-products-tree', compact('category', 'products'));
    // }

    public function getProducts($category_id)
    {
        // Fetch products for the given category ID
        $products =  DB::table('products')
            ->join("product_details", "products.product_id", "=", "product_details.product_id")
            ->where('subcategory_id', $category_id)
            ->select('*')
            ->get();

        // Return product data as JSON
        return response()->json(['products' => $products]);
    }
}
