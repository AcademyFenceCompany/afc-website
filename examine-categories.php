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
    
    echo "\n=== Sample Wood Fence Categories ===\n";
    $categories = DB::connection('mysql_second')
        ->table('categories')
        ->where('majorcategories_id', 1)
        ->select('id', 'cat_name', 'seo_name')
        ->limit(5)
        ->get();
    foreach ($categories as $cat) {
        echo "ID: {$cat->id}, Name: {$cat->cat_name}, SEO Name: {$cat->seo_name}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
