<?php
$cookieFile = __DIR__ . '/reader_cookie.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

// 1. Simulate login to obtain session cookie
$ch = curl_init('http://localhost/kitap-okuma/auth/simulate-login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
$loginResp = curl_exec($ch);
curl_close($ch);
echo "Simulate login response: " . trim($loginResp) . "\n\n";

$testUrls = [
    'http://localhost/kitap-okuma/kitap-oku.html',
    'http://localhost/kitap-okuma/kitap-oku.html?book_id=8',
    'http://localhost/kitap-okuma/kitap-oku.html?book_id=11&start_page=5',
    'http://localhost/kitap-okuma/kitap-oku.html?book=gordugume-gormedigime&page=20',
    'http://localhost/kitap-okuma/kitap-oku.html?book=13&audio=1'
];

foreach ($testUrls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$url -> HTTP $code (" . strlen($resp) . " bytes)\n";
    if (strpos($resp, 'Fatal error') !== false || strpos($resp, 'Exception') !== false) {
        echo "  [ERROR DETECTED in response!]\n";
    }
    if (strpos($resp, 'window.ACTIVE_BOOK =') !== false) {
        echo "  -> Found window.ACTIVE_BOOK\n";
    }
    // Check title in response
    if (preg_match('/<title>(.*?)<\/title>/', $resp, $matches)) {
        echo "  -> Title: " . $matches[1] . "\n";
    }
}

if (file_exists($cookieFile)) unlink($cookieFile);
