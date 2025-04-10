<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AluminumFenceController extends Controller
{
    public function main()
    {
        // Get aluminum fence categories from the database
        $aluminumCategories = DB::connection('mysql_second')
            ->table('categories')
            ->where('majorcategories_id', 43) // Aluminum fence major category ID
            ->where('web_enabled', 1)
            ->select('id', 'cat_name as family_category_name', 'cat_desc_long', 'seo_name', 'img')
            ->get();
            
        // Format the categories with images
        $formattedCategories = [];
        foreach ($aluminumCategories as $category) {
            $formattedCategories[] = [
                'family_category_id' => $category->id,
                'family_category_name' => $category->family_category_name,
                'cat_desc_long' => $category->cat_desc_long,
                'seo_name' => $category->seo_name,
                'image' => $category->img ? url('storage/categories/' . $category->img) : url('storage/categories/default.png'),
            ];
        }
        
        return view('categories.aluminumfence-main', [
            'aluminum_categories' => collect($formattedCategories)
        ]);
    }
    
    public function index(Request $request, $style = null)
    {
        // Get selected fence type and model from the request
        $selectedType = $request->input('type', $style);
        
        // Base query for aluminum fence products
        $baseQuery = DB::connection('mysql_second')
            ->table('productsqry')
            ->where(function($query) {
                $query->where('product_name', 'LIKE', 'OnGuard Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'OnGuard Ornamental Aluminum Fence%')
                      ->orWhere('product_name', 'LIKE', 'On Guard Ornamental Aluminum Fence%');
            })
            ->where('enabled', 1);
            
        // Get all fence types and models using the query
        $typesAndModels = DB::connection('mysql_second')
            ->select("
                SELECT 
                    CASE 
                        WHEN product_name LIKE '%Residential%' THEN 'Residential'
                        WHEN product_name LIKE '%Commercial%' THEN 'Commercial'
                        WHEN product_name LIKE '%Industrial%' THEN 'Industrial'
                        ELSE 'Unknown'
                    END AS fence_type,
                    TRIM(SUBSTRING_INDEX(product_name, '-', -1)) AS model_name,
                    COUNT(*) AS total
                FROM productsqry
                WHERE (product_name LIKE 'OnGuard Aluminum Fence%'
                   OR product_name LIKE 'OnGuard Ornamental Aluminum Fence%'
                   OR product_name LIKE 'On Guard Ornamental Aluminum Fence%')
                   AND enabled = 1
                GROUP BY fence_type, model_name
                ORDER BY fence_type, model_name
            ");
        
        // Organize types and models into a structured array
        $fenceTypes = [
            'Residential' => [
                'title' => 'Residential',
                'models' => [],
                'description' => $this->getTypeDescription('Residential'),
                'specs' => $this->getTypeSpecs('Residential')
            ],
            'Commercial' => [
                'title' => 'Commercial',
                'models' => [],
                'description' => $this->getTypeDescription('Commercial'),
                'specs' => $this->getTypeSpecs('Commercial')
            ],
            'Industrial' => [
                'title' => 'Industrial',
                'models' => [],
                'description' => $this->getTypeDescription('Industrial'),
                'specs' => $this->getTypeSpecs('Industrial')
            ]
        ];
        
        foreach ($typesAndModels as $item) {
            if (isset($fenceTypes[$item->fence_type])) {
                $fenceTypes[$item->fence_type]['models'][$item->model_name] = [
                    'name' => $item->model_name,
                    'total' => $item->total
                ];
            }
        }
        
        // Manually add Puppy Picket models to each fence type
        foreach ($fenceTypes as $type => &$fenceType) {
            // Add Puppy Picket models
            $fenceType['models']['Puppy Picket 1*'] = [
                'name' => 'Puppy Picket 1*',
                'total' => 1
            ];
            
            $fenceType['models']['Puppy Picket 2*'] = [
                'name' => 'Puppy Picket 2*',
                'total' => 1
            ];
            
            $fenceType['models']['Puppy Picket 3*'] = [
                'name' => 'Puppy Picket 3*',
                'total' => 1
            ];
        }
        
        // Get products based on selected type and model
        $products = [];
        if ($selectedType) {
            // Parse the selected type to get fence_type and model
            $parts = explode('-', $selectedType);
            $selectedFenceType = $parts[0] ?? null;
            $selectedModel = $parts[1] ?? null;
            
            if ($selectedFenceType && $selectedModel) {
                // Query products for the selected type and model
                $products = $baseQuery
                    ->where('product_name', 'LIKE', '%' . $selectedFenceType . '%')
                    ->where('product_name', 'LIKE', '%' . $selectedModel . '%')
                    ->get();
            }
        }
        
        // Get representative images for each model
        $representativeImages = [];
        foreach ($fenceTypes as $typeName => $typeData) {
            $representativeImages[$typeName] = [];
            foreach ($typeData['models'] as $modelName => $modelData) {
                // Find a product from this model to get its image
                $representativeProduct = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->where('product_name', 'LIKE', '%' . $typeName . '%')
                    ->where('product_name', 'LIKE', '%' . $modelName . '%')
                    ->select('img_large')
                    ->first();
                
                if ($representativeProduct && $representativeProduct->img_large) {
                    $representativeImages[$typeName][$modelName] = url('storage/products/' . $representativeProduct->img_large);
                } else {
                    // Fallback to default image
                    $representativeImages[$typeName][$modelName] = url('storage/products/default.png');
                }
            }
        }
        
        // Return the view with data
        return view('categories.aluminumfence', [
            'fenceTypes' => $fenceTypes,
            'representativeImages' => $representativeImages,
            'products' => $products,
            'selectedType' => $selectedType,
            'selectedFenceType' => $selectedFenceType ?? null,
            'selectedModel' => $selectedModel ?? null
        ]);
    }
    
    /**
     * Get description for a fence type
     */
    private function getTypeDescription($type)
    {
        $descriptions = [
            'Residential' => 'OnGuard\'s family of Residential Aluminum Picket Fence products are offered in a wide array of beautiful designs and classic finish options',
            'Commercial' => 'OnGuard Commercial Aluminum Picket Fence is built with high-quality aluminum fence components, where long-lasting durability and beauty are required.',
            'Industrial' => 'OnGuard Industrial Aluminum Fence provides maximum security and strength for industrial applications, built with the heaviest gauge aluminum components.'
        ];
        
        return $descriptions[$type] ?? 'High-quality aluminum fence products from OnGuard';
    }
    
    /**
     * Get specifications for a fence type
     */
    private function getTypeSpecs($type)
    {
        $specs = [
            'Residential' => 'Pickets - 5/8" x .050" thick, Rails - Topwalls - 1 1/8" x .062" thick, Rails - Sidewalls - 1" x .080" thick',
            'Commercial' => 'Pickets - 3/4" x .050" thick, Rails - Topwalls - 1 3/8" x .065" thick, Rails - Sidewalls - 1 1/4" x .088" thick',
            'Industrial' => 'Pickets - 1" x .062" thick, Rails - Topwalls - 1 5/8" x .070" thick, Rails - Sidewalls - 1 1/2" x .100" thick'
        ];
        
        return $specs[$type] ?? '';
    }
}
