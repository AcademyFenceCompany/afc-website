<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Get a list of all columns in productsqry
    $columnsQuery = "SELECT COLUMN_NAME 
                    FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_SCHEMA = 'afcwebsite_shop'
                    AND TABLE_NAME = 'productsqry'";
                    
    $columns = DB::connection('academyfence')->select($columnsQuery);
    
    echo "=== Productsqry Columns ===\n";
    if ($columns) {
        foreach ($columns as $column) {
            echo "- " . $column->COLUMN_NAME . "\n";
        }
    } else {
        echo "Could not retrieve columns.\n";
    }
    
    // Get a sample wood fence product
    echo "\n=== Sample Wood Fence Products ===\n";
    $products = DB::connection('academyfence')
        ->table('productsqry')
        ->join('categories', 'productsqry.categories_id', '=', 'categories.id')
        ->where('categories.majorcategories_id', 1)
        ->select(
            'productsqry.id', 
            'productsqry.product_name', 
            'productsqry.item_no',
            'productsqry.categories_id',
            'productsqry.style',
            'productsqry.speciality',
            'productsqry.spacing',
            'productsqry.size',
            'productsqry.price',
            'categories.cat_name'
        )
        ->limit(3)
        ->get();
    
    if (count($products) > 0) {
        foreach ($products as $product) {
            echo "Product Name: " . $product->product_name . "\n";
            echo "  Item #: " . $product->item_no . "\n";
            echo "  Category: " . $product->cat_name . " (ID: " . $product->categories_id . ")\n";
            echo "  Style: " . ($product->style ?? 'N/A') . "\n";
            echo "  speciality: " . ($product->speciality ?? 'N/A') . "\n";
            echo "  Spacing: " . ($product->spacing ?? 'N/A') . "\n";
            echo "  Size: " . ($product->size ?? 'N/A') . "\n";
            echo "  Price: $" . ($product->price ?? 'N/A') . "\n\n";
        }
    } else {
        echo "No wood fence products found.\n";
        
        // Check if products with categories_id exist
        $anyProducts = DB::connection('academyfence')
            ->table('productsqry')
            ->whereNotNull('categories_id')
            ->limit(1)
            ->count();
            
        echo "Products with categories_id: " . ($anyProducts > 0 ? "YES" : "NO") . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
