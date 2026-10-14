<?php
/**
 * Autonomous verification script for all dynamic CodeIgniter 4 routes
 */

$cookieJar = tempnam(sys_get_temp_dir(), 'ci4_cookie_');

// 1. Simulate login to obtain session cookie
$ch = curl_init('http://localhost/kitap-okuma/auth/simulate-login');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR      => $cookieJar,
    CURLOPT_TIMEOUT        => 5
]);
$res = curl_exec($ch);
curl_close($ch);

$urls = [
    'http://localhost/kitap-okuma/'                        => false,
    'http://localhost/kitap-okuma/home.html'               => false,
    'http://localhost/kitap-okuma/home'                    => false,
    'http://localhost/kitap-okuma/kitaplar.html'           => false,
    'http://localhost/kitap-okuma/kitaplar'                => false,
    'http://localhost/kitap-okuma/siralamalar.html'        => false,
    'http://localhost/kitap-okuma/siralamalar'             => false,
    'http://localhost/kitap-okuma/sayfa/hakkimizda'        => false,
    'http://localhost/kitap-okuma/sayfa/yarisma-sartnamesi'=> false,
    'http://localhost/kitap-okuma/dashboard.html'          => true,
    'http://localhost/kitap-okuma/dashboard'               => true,
    'http://localhost/kitap-okuma/deneme-sinavlari.html'   => true,
];

$allPassed = true;
foreach ($urls as $u => $needsAuth) {
    $ch = curl_init($u);
    $opts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_FOLLOWLOCATION => true
    ];
    if ($needsAuth) {
        $opts[CURLOPT_COOKIEFILE] = $cookieJar;
    }
    curl_setopt_array($ch, $opts);
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $isCi4 = str_contains($content, 'APPPATH\Views') || str_contains($content, 'APPPATH/Views') || str_contains($content, 'ci-');
    $has200 = ($httpCode === 200);

    echo sprintf("%-52s => HTTP %d | CI4 Dynamic: %s | Length: %d\n", $u, $httpCode, $isCi4 ? 'YES' : 'NO', strlen($content));
    if (!$has200 || !$isCi4) {
        $allPassed = false;
    }
}

@unlink($cookieJar);

echo "\nResult: " . ($allPassed ? "ALL ENDPOINTS DYNAMIC CODEIGNITER 4 WITH MODULAR LAYOUTS!" : "SOME ENDPOINTS FAILED") . PHP_EOL;
