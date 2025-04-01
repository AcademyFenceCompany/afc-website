<?php

/**
 * Redirect to the public folder
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Redirect to public folder
require_once __DIR__.'/public/index.php';
