<?php

$routes = [
    '/' => 200,
    '/kitaplar' => 200,
    '/kitaplar?year=archive' => 200,
    '/kitap-oku?book=tevhid-muhafizlari&page=5' => 200,
    '/siralamalar' => 200,
    '/sayfa/hakkimizda' => 200,
    '/sayfa/sss' => 200,
    // Authenticated simulation
    '/auth/simulate-login' => 200,
    '/deneme-sinavlari' => 200,
    '/dashboard' => 200,
    '/sinav-ekrani?sinav=genel' => 200,
];

$cookieJar = tempnam(sys_get_temp_dir(), 'curl_cookie_');
$allPassed = true;

foreach ($routes as $route => $expectedCode) {
    $url = 'http://localufkkitap.com' . $route;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $status = ($httpCode === $expectedCode) ? "PASS" : "FAIL (got $httpCode, expected $expectedCode)";
    if ($httpCode !== $expectedCode) {
        $allPassed = false;
    }
    echo sprintf("[%s] %s -> HTTP %d\n", $status, $url, $httpCode);

    // Also check that rendered HTML on 200 responses does not have href="...html"
    if ($httpCode === 200) {
        if (preg_match('/href="[^"]+\.html[^"]*"/', $response, $matches)) {
            echo "   WARNING: Found legacy .html href in response: " . $matches[0] . "\n";
            $allPassed = false;
        }
    }
}

unlink($cookieJar);

if ($allPassed) {
    echo "\nALL ROUTES PASSED PERFECTLY WITH ZERO .HTML LINKS!\n";
    exit(0);
} else {
    echo "\nSOME ROUTES FAILED OR CONTAINED .HTML LINKS!\n";
    exit(1);
}
