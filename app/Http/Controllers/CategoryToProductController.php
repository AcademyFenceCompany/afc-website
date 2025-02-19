<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryToProductController extends Controller
{
    // Holds the category tree structure for later use
    public $family_category_tree = [];

    /**
     * Retrieves and constructs a hierarchical category tree using a recursive SQL query.
     * This function displays the category tree in the product view.
     *
     * @return \Illuminate\View\View
     */
    public function showProductTree()
    {
        // Execute a recursive SQL query to get hierarchical category data
        $familyCategories = DB::select("
            WITH RECURSIVE family_category_tree AS (
                -- Base query: Select root categories (those with no parent)
                SELECT 
                    family_category_id,
                    parent_category_id,
                    family_category_name,
                    CAST(family_category_name AS CHAR(1000)) AS path
                FROM family_categories
                WHERE parent_category_id IS NULL

                UNION ALL

                -- Recursive query: Find child categories and build the hierarchy
                SELECT 
                    c.family_category_id,
                    c.parent_category_id,
                    c.family_category_name,
                    CONCAT(fct.path, ' > ', c.family_category_name) AS path
                FROM family_categories c
                INNER JOIN family_category_tree fct ON fct.family_category_id = c.parent_category_id
            )
            -- Select all categories from the recursive result
            SELECT * FROM family_category_tree;
        ");

        // Store categories in an associative array using category ID as the key
        $categoriesById = [];
        $tree = [];

        // Build an array indexed by category ID for quick lookup
        foreach ($familyCategories as $category) {
            $categoriesById[$category->family_category_id] = $category;
        }

        /**
         * Recursively builds the category tree by adding child categories to their respective parents.
         *
         * @param object $category The current category being processed
         * @param array $categoriesById Reference to the associative array of all categories
         * @return object The category with its child categories nested
         */
        function buildCategoryTree($category, $categoriesById)
        {
            // Initialize an empty array to store child categories
            $children = [];

            // Loop through all categories to find children of the current category
            foreach ($categoriesById as $potentialChild) {
                if ($potentialChild->parent_category_id === $category->family_category_id) {
                    // Recursively build the subtree for this child
                    $children[] = buildCategoryTree($potentialChild, $categoriesById);
                }
            }

            // Assign the found children to the current category
            $category->children = $children;

            return $category;
        }

        // Construct the hierarchical category tree
        foreach ($categoriesById as $category) {
            if ($category->parent_category_id === null) {
                // This is a root category, so start building from here
                $tree[] = buildCategoryTree($category, $categoriesById);
            }
        }

        // Convert the tree to a collection for easier manipulation
        $tree = collect((array) $tree);

        // Store the generated category tree in the class property
        $this->family_category_tree = $tree;

        // Pass the category tree to the Blade view for rendering
        return view('ams.product.view-product', ['categories' => $tree]);
    }
}
