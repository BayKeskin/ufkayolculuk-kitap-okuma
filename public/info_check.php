<?php
header('Content-Type: text/plain; charset=utf-8');
echo "=== CI4 BOOT TEST ===\n";

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(FCPATH);

require FCPATH . '../app/Config/Paths.php';
$paths = new \Config\Paths();
require $paths->systemDirectory . '/Boot.php';

try {
    echo "Booting web...\n";
    // We catch exceptions manually
    $app = \CodeIgniter\Config\Services::codeigniter();
    $app->initialize();
    echo "CI4 Initialized successfully!\n";

    echo "Testing session service...\n";
    $session = service('session');
    echo "Session service instantiated!\n";

    echo "Testing request handling...\n";
    $response = $app->run();
    echo "App run status code: " . $response->getStatusCode() . "\n";
    echo "App body snippet: " . substr(strip_tags($response->getBody()), 0, 200) . "\n";
} catch (\Throwable $e) {
    echo "\n!!! CAUGHT EXCEPTION !!!\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line " . $e->getLine() . ")\n";
    echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
}
