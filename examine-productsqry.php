<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Productsqry Table Structure ===\n";
    $columns = DB::connection('mysql_second')->select('SHOW COLUMNS FROM productsqry');
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})" . ($col->Key ? " [KEY: {$col->Key}]" : "") . "\n";
    }
    
    echo "\n=== Sample Products for Wood Fence Category (ID 4: Tongue & Groove Cedar) ===\n";
    $products = DB::connection('mysql_second')
        ->table('productsqry')
        ->where('categories_id', 4)
        ->select('product_id', 'item_no', 'product_name', 'style', 'specialty', 'spacing', 'size', 'color', 'price')
        ->limit(3)
        ->get();
    
    if (count($products) > 0) {
        foreach ($products as $product) {
            echo "ID: {$product->product_id}, Item #: {$product->item_no}\n";
            echo "Name: {$product->product_name}\n";
            echo "Style: " . ($product->style ?? 'N/A') . ", Specialty: " . ($product->specialty ?? 'N/A') . "\n";
            echo "Spacing: " . ($product->spacing ?? 'N/A') . ", Size: " . ($product->size ?? 'N/A') . "\n";
            echo "Color: " . ($product->color ?? 'N/A') . ", Price: $" . ($product->price ?? 'N/A') . "\n\n";
        }
    } else {
        echo "No products found for this category.\n";
        
        // Try another category
        echo "\n=== Sample Products for Wood Fence Category (ID 5: Stockade Wood Fence) ===\n";
        $products = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', 5)
            ->select('product_id', 'item_no', 'product_name', 'style', 'specialty', 'spacing', 'size', 'color', 'price')
            ->limit(3)
            ->get();
            
        if (count($products) > 0) {
            foreach ($products as $product) {
                echo "ID: {$product->product_id}, Item #: {$product->item_no}\n";
                echo "Name: {$product->product_name}\n";
                echo "Style: " . ($product->style ?? 'N/A') . ", Specialty: " . ($product->specialty ?? 'N/A') . "\n";
                echo "Spacing: " . ($product->spacing ?? 'N/A') . ", Size: " . ($product->size ?? 'N/A') . "\n";
                echo "Color: " . ($product->color ?? 'N/A') . ", Price: $" . ($product->price ?? 'N/A') . "\n\n";
            }
        } else {
            echo "No products found for this category either.\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
