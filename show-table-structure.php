<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Check categories table structure
    echo "=== Categories Table Structure ===\n";
    $columns = DB::connection('mysql_second')->select('SHOW COLUMNS FROM categories');
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})" . ($col->Key ? " [KEY: {$col->Key}]" : "") . "\n";
    }
    
    echo "\n=== Productsqry Table Structure ===\n";
    $columns = DB::connection('mysql_second')->select('SHOW COLUMNS FROM productsqry');
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})" . ($col->Key ? " [KEY: {$col->Key}]" : "") . "\n";
    }
    
    echo "\n=== Sample Categories ===\n";
    $categories = DB::connection('mysql_second')
        ->table('categories')
        ->where('majorcategories_id', 1)
        ->select('id', 'cat_name', 'seo_name', 'cat_desc_long')
        ->limit(3)
        ->get();
    foreach ($categories as $cat) {
        echo "ID: {$cat->id}, Name: {$cat->cat_name}\n";
    }
    
    echo "\n=== Sample Products ===\n";
    if (count($categories) > 0) {
        $firstCategoryId = $categories[0]->id;
        $products = DB::connection('mysql_second')
            ->table('productsqry')
            ->where('categories_id', $firstCategoryId)
            ->select('product_id', 'item_no', 'product_name', 'style', 'speciality', 'spacing', 'size')
            ->limit(3)
            ->get();
        foreach ($products as $product) {
            echo "ID: {$product->product_id}, Name: {$product->product_name}\n";
            echo "  Style: " . ($product->style ?? 'N/A') . ", speciality: " . ($product->speciality ?? 'N/A') . "\n";
            echo "  Spacing: " . ($product->spacing ?? 'N/A') . ", Size: " . ($product->size ?? 'N/A') . "\n\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
