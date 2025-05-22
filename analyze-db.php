<?php

// This script analyzes the database structure to help debug issues

// Connect to the academyfence database
$host = getenv('DB_SECOND_HOST') ?: '127.0.0.1';
$port = getenv('DB_SECOND_PORT') ?: '3306';
$database = getenv('DB_SECOND_DATABASE') ?: 'mysql2';
$username = getenv('DB_SECOND_USERNAME') ?: 'root';
$password = getenv('DB_SECOND_PASSWORD') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully to database: $database\n\n";
    
    // Get table structure for customers table
    $stmt = $pdo->query("DESCRIBE customers");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Customers table structure:\n";
    echo "-------------------------\n";
    foreach ($columns as $column) {
        echo "Field: " . $column['Field'] . ", Type: " . $column['Type'] . ", Key: " . $column['Key'] . "\n";
    }
    
    // Get the first few records from the customers table
    echo "\nSample customer records:\n";
    echo "----------------------\n";
    $stmt = $pdo->query("SELECT * FROM customers LIMIT 3");
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($customers as $customer) {
        echo "Customer record:\n";
        foreach ($customer as $key => $value) {
            echo "  $key: $value\n";
        }
        echo "\n";
    }
    
    // Check for cust_addresses table
    echo "Checking cust_addresses table:\n";
    echo "----------------------------\n";
    $stmt = $pdo->query("DESCRIBE cust_addresses");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "Field: " . $column['Field'] . ", Type: " . $column['Type'] . ", Key: " . $column['Key'] . "\n";
    }
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
