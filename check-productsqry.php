<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check if productsqry has 'categories_id' column
try {
    $hasColumn = Schema::connection('mysql_second')->hasColumn('productsqry', 'categories_id');
    echo "productsqry has categories_id column: " . ($hasColumn ? "YES" : "NO") . "\n";
    
    // List the first 20 columns in productsqry
    $columns = DB::connection('mysql_second')->select('SHOW COLUMNS FROM productsqry LIMIT 20');
    echo "First 20 columns in productsqry:\n";
    foreach ($columns as $col) {
        echo "- {$col->Field} ({$col->Type})\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
