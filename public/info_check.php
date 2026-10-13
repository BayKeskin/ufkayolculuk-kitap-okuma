<?php
header('Content-Type: text/plain; charset=utf-8');
ini_set('display_errors', '1');
error_reporting(E_ALL);

echo "=== DIAGNOSTIC & LOG CHECK ===\n";

$logFiles = glob(dirname(__DIR__) . '/writable/logs/*.log');
if (empty($logFiles)) {
    echo "No log files found in writable/logs/!\n";
} else {
    foreach ($logFiles as $logFile) {
        echo "=== LOG: " . basename($logFile) . " ===\n";
        $content = file_get_contents($logFile);
        $lines = explode("\n", trim($content));
        $lastLines = array_slice($lines, -40);
        echo implode("\n", $lastLines) . "\n\n";
    }
}

echo "=== TRYING TO BOOT CI4 DIRECTLY ===\n";
try {
    define('ENVIRONMENT', 'development');
    require_once dirname(__DIR__) . '/app/Config/Paths.php';
    $paths = new Config\Paths();
    require_once $paths->systemDirectory . '/Boot.php';
    echo "Boot class loaded. Running Boot::bootWeb in try-catch...\n";
    CodeIgniter\Boot::bootWeb($paths);
} catch (\Throwable $e) {
    echo "CAUGHT EXCEPTION: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line " . $e->getLine() . ")\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
