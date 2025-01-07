<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyCategory;
use Illuminate\Support\Facades\DB;


class CategoriesController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = FamilyCategory::all();
        dd($categories);

        // Build hierarchical tree
        $nestedCategories = $this->buildTree($categories);

        // Debug: Check the output
        if (empty($nestedCategories)) {
            dd('Nested categories are empty!', $nestedCategories);
        }
        return view('ams.categories', ['categories' => $nestedCategories]);
    }

    private function buildTree($categories, $parentId = null)
    {
        $branch = [];
    
        foreach ($categories as $category) {
            if ($category->parent_category_id == $parentId) {
                $children = $this->buildTree($categories, $category->family_category_id);
                if ($children) {
                    $category->children = $children;
                }
                $branch[] = $category;
            }
        }
    
        return $branch;
    }
}

?>
