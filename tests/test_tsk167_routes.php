<?php

$urls = [
    'http://localhost/kitap-okuma/kitap-oku',
    'http://localhost/kitap-okuma/kitap-oku?book=tevhid-muhafizlari&page=5',
    'http://localhost/kitap-okuma/kitap-oku?book=kuslarin-cagrisi&page=1',
    'http://localhost/kitap-okuma/kitapoku',
    'http://localhost/kitap-okuma/kitapoku.html',
    'http://localhost/kitap-okuma/kitap-oku.html',
    'http://localhost/kitap-okuma/kitap_oku',
    'http://localhost/kitap-okuma/kitap_oku.html',
    'http://localhost/kitap-okuma/dashboard',
];

$allPassed = true;

foreach ($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Do not follow redirects
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    curl_close($ch);

    $isRedirect = ($httpCode >= 300 && $httpCode < 400);
    $location = '';
    if (preg_match('/Location:\s*([^\r\n]+)/i', $header, $m)) {
        $location = trim($m[1]);
    }

    $containsUfka = str_contains($header, 'ufkayolculuk.com') || str_contains($location, 'ufkayolculuk.com');

    echo "Testing $url\n";
    echo "  -> Status: HTTP $httpCode\n";
    if ($isRedirect) {
        echo "  -> Redirect Location: $location\n";
    }
    if ($containsUfka) {
        echo "  -> [FAIL] Contains external ufkayolculuk.com reference!\n";
        $allPassed = false;
    } elseif ($httpCode === 200) {
        echo "  -> [PASS] HTTP 200 OK (Rendered cleanly)\n";
    } else {
        echo "  -> [WARNING] HTTP $httpCode\n";
        $allPassed = false;
    }
    echo "--------------------------------------------------------\n";
}

if ($allPassed) {
    echo "\n>>> ALL ROUTE TESTS PASSED SUCCESSFULLY! ZERO EXTERNAL REDIRECTS! <<<\n";
    exit(0);
} else {
    echo "\n>>> SOME TESTS FAILED! <<<\n";
    exit(1);
}
