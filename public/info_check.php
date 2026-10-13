<?php
header('Content-Type: text/plain; charset=utf-8');
echo "=== SERVER DIAGNOSTIC ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . "\n\n";

$vendorAutoload = dirname(__DIR__) . '/vendor/autoload.php';
echo "Vendor Autoload Path: " . $vendorAutoload . "\n";
echo "Vendor Autoload Exists: " . (file_exists($vendorAutoload) ? 'YES' : 'NO') . "\n\n";

$writable = dirname(__DIR__) . '/writable';
echo "Writable Dir: " . $writable . "\n";
echo "Writable Exists: " . (is_dir($writable) ? 'YES' : 'NO') . "\n";
echo "Writable Is Writable: " . (is_writable($writable) ? 'YES' : 'NO') . "\n\n";

$appPaths = dirname(__DIR__) . '/app/Config/Paths.php';
echo "Paths.php Exists: " . (file_exists($appPaths) ? 'YES' : 'NO') . "\n";

if (file_exists($vendorAutoload)) {
    echo "Attempting composer autoload require...\n";
    try {
        require_once $vendorAutoload;
        echo "Composer autoload required successfully!\n";
    } catch (\Throwable $e) {
        echo "Composer require ERROR: " . $e->getMessage() . "\n";
    }
}
