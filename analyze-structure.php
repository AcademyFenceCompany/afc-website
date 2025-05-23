<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "PHP Error: $errstr\n";
    return true;
});

try {
    // Part 1: Analyze Categories
    echo "=== Wood Fence Categories (Major Category ID = 1) ===\n";
    $categories = DB::connection('academyfence')
        ->table('categories')
        ->where('majorcategories_id', 1)
        ->select('id', 'cat_name', 'seo_name')
        ->get();
        
    foreach ($categories as $category) {
        echo "ID: {$category->id}, Name: {$category->cat_name}\n";
    }
    
    // Part 2: Analyze Productsqry Structure
    echo "\n=== Productsqry Structure Analysis ===\n";
    // Get one product to check its actual structure
    $product = DB::connection('academyfence')
        ->table('productsqry')
        ->first();
        
    if ($product) {
        $columns = array_keys(get_object_vars($product));
        echo "Available columns: " . implode(', ', $columns) . "\n\n";
        
        // Check for key columns we need
        $requiredColumns = ['id', 'product_name', 'item_no', 'categories_id', 'style', 'spacing', 'size', 'color', 'price'];
        $missingColumns = [];
        
        foreach ($requiredColumns as $column) {
            if (!property_exists($product, $column)) {
                $missingColumns[] = $column;
            }
        }
        
        if (!empty($missingColumns)) {
            echo "Missing columns in productsqry: " . implode(', ', $missingColumns) . "\n";
        } else {
            echo "All required columns exist in productsqry.\n";
        }
    }
    
    // Part 3: Get Product Data for Category 4 (Tongue & Groove Cedar)
    echo "\n=== Sample Products for Tongue & Groove Cedar (ID: 4) ===\n";
    $products = DB::connection('academyfence')
        ->table('productsqry')
        ->where('categories_id', 4)
        ->select('id', 'product_name', 'item_no', 'categories_id', 'style', 'size', 'spacing', 'color', 'price')
        ->limit(3)
        ->get();
        
    if (count($products) > 0) {
        foreach ($products as $product) {
            echo "ID: {$product->id}, Name: {$product->product_name}\n";
            echo "Item #: {$product->item_no}, Category ID: {$product->categories_id}\n";
            echo "Style: " . ($product->style ?? 'N/A') . "\n";
            echo "Size: " . ($product->size ?? 'N/A') . ", Spacing: " . ($product->spacing ?? 'N/A') . "\n";
            echo "Color: " . ($product->color ?? 'N/A') . ", Price: $" . ($product->price ?? 'N/A') . "\n\n";
        }
    } else {
        echo "No products found for this category.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
