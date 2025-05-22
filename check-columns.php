<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Check first row in productsqry to see its structure
    echo "=== First Row in productsqry ===\n";
    
    $product = DB::connection('academyfence')
        ->table('productsqry')
        ->first();
    
    if ($product) {
        // Get all properties (columns) of the product object
        $columns = array_keys(get_object_vars($product));
        echo "Columns found in productsqry: " . implode(', ', $columns) . "\n\n";
        
        // Display the first product's data
        echo "Sample product data:\n";
        foreach ($columns as $column) {
            echo "- $column: " . (is_null($product->$column) ? 'NULL' : $product->$column) . "\n";
        }
    } else {
        echo "No products found in the productsqry table.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
