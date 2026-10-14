<?php

$urls = [
    'http://localhost/kitap-okuma/public/',
    'http://localhost/kitap-okuma/public/kitaplar',
    'http://localhost/kitap-okuma/public/sayfa?slug=hakkimizda',
    'http://localhost/kitap-okuma/public/siralamalar',
    'http://localhost/kitap-okuma/public/api/v1/health',
    'http://localhost/kitap-okuma/public/api/v1/books',
];

foreach ($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "=== URL: $url ===\n";
    echo "HTTP Status: $code | Size: " . strlen($html) . " bytes\n";
    if (strpos($html, 'Fatal error') !== false || strpos($html, 'Parse error') !== false || strpos($html, 'Exception') !== false) {
        echo "ERROR: PHP Hatası veya istisna tespit edildi!\n";
    } else {
        echo "SUCCESS: Sayfa sorunsuz yüklendi.\n";
    }
    echo "\n";
}
