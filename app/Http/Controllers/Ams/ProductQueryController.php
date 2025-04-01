<?php

namespace App\Http\Controllers\Ams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ProductQueryController extends Controller
{
    /**
     * Display products from the productsqry view in demodb database.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            // Check that the 'mysql_second' connection exists and get database info
            $dbInfo = [
                'connection' => 'mysql_second',
                'database_name' => config('database.connections.mysql_second.database')
            ];
            
            // Get all tables in the database
            try {
                $tables = DB::connection('mysql_second')->select('SHOW TABLES');
                $dbInfo['tables'] = $tables;
            } catch (\Exception $e) {
                $dbInfo['tables_error'] = $e->getMessage();
            }
            
            // Get all views
            try {
                $views = DB::connection('mysql_second')
                    ->select("SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW'");
                $dbInfo['views'] = $views;
            } catch (\Exception $e) {
                $dbInfo['views_error'] = $e->getMessage();
            }
            
            // First, let's inspect the structure of the productsqry view
            $viewStructure = $this->getViewStructure();
            
            if (empty($viewStructure)) {
                // Log the error for debugging
                Log::error('ProductQueryController: Cannot access productsqry view', $dbInfo);
                
                return view('ams.product-query.index', [
                    'products' => collect(),
                    'categories' => collect(),
                    'error' => 'The productsqry view does not exist in the database or cannot be accessed.',
                    'structure' => [],
                    'dbInfo' => $dbInfo
                ]);
            }
            
            // Log the structure for debugging
            Log::info('ProductQueryController: View structure found', [
                'structure' => $viewStructure,
                'db_info' => $dbInfo
            ]);
            
            // Column mappings - define expected column names and possible alternatives
            $columnMap = $this->determineColumnMap($viewStructure);
            
            // Get search params
            $search = $request->input('search');
            $category = $request->input('category');
            
            // Query the productsqry view from the demodb database
            $query = DB::connection('mysql_second')
                ->table('productsqry');
                
            // Apply search filters if provided
            if ($search) {
                $query->where(function($q) use ($search, $columnMap) {
                    // Only search in columns that exist
                    if ($columnMap['product_name']) {
                        $q->where($columnMap['product_name'], 'like', "%{$search}%");
                    }
                    
                    if ($columnMap['item_no']) {
                        $q->orWhere($columnMap['item_no'], 'like', "%{$search}%");
                    }
                    
                    if ($columnMap['description']) {
                        $q->orWhere($columnMap['description'], 'like', "%{$search}%");
                    }
                });
            }
            
            if ($category && $columnMap['category']) {
                $query->where($columnMap['category'], $category);
            }
            
            // Get all distinct category names for the filter dropdown (if the column exists)
            $categories = collect();
            if ($columnMap['category']) {
                $categories = DB::connection('mysql_second')
                    ->table('productsqry')
                    ->select($columnMap['category'])
                    ->distinct()
                    ->orderBy($columnMap['category'])
                    ->pluck($columnMap['category']);
            }
                
            // Paginate results
            $products = $query->paginate(20);
            
            // Build the product tree structure for products with non-null mjcatname
            $productTree = $this->buildProductTree($columnMap);
            
            return view('ams.product-query.index', [
                'products' => $products, 
                'categories' => $categories, 
                'search' => $search, 
                'category' => $category,
                'columnMap' => $columnMap,
                'structure' => $viewStructure,
                'dbInfo' => $dbInfo,
                'productTree' => $productTree
            ]);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('ProductQueryController: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return error view with exception details
            return view('ams.product-query.index', [
                'products' => collect(),
                'categories' => collect(),
                'error' => $e->getMessage(),
                'structure' => [],
                'dbInfo' => isset($dbInfo) ? $dbInfo : []
            ]);
        }
    }
    
    /**
     * Get the structure of the productsqry view
     *
     * @return array
     */
    private function getViewStructure()
    {
        try {
            $structure = DB::connection('mysql_second')->select('DESCRIBE productsqry');
            return collect($structure)->pluck('Type', 'Field')->toArray();
        } catch (\Exception $e) {
            Log::error('ProductQueryController: Error getting view structure', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }
    
    /**
     * Determine the column mapping based on the view structure
     *
     * @param array $structure
     * @return array
     */
    private function determineColumnMap($structure)
    {
        $columnNames = array_keys($structure);
        
        // Define possible column name variations
        $possibleNames = [
            'product_name' => ['product_name', 'productname', 'name', 'title'],
            'item_no' => ['item_no', 'itemno', 'item_number', 'itemnumber', 'sku'],
            'description' => ['description', 'desc', 'product_description'],
            'category' => ['family_category_name', 'category_name', 'category', 'categoryname'],
            'price' => ['price_per_unit', 'price', 'unit_price', 'unitprice'],
            'id' => ['product_id', 'id', 'productid']
        ];
        
        // Create the mapping
        $columnMap = [];
        foreach ($possibleNames as $key => $alternateNames) {
            $columnMap[$key] = null;
            
            // Find the first match in the actual columns
            foreach ($alternateNames as $name) {
                if (in_array($name, $columnNames)) {
                    $columnMap[$key] = $name;
                    break;
                }
            }
        }
        
        return $columnMap;
    }
    
    /**
     * Build the product tree structure (categories -> subcategories -> products)
     * Only includes products where mjcatname is not null
     *
     * @param array $columnMap
     * @return array
     */
    private function buildProductTree($columnMap)
    {
        try {
            $query = DB::connection('mysql_second')
                ->table('productsqry')
                ->whereNotNull('mjcatname'); // Only include products where mjcatname is not null
            
            // Select necessary columns for the tree structure
            $query->select([
                'id',
                'product_name',
                'mjcatname',
                'cat_name',
                'cat_id_fk',
                'categories_id',
                'item_no',
                'producttree',
                'parent'
            ]);
            
            $products = $query->get();
            
            // Initialize the tree structure
            $tree = [];
            
            // Group products by major category
            $groupedByMajorCategory = $products->groupBy('mjcatname');
            
            foreach ($groupedByMajorCategory as $majorCategory => $majorCategoryProducts) {
                $categoryNode = [
                    'name' => $majorCategory,
                    'type' => 'major_category',
                    'children' => []
                ];
                
                // Group by category
                $groupedByCategory = $majorCategoryProducts->groupBy('cat_name');
                
                foreach ($groupedByCategory as $category => $categoryProducts) {
                    $subCategoryNode = [
                        'name' => $category,
                        'type' => 'category',
                        'children' => []
                    ];
                    
                    // Add products to the subcategory
                    foreach ($categoryProducts as $product) {
                        $subCategoryNode['children'][] = [
                            'id' => $product->id,
                            'name' => $product->product_name,
                            'item_no' => $product->item_no,
                            'type' => 'product',
                            'product' => $product // Store full product details
                        ];
                    }
                    
                    $categoryNode['children'][] = $subCategoryNode;
                }
                
                $tree[] = $categoryNode;
            }
            
            return $tree;
        } catch (\Exception $e) {
            Log::error('ProductQueryController: Error building product tree', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }
}
