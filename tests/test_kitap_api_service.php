<?php

$baseUrl = 'http://localhost/kitap-okuma/public';

echo "=== KITAP OKUMA AYRIK API SERVISI TESTLERI ===\n\n";

$endpoints = [
    'GET /api/v1/health'            => "$baseUrl/api/v1/health",
    'GET /api/v1/books'             => "$baseUrl/api/v1/books",
    'GET /api/v1/books/11'          => "$baseUrl/api/v1/books/11",
    'GET /api/v1/books/11/pages'    => "$baseUrl/api/v1/books/11/pages",
    'GET /api/v1/books/11/audio-sync' => "$baseUrl/api/v1/books/11/audio-sync",
    'GET /api/v1/exams'             => "$baseUrl/api/v1/exams",
    'GET /api/v1/exams/101'         => "$baseUrl/api/v1/exams/101",
    'GET /api/v1/leaderboard'       => "$baseUrl/api/v1/leaderboard",
    'GET /api/v1/stats'             => "$baseUrl/api/v1/stats",
    'GET /api/v1/pages'             => "$baseUrl/api/v1/pages",
    'GET /api/v1/pages/hakkimizda'  => "$baseUrl/api/v1/pages/hakkimizda",
    'GET /api/v1/faqs'              => "$baseUrl/api/v1/faqs",
];

$allPassed = true;

foreach ($endpoints as $label => $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($response, true);
    $status = ($httpCode === 200 && is_array($json)) ? 'OK' : 'FAIL';
    if ($status === 'FAIL') $allPassed = false;

    echo "[$status] $label -> HTTP $httpCode (" . strlen($response) . " bytes)\n";
    if (is_array($json)) {
        $keys = array_keys($json);
        echo "       Alanlar: " . implode(', ', array_slice($keys, 0, 5)) . "\n";
    } else {
        echo "       HATA: Yanıt JSON formatında değil: " . substr($response, 0, 100) . "\n";
    }
}

echo "\n--- Sınav Gönderme (POST submitExam) Testi ---\n";
$ch = curl_init("$baseUrl/api/v1/exams/101/submit");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'user_id' => 1001,
    'answers' => [1 => 'B', 2 => 'A', 3 => 'B']
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$subResp = curl_exec($ch);
$subCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "POST /api/v1/exams/101/submit -> HTTP $subCode\n";
echo "Cevap: $subResp\n";

echo "\n--- Oturum ve İlerleme Senkronizasyonu (POST progress/sync) Testi ---\n";
$cookieFile = __DIR__ . '/test_cookie.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

// 1. Simüle login
$ch = curl_init("$baseUrl/auth/simulate-login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
$logResp = curl_exec($ch);
curl_close($ch);
echo "Simulate Login: " . substr($logResp, 0, 80) . "...\n";

// 2. İlerleme Kaydet
$ch = curl_init("$baseUrl/api/v1/progress/sync");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'book_id'      => 11,
    'page'         => 35,
    'audio_time'   => 145.2,
    'read_seconds' => 600,
    'is_completed' => 0
]));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$syncResp = curl_exec($ch);
$syncCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "POST /api/v1/progress/sync -> HTTP $syncCode\n";
echo "Cevap: $syncResp\n";

// 3. İlerlemeyi Doğrula
$ch = curl_init("$baseUrl/api/v1/progress/1001/11");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$getResp = curl_exec($ch);
curl_close($ch);
echo "GET /api/v1/progress/1001/11 -> $getResp\n";

if (file_exists($cookieFile)) unlink($cookieFile);

echo "\n=== TESTLER TAMAMLANDI ===\n";
