<?php
$urls = [
    'http://localhost/kitap-okuma/',
    'http://localhost/kitap-okuma/home.html',
    'http://localhost/kitap-okuma/kitaplar',
    'http://localhost/kitap-okuma/kitaplar.html',
    'http://localhost/kitap-okuma/api/v1/health',
    'http://localhost/kitap-okuma/api/v1/books',
];

foreach ($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    echo "$url -> HTTP $code (" . strlen($resp) . " bytes)\n";
    if (strpos($resp, 'Fatal error') !== false || strpos($resp, 'Exception') !== false) {
        echo "  [ERROR DETECTED in response!]\n";
    }
}
