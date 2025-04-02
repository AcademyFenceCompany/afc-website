<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Get sample wood fence categories
    echo "=== Sample Wood Fence Categories (MajorCategory ID=1) ===\n";
    $categories = DB::connection('mysql_second')
        ->table('categories')
        ->where('majorcategories_id', 1)
        ->select('id', 'cat_name')
        ->limit(5)
        ->get()
        ->toArray();
    
    foreach ($categories as $cat) {
        echo "ID: {$cat->id}, Name: {$cat->cat_name}\n";
    }
    
    // Get a sample product to see its structure
    echo "\n=== Sample Product (first one we find) ===\n";
    $product = DB::connection('mysql_second')
        ->table('productsqry')
        ->first();
    
    if ($product) {
        echo "Product ID: {$product->product_id}\n";
        echo "Item No: {$product->item_no}\n";
        echo "Name: {$product->product_name}\n";
        
        // Check if certain fields exist in the product
        $fields = ['style', 'specialty', 'spacing', 'size', 'categories_id', 'color', 'price'];
        foreach ($fields as $field) {
            if (property_exists($product, $field)) {
                echo "$field: " . ($product->$field ?? 'N/A') . "\n";
            } else {
                echo "$field: NOT FOUND IN SCHEMA\n";
            }
        }
    } else {
        echo "No products found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
