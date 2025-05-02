<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Echo schema information (no data manipulation)
echo "=== MySQL Second Database Schema ===\n\n";

// Get all tables
$tables = DB::connection('mysql_second')
    ->select('SHOW TABLES');

echo "Tables in database:\n";
foreach ($tables as $table) {
    $tableName = reset($table);
    echo "- $tableName\n";
}

echo "\n=== Categories Table Structure ===\n\n";
$columns = DB::connection('mysql_second')
    ->select('SHOW COLUMNS FROM categories');
echo "Columns in categories table:\n";
foreach ($columns as $col) {
    echo "- {$col->Field} ({$col->Type})" . ($col->Key ? " [KEY: {$col->Key}]" : "") . "\n";
}

echo "\n=== Productsqry Table Structure ===\n\n";
$columns = DB::connection('mysql_second')
    ->select('SHOW COLUMNS FROM productsqry');
echo "Columns in productsqry table:\n";
foreach ($columns as $col) {
    echo "- {$col->Field} ({$col->Type})" . ($col->Key ? " [KEY: {$col->Key}]" : "") . "\n";
}

// Sample data (top 5 rows only, no sensitive data)
echo "\n=== Categories Sample (5 rows) ===\n\n";
$sampleCategories = DB::connection('mysql_second')
    ->table('categories')
    ->select('id', 'cat_name', 'majorcategories_id')
    ->limit(5)
    ->get();

foreach ($sampleCategories as $cat) {
    echo "ID: {$cat->id}, Name: {$cat->cat_name}, Major Category ID: {$cat->majorcategories_id}\n";
}

echo "\n=== Productsqry Sample (5 rows) ===\n\n";
$sampleProducts = DB::connection('mysql_second')
    ->table('productsqry')
    ->select('product_id', 'item_no', 'product_name', 'categories_id', 'style', 'spacing')
    ->limit(5)
    ->get();

foreach ($sampleProducts as $product) {
    echo "Product ID: {$product->product_id}, Item #: {$product->item_no}, Name: {$product->product_name}, Category ID: {$product->categories_id}\n";
    echo "  Style: " . ($product->style ?? 'N/A') . ", Spacing: " . ($product->spacing ?? 'N/A') . "\n";
}
