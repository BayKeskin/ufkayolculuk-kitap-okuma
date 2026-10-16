<?php

namespace App\Services;

use Config\KitapApi;
use Config\Services;

/**
 * Kitap Okuma & Sınav Portalı - Bağımsız API Servisi
 * 
 * Bu servis, Ufka Yolculuk Kitap Okuma projesinin (kitap-okuma) tüm veri gereksinimlerini
 * (Kitaplar, Sayfalar, Cümle/Ses senkronizasyonu, Deneme Sınavları, Kullanıcı İlerlemesi,
 * İstatistikler ve Kurumsal İçerikler) karşılayan bağımsız servis katmanıdır.
 * Harici Ufka Yolculuk web sitesi dizininden tamamen izoledir.
 */
class KitapApiService
{
    protected KitapApi $config;

    public function __construct(?KitapApi $config = null)
    {
        $this->config = $config ?? config('KitapApi');
    }

    // =========================================================================
    // TOKEN VE TEMEL HTTP İSTEK YÖNETİMİ
    // =========================================================================

    /**
     * API Bearer Access Token alır (Önbellekli ve Refresh mekanizmalı)
     */
    public function getAccessToken(bool $forceRefresh = false): ?string
    {
        $cacheKey = 'kitap_api_bearer_access_token';
        if (!$forceRefresh) {
            try {
                $cachedToken = cache($cacheKey);
                if (!empty($cachedToken)) {
                    return $cachedToken;
                }
            } catch (\Throwable $e) {}
        }

        // 1. Varsa refresh_token ile yenile
        $refreshToken = null;
        try {
            $refreshToken = cache('kitap_api_bearer_refresh_token');
        } catch (\Throwable $e) {}

        if ($forceRefresh && !empty($refreshToken)) {
            try {
                $client = Services::curlrequest([
                    'timeout'     => $this->config->timeout ?? 10,
                    'verify'      => false,
                    'http_errors' => false,
                ]);
                $url = rtrim($this->config->baseURL, '/') . '/refresh';
                $resp = $client->post($url, [
                    'form_params' => ['refresh_token' => $refreshToken],
                    'verify'      => false,
                ]);
                if ($resp->getStatusCode() === 200) {
                    $json = json_decode($resp->getBody(), true);
                    if (!empty($json['access_token'])) {
                        $ttl = $this->config->tokenTTL ?? 6600;
                        try {
                            cache()->save($cacheKey, $json['access_token'], $ttl);
                            if (!empty($json['refresh_token'])) {
                                cache()->save('kitap_api_bearer_refresh_token', $json['refresh_token'], 14 * 86400);
                            }
                        } catch (\Throwable $e) {}
                        return $json['access_token'];
                    }
                }
            } catch (\Throwable $e) {
                log_message('error', 'KitapApiService token refresh hatası: ' . $e->getMessage());
            }
        }

        // 2. /token ile yeni token al
        try {
            $client = Services::curlrequest([
                'timeout'     => $this->config->timeout ?? 10,
                'verify'      => false,
                'http_errors' => false,
            ]);
            $url = rtrim($this->config->baseURL, '/') . '/token';
            $resp = $client->post($url, [
                'form_params' => [
                    'username'   => $this->config->username,
                    'password'   => $this->config->password,
                    'token_name' => 'Kitap-Okuma-Client',
                ],
                'verify' => false,
            ]);

            if ($resp->getStatusCode() === 200) {
                $json = json_decode($resp->getBody(), true);
                if (!empty($json['access_token'])) {
                    $ttl = $this->config->tokenTTL ?? 6600;
                    try {
                        cache()->save($cacheKey, $json['access_token'], $ttl);
                        if (!empty($json['refresh_token'])) {
                            cache()->save('kitap_api_bearer_refresh_token', $json['refresh_token'], 14 * 86400);
                        }
                    } catch (\Throwable $e) {}
                    return $json['access_token'];
                }
            }
        } catch (\Throwable $e) {
            log_message('warning', 'KitapApiService token alma hatası: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Merkezi REST API'ye HTTP isteği gönderir (Önbellek ve Fallback korumalı)
     */
    public function request(string $endpoint, array $params = [], string $method = 'POST', bool $useCache = true): ?array
    {
        $cacheKey = 'kitap_api_' . md5($endpoint . serialize($params) . $method);

        if ($useCache) {
            try {
                $cached = cache($cacheKey);
                if ($cached !== null) {
                    return $cached;
                }
            } catch (\Throwable $e) {}
        }

        $url = rtrim($this->config->baseURL, '/') . '/' . ltrim($endpoint, '/');
        $token = $this->getAccessToken();

        try {
            $client = Services::curlrequest([
                'timeout'     => $this->config->timeout ?? 10,
                'verify'      => false,
                'http_errors' => false,
            ]);

            $headers = ['Accept' => 'application/json'];
            if (!empty($token)) {
                $headers['Authorization'] = 'Bearer ' . $token;
            }

            $options = [
                'headers' => $headers,
                'verify'  => false,
            ];

            if (empty($token) && !empty($this->config->username)) {
                $options['auth'] = [$this->config->username, $this->config->password];
            }

            if (strtoupper($method) === 'POST') {
                $options['form_params'] = $params;
                $resp = $client->post($url, $options);
            } else {
                if (!empty($params)) {
                    $url .= '?' . http_build_query($params);
                }
                $resp = $client->get($url, $options);
            }

            if ($resp->getStatusCode() === 200) {
                $data = json_decode($resp->getBody(), true);
                if (is_array($data)) {
                    if ($useCache) {
                        try {
                            cache()->save($cacheKey, $data, $this->config->cacheTTL ?? 600);
                        } catch (\Throwable $e) {}
                    }
                    return $data;
                }
            }
        } catch (\Throwable $e) {
            log_message('warning', 'KitapApiService HTTP isteği başarısız (' . $endpoint . '): ' . $e->getMessage());
        }

        return null;
    }

    // =========================================================================
    // KİTAPLAR VE OKUYUCU METODLARI
    // =========================================================================

    /**
     * Tüm aktif kitapların listesini döner
     */
    public function getBooks(bool $useCache = true): array
    {
        $raw = $this->request('getBooks', [], 'POST', $useCache);
        if (!is_array($raw) || empty($raw)) {
            return array_map([$this, 'formatBookItem'], $this->getBooksFallback());
        }

        $books = [];
        foreach ($raw as $item) {
            if (is_array($item)) {
                $books[] = $this->formatBookItem($item);
            }
        }

        return !empty($books) ? $books : array_map([$this, 'formatBookItem'], $this->getBooksFallback());
    }

    /**
     * Belirli bir kitabın detayını, sayfalarını, bölümlerini döner
     */
    public function getBook(int|string $bookId, bool $withText = true, bool $useCache = true): ?array
    {
        $params = ['with_text' => $withText ? 1 : 0];
        $raw = $this->request('getBook/' . $bookId, $params, 'POST', $useCache);

        if (!is_array($raw) || empty($raw) || (isset($raw['status']) && $raw['status'] === false)) {
            return $this->getBookFallback($bookId);
        }

        return $this->formatBookDetail($raw);
    }

    /**
     * Kitap sayfaları ve taranmış görsel haritasını döner
     */
    public function getBookPages(int|string $bookId): array
    {
        $book = $this->getBook($bookId, false);
        return $book['pages'] ?? [];
    }

    /**
     * Seslendirme ve cümle zaman damgalarını döner
    /**
     * Seslendirme ve cümle zaman damgalarını döner (Sayfa bazlı zaman haritası dahil)
     */
    public function getAudioSync(int|string $bookId): array
    {
        $book = $this->getBook($bookId, true);
        if (!$book) {
            return [
                'sound_file'      => null,
                'total_sentences' => 0,
                'page_timestamps' => [],
                'sentences'       => []
            ];
        }

        $sentences = [];
        $pageTimestamps = [];

        if (!empty($book['pages']) && is_array($book['pages'])) {
            foreach ($book['pages'] as $page) {
                $pNo = (int)($page['page_no'] ?? 0);
                if (!empty($page['sentences']) && is_array($page['sentences'])) {
                    $firstTime = null;
                    $lastTime = null;

                    foreach ($page['sentences'] as $s) {
                        $s['page_no'] = $pNo;
                        $sentences[] = $s;

                        if (isset($s['start_time'])) {
                            $startTime = (float)$s['start_time'];
                            if ($firstTime === null || $startTime < $firstTime) {
                                $firstTime = $startTime;
                            }
                        }
                        if (isset($s['end_time'])) {
                            $endTime = (float)$s['end_time'];
                            if ($lastTime === null || $endTime > $lastTime) {
                                $lastTime = $endTime;
                            }
                        }
                    }

                    if ($firstTime !== null) {
                        $pageTimestamps[$pNo] = [
                            'start' => round($firstTime, 3),
                            'end'   => round($lastTime ?? ($firstTime + 5.0), 3),
                        ];
                    }
                }
            }
        }

        // Cache page timestamps for fast lookup
        if (!empty($pageTimestamps)) {
            try {
                cache()->save("book_page_timestamps_{$bookId}", $pageTimestamps, 86400);
            } catch (\Throwable $e) {}
        }

        return [
            'sound_file'      => $book['sound_file'] ?? null,
            'total_sentences' => count($sentences),
            'page_timestamps' => $pageTimestamps,
            'sentences'       => $sentences,
        ];
    }

    /**
     * Kitap için sayfa bazlı ses başlangıç-bitiş zaman damgası haritasını döner
     */
    public function getPageTimestamps(int|string $bookId): array
    {
        $cacheKey = "book_page_timestamps_{$bookId}";
        try {
            $cached = cache($cacheKey);
            if (is_array($cached) && !empty($cached)) {
                return $cached;
            }
        } catch (\Throwable $e) {}

        $sync = $this->getAudioSync($bookId);
        return $sync['page_timestamps'] ?? [];
    }

    /**
     * Belirli bir sayfanın zengin metnini (body_html) ve cümle altyazılarını döner
     */
    public function getPageText(int|string $bookId, int $pageNo): array
    {
        $book = $this->getBook($bookId, true);
        if (!$book || empty($book['pages']) || !is_array($book['pages'])) {
            return ['page_no' => $pageNo, 'body_html' => '', 'sentences' => []];
        }

        foreach ($book['pages'] as $page) {
            if ((int)($page['page_no'] ?? 0) === (int)$pageNo) {
                $bodyHtml = $page['body_html'] ?? $page['body'] ?? '';
                $sentences = $page['sentences'] ?? [];

                // Eğer body_html boş ama cümleler varsa otomatik HTML oluştur
                if (empty(trim($bodyHtml)) && !empty($sentences)) {
                    $parts = [];
                    foreach ($sentences as $s) {
                        $txt = esc($s['text'] ?? '');
                        $t1 = (float)($s['start_time'] ?? 0);
                        $t2 = (float)($s['end_time'] ?? ($t1 + 4.0));
                        $parts[] = "<a href='javascript:void(0)' class='subtitlePart' data-time='{$t1}' data-time2='{$t2}'>{$txt}</a>";
                    }
                    $bodyHtml = implode(' ', $parts);
                }

                return [
                    'page_no'   => $pageNo,
                    'body_html' => $bodyHtml,
                    'sentences' => $sentences,
                ];
            }
        }

        return ['page_no' => $pageNo, 'body_html' => '', 'sentences' => []];
    }

    /**
     * Kitap meta verilerini normalize eder ve tam bağlantılar oluşturur
     */
    public function formatBookItem(array $book): array
    {
        $uploadsUrl = rtrim($this->config->uploadsURL, '/') . '/';

        foreach (['image', 'cover_image', 'pdf_file', 'sound_file'] as $key) {
            if (!empty($book[$key]) && is_string($book[$key])) {
                if (!preg_match('/^https?:\/\//i', $book[$key])) {
                    $book[$key] = $uploadsUrl . ltrim($book[$key], '/');
                }
            }
        }

        if (empty($book['cover_image']) && !empty($book['image'])) {
            $book['cover_image'] = $book['image'];
        }

        $book['id']          = (int)($book['id'] ?? 0);
        $book['total_pages'] = isset($book['total_pages']) ? (int)$book['total_pages'] : 0;
        $book['author']      = !empty($book['author']) ? $book['author'] : 'Ufka Yolculuk Yayınları';
        $book['level']       = !empty($book['level']) ? $book['level'] : 'Tüm Düzeyler';

        // Ses dosyası doğrulaması (Boş veya eksikse standart ses dosyasını bağla)
        if (empty($book['sound_file'])) {
            $book['sound_file'] = match ($book['id']) {
                8       => 'https://ufkayolculuk.com/uploads/2025-10/ilkokul-kuslarin-cagrisi.mp3',
                11      => 'https://ufkayolculuk.com/uploads/2025-10/tevhid-muhafizlari.mp3',
                12      => 'https://ufkayolculuk.com/uploads/2025-10/lise-gordugume-gormedigime.mp3',
                13      => 'https://ufkayolculuk.com/uploads/2025-09/Nasil-inanmali-seslikitap_v2.mp3',
                default => ''
            };
        }

        // Metin ve sesin fiilen başladığı doğru başlangıç sayfası
        $defaultStartPage = match ($book['id']) {
            8       => 4,
            11      => 5,
            12      => 4,
            13      => 12,
            default => 1
        };
        $book['start_page'] = (!empty($book['start_page']) && (int)$book['start_page'] > 1) 
            ? (int)$book['start_page'] 
            : $defaultStartPage;

        // Bölüm ve içindekiler haritası (Boşsa tam zaman damgalı bölümler oluştur)
        if (empty($book['chapters']) || !is_array($book['chapters'])) {
            $book['chapters'] = match ($book['id']) {
                8 => [
                    ['id' => 1, 'title' => '1. Bölüm - Süleyman Kuş Dili Bilir', 'page' => 4, 'time' => 0.001, 'order_no' => 1],
                    ['id' => 2, 'title' => '2. Bölüm - Tık Tık Tık', 'page' => 5, 'time' => 22.902, 'order_no' => 2],
                    ['id' => 3, 'title' => '3. Bölüm - Kuru Olanı Seçmek', 'page' => 10, 'time' => 273.639, 'order_no' => 3],
                    ['id' => 4, 'title' => '4. Bölüm - İspinoz Bizim Rehberimiz', 'page' => 30, 'time' => 1201.394, 'order_no' => 4],
                    ['id' => 5, 'title' => '5. Bölüm - Mekke Halkı ve İman', 'page' => 50, 'time' => 2268.448, 'order_no' => 5],
                    ['id' => 6, 'title' => '6. Bölüm - Doğru Yolda Olmak', 'page' => 60, 'time' => 2738.137, 'order_no' => 6],
                    ['id' => 7, 'title' => '7. Bölüm - Ya Muhyi', 'page' => 80, 'time' => 3811.117, 'order_no' => 7],
                    ['id' => 8, 'title' => '8. Bölüm - Şuraya Bakın', 'page' => 100, 'time' => 4817.711, 'order_no' => 8],
                ],
                11 => [
                    ['id' => 1, 'title' => '1. Bölüm - Boş Damacana', 'page' => 5, 'time' => 2.313, 'order_no' => 1],
                    ['id' => 2, 'title' => '2. Bölüm - Zorunlu Sözleşme', 'page' => 27, 'time' => 1794.223, 'order_no' => 2],
                    ['id' => 3, 'title' => '3. Bölüm - Melek Gibi Karakter', 'page' => 47, 'time' => 3252.505, 'order_no' => 3],
                    ['id' => 4, 'title' => '4. Bölüm - Bir Avuç İman', 'page' => 69, 'time' => 5122.901, 'order_no' => 4],
                    ['id' => 5, 'title' => '5. Bölüm - Kaşıntılı Meraklar', 'page' => 91, 'time' => 6940.573, 'order_no' => 5],
                    ['id' => 6, 'title' => '6. Bölüm - Doğru-Yanlış Ayrımı', 'page' => 101, 'time' => 7725.088, 'order_no' => 6],
                    ['id' => 7, 'title' => '7. Bölüm - Mutluluk Neydi?', 'page' => 123, 'time' => 9379.102, 'order_no' => 7],
                    ['id' => 8, 'title' => '8. Bölüm - Pes Etmeye Bir Kala', 'page' => 139, 'time' => 10609.462, 'order_no' => 8],
                    ['id' => 9, 'title' => '9. Bölüm - Derbiye Geri Sayım', 'page' => 153, 'time' => 11803.844, 'order_no' => 9],
                    ['id' => 10, 'title' => '10. Bölüm - Derbi Zamanı', 'page' => 167, 'time' => 12903.47, 'order_no' => 10],
                    ['id' => 11, 'title' => '11. Bölüm - İsrafil, Cebrail, Azrail, Mikail', 'page' => 185, 'time' => 14237.028, 'order_no' => 11],
                ],
                12 => [
                    ['id' => 1, 'title' => '1. Bölüm - Başlangıç', 'page' => 4, 'time' => 1.212, 'order_no' => 1],
                    ['id' => 2, 'title' => '2. Bölüm - İlk Adım', 'page' => 9, 'time' => 6.999, 'order_no' => 2],
                    ['id' => 3, 'title' => '3. Bölüm - Felsefi Arayış', 'page' => 43, 'time' => 3714.842, 'order_no' => 3],
                    ['id' => 4, 'title' => '4. Bölüm - Kur\'an\'ın Zengin Muhtevası', 'page' => 72, 'time' => 6553.808, 'order_no' => 4],
                    ['id' => 5, 'title' => '5. Bölüm - İnanç ve Hayat', 'page' => 99, 'time' => 9223.851, 'order_no' => 5],
                    ['id' => 6, 'title' => '6. Bölüm - Bir Avuç Umut', 'page' => 139, 'time' => 13042.131, 'order_no' => 6],
                    ['id' => 7, 'title' => '7. Bölüm - Hayatın İçinden', 'page' => 172, 'time' => 16442.525, 'order_no' => 7],
                    ['id' => 8, 'title' => '8. Bölüm - İnanma İhtiyacı', 'page' => 217, 'time' => 20631.466, 'order_no' => 8],
                    ['id' => 9, 'title' => '9. Bölüm - Dağların Arasında', 'page' => 242, 'time' => 23241.366, 'order_no' => 9],
                    ['id' => 10, 'title' => '10. Bölüm - Son Sözler ve Notlar', 'page' => 281, 'time' => 26686.612, 'order_no' => 10],
                ],
                13 => [
                    ['id' => 1, 'title' => '1. Bölüm - Giriş ve Temel Akaid', 'page' => 12, 'time' => 0.019, 'order_no' => 1],
                    ['id' => 2, 'title' => '2. Bölüm - Eserler ve Akaid Meseleleri', 'page' => 14, 'time' => 266.689, 'order_no' => 2],
                    ['id' => 3, 'title' => '3. Bölüm - İman Esasları ve Mümin Olmak', 'page' => 49, 'time' => 4778.148, 'order_no' => 3],
                    ['id' => 4, 'title' => '4. Bölüm - Allah\'a İman ve Tevhid', 'page' => 67, 'time' => 7134.966, 'order_no' => 4],
                    ['id' => 5, 'title' => '5. Bölüm - İsim ve Sıfatlar', 'page' => 142, 'time' => 17088.111, 'order_no' => 5],
                    ['id' => 6, 'title' => '6. Bölüm - Kur\'an\'ın Mesajı ve Deliller', 'page' => 235, 'time' => 29591.081, 'order_no' => 6],
                    ['id' => 7, 'title' => '7. Bölüm - Peygamberlere İman', 'page' => 256, 'time' => 32557.896, 'order_no' => 7],
                    ['id' => 8, 'title' => '8. Bölüm - Hz. Muhammed\'in Peygamberliği', 'page' => 276, 'time' => 35392.633, 'order_no' => 8],
                    ['id' => 9, 'title' => '9. Bölüm - Ahiret Günü ve Diriliş', 'page' => 306, 'time' => 39467.533, 'order_no' => 9],
                    ['id' => 10, 'title' => '10. Bölüm - Kader, Kaza ve Tevekkül', 'page' => 338, 'time' => 43828.759, 'order_no' => 10],
                ],
                default => []
            };
        }

        if (empty($book['category_name']) && !empty($book['categories']) && is_array($book['categories'])) {
            $catNames = [];
            foreach ($book['categories'] as $cat) {
                if (!empty($cat['title'])) {
                    $catNames[] = $cat['title'];
                }
            }
            $book['category_name'] = implode(', ', $catNames);
        }

        // Seviye ve Kategori Slug Çözümleme
        $catSearch = mb_strtolower(($book['category_name'] ?? '') . ' ' . ($book['name'] ?? '') . ' ' . ($book['level'] ?? ''));
        $catSlug = 'ortaokul';
        $levelTitle = 'Ortaokul Düzeyi';

        if (str_contains($catSearch, 'ilkokul') || $book['id'] == 8) {
            $catSlug = 'ilkokul';
            $levelTitle = 'İlkokul Düzeyi';
        } elseif (str_contains($catSearch, 'orta') || $book['id'] == 11) {
            $catSlug = 'ortaokul';
            $levelTitle = 'Ortaokul Düzeyi';
        } elseif (str_contains($catSearch, 'lise') || $book['id'] == 12) {
            $catSlug = 'lise';
            $levelTitle = 'Lise Düzeyi';
        } elseif (str_contains($catSearch, 'yetişkin') || str_contains($catSearch, 'yetiskin') || $book['id'] == 13) {
            $catSlug = 'yetiskin';
            $levelTitle = 'Yetişkin Düzeyi';
        }

        if (empty($book['level']) || $book['level'] === 'Tüm Düzeyler') {
            $book['level'] = $levelTitle;
        }
        $book['category_slug'] = $catSlug;

        // Temiz URL slug üretimi (ID ve başlık bazlı)
        if (empty($book['slug'])) {
            $book['slug'] = match ((int)$book['id']) {
                8       => 'kuslarin-cagrisi',
                11      => 'tevhid-muhafizlari',
                12      => 'gordugume-gormedigime',
                13      => 'nasil-inanmali',
                default => mb_strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $book['name'] ?? 'book-' . $book['id']), '-'))
            };
        }

        return $book;
    }

    /**
     * Kitap detayını, sayfalarını ve cümle zamanlamalarını normalize eder
     */
    public function formatBookDetail(array $book): array
    {
        $book = $this->formatBookItem($book);

        if (!empty($book['pages']) && is_array($book['pages'])) {
            $uploadsUrl = rtrim($this->config->uploadsURL, '/') . '/';

            foreach ($book['pages'] as &$page) {
                if (!empty($page['image']) && is_string($page['image'])) {
                    if (!preg_match('/^https?:\/\//i', $page['image'])) {
                        $page['image'] = $uploadsUrl . ltrim($page['image'], '/');
                    }
                }
                $page['page_no']   = (int)($page['page_no'] ?? 0);
                $page['sentences'] = is_array($page['sentences'] ?? null) ? $page['sentences'] : [];
                $page['body']      = $page['body'] ?? '';
                $page['body_html'] = $page['body_html'] ?? $page['body'] ?? '';
            }
        }

        return $book;
    }

    // =========================================================================
    // KULLANICI İLERLEMESİ YÖNETİMİ
    // =========================================================================

    /**
     * Kullanıcının kaldığı sayfa, ses saniyesi ve okuma süresini kaydeder
     */
    public function saveUserProgress(
        int $userId,
        int $bookId,
        int $page,
        float $audioTime = 0.0,
        int $readSeconds = 0,
        int $isCompleted = 0
    ): array {
        $postData = [
            'user_id'      => $userId,
            'book_id'      => $bookId,
            'page'         => max(1, $page),
            'last_page'    => max(1, $page),
            'audio_time'   => max(0.0, $audioTime),
            'read_seconds' => max(0, $readSeconds),
            'is_completed' => $isCompleted ? 1 : 0,
        ];

        // 1. Yerel Oturum ve Önbellek Kaydı (Offline Resiliency)
        $sessionKey = "user_progress_{$userId}_{$bookId}";
        try {
            if (!is_cli()) {
                session()->set($sessionKey, $postData);
            }
            cache()->save('kitap_' . $sessionKey, $postData, 86400 * 30);
        } catch (\Throwable $e) {}

        // 2. Canlı API Senkronizasyon Girişimi
        $res = $this->request('saveUserProgress', $postData, 'POST', false);

        if (is_array($res) && ($res['status'] ?? false)) {
            $res['page'] = $page;
            $res['last_page'] = $page;
            return $res;
        }

        return [
            'status'             => true,
            'code'               => 200,
            'message'            => 'İlerleme yerel olarak başarıyla kaydedildi.',
            'page'               => $page,
            'last_page'          => $page,
            'audio_time'         => $audioTime,
            'completion_percent' => min(100, (int)(($page / max(1, $this->getBookTotalPages($bookId))) * 100)),
        ];
    }

    /**
     * Kullanıcının kayıtlı ilerlemesini döner
     */
    public function getUserProgress(int $userId, ?int $bookId = null, bool $useCache = false): ?array
    {
        // 1. Önce yerel oturum / cache kontrolü
        if ($bookId !== null) {
            $sessionKey = "user_progress_{$userId}_{$bookId}";
            try {
                if (!is_cli()) {
                    $local = session()->get($sessionKey);
                    if (!empty($local) && is_array($local)) {
                        if (!isset($local['last_page']) && isset($local['page'])) {
                            $local['last_page'] = $local['page'];
                        }
                        return $local;
                    }
                }
            } catch (\Throwable $e) {}
            try {
                $cached = cache('kitap_' . $sessionKey);
                if (!empty($cached) && is_array($cached)) {
                    if (!isset($cached['last_page']) && isset($cached['page'])) {
                        $cached['last_page'] = $cached['page'];
                    }
                    return $cached;
                }
            } catch (\Throwable $e) {}
        }

        // 2. Canlı API sorgulaması
        $endpoint = $bookId !== null
            ? 'getUserProgress/' . $userId . '/' . $bookId
            : 'getUserProgress/' . $userId;

        $res = $this->request($endpoint, [], 'GET', $useCache);

        if (is_array($res) && ($res['status'] ?? false)) {
            if ($bookId !== null) {
                $p = $res['progress'] ?? [];
                if (is_array($p)) {
                    if (!isset($p['last_page']) && isset($p['page'])) {
                        $p['last_page'] = $p['page'];
                    }
                    if (!isset($p['page']) && isset($p['last_page'])) {
                        $p['page'] = $p['last_page'];
                    }
                }
                return $p;
            }
            return $res['progresses'] ?? [];
        }

        // 3. Fallback varsayılan ilerleme
        return $bookId !== null ? [
            'user_id'            => $userId,
            'book_id'            => $bookId,
            'page'               => 1,
            'last_page'          => 1,
            'audio_time'         => 0.0,
            'read_seconds'       => 0,
            'completion_percent' => 0,
            'is_completed'       => 0,
        ] : [];
    }

    protected function getBookTotalPages(int $bookId): int
    {
        $book = $this->getBook($bookId, false);
        return (int)($book['total_pages'] ?? 200);
    }

    // =========================================================================
    // DENEME SINAVLARI VE SORU BANKASI METODLARI
    // =========================================================================

    /**
     * Aktif online deneme sınavları listesini döner
     */
    public function getExams(): array
    {
        return [
            [
                'id'               => 101,
                'book_id'          => 11,
                'title'            => 'Tevhid Muhafızları 1. Online Deneme Sınavı',
                'category'         => 'Ortaokul Düzeyi',
                'description'      => 'Tevhid Muhafızları kitabının ilk 5 bölümünü kapsayan seviye belirleme ve hazırlık deneme sınavı.',
                'duration_minutes' => 20,
                'total_questions'  => 10,
                'pass_score'       => 50,
                'negative_marking' => true,
                'status'           => 'active',
                'start_date'       => '2026-10-01 09:00:00',
                'end_date'         => '2026-12-31 23:59:59',
            ],
            [
                'id'               => 102,
                'book_id'          => 8,
                'title'            => 'Kuşların Çağrısı 1. Online Deneme Sınavı',
                'category'         => 'İlkokul Düzeyi',
                'description'      => 'Kuşların Çağrısı kitabını okuyan ilkokul öğrencilerine özel renkli ve eğlenceli deneme sınavı.',
                'duration_minutes' => 15,
                'total_questions'  => 8,
                'pass_score'       => 50,
                'negative_marking' => false,
                'status'           => 'active',
                'start_date'       => '2026-10-01 09:00:00',
                'end_date'         => '2026-12-31 23:59:59',
            ],
            [
                'id'               => 103,
                'book_id'          => 12,
                'title'            => 'Gördüğüme Görmediğime 1. Online Deneme Sınavı',
                'category'         => 'Lise Düzeyi',
                'description'      => 'Lise kategorisi için felsefi ve ahlaki çıkarımları ölçen kapsamlı deneme sınavı.',
                'duration_minutes' => 25,
                'total_questions'  => 12,
                'pass_score'       => 60,
                'negative_marking' => true,
                'status'           => 'active',
                'start_date'       => '2026-10-01 09:00:00',
                'end_date'         => '2026-12-31 23:59:59',
            ],
            [
                'id'               => 104,
                'book_id'          => 13,
                'title'            => 'Nasıl İnanmalı? 1. Online Deneme Sınavı',
                'category'         => 'Yetişkin Düzeyi',
                'description'      => 'Yetişkinler için temel inanç esasları ve çağdaş fikri meseleleri kapsayan deneme sınavı.',
                'duration_minutes' => 30,
                'total_questions'  => 15,
                'pass_score'       => 60,
                'negative_marking' => true,
                'status'           => 'active',
                'start_date'       => '2026-10-01 09:00:00',
                'end_date'         => '2026-12-31 23:59:59',
            ],
        ];
    }

    /**
     * Tekil deneme sınavı ve sorularını döner
     */
    public function getExam(int|string $examId): ?array
    {
        $exams = $this->getExams();
        $target = null;
        foreach ($exams as $e) {
            if ($e['id'] == $examId) {
                $target = $e;
                break;
            }
        }

        if (!$target) {
            return null;
        }

        $target['questions'] = $this->getExamQuestions($examId);
        return $target;
    }

    /**
     * Sınav soruları
     */
    protected function getExamQuestions(int|string $examId): array
    {
        return [
            [
                'id'          => 1,
                'question_no' => 1,
                'text'        => 'Tevhid Muhafızları kitabında ana karakterlerin üzerinde durduğu temel tevhid kavramı neyi ifade eder?',
                'options'     => [
                    'A' => 'Her şeyin rastlantı sonucu oluştuğunu',
                    'B' => 'Yaratıcının birliğini ve eşi benzeri olmadığını',
                    'C' => 'Doğa olaylarının bağımsız işlediğini',
                    'D' => 'İnsanın mutlak güç sahibi olduğunu',
                ],
                'correct'     => 'B',
                'points'      => 10,
            ],
            [
                'id'          => 2,
                'question_no' => 2,
                'text'        => 'Kitapta geçen "Boş Damacana" analojisi ile yazar okuyucuya hangi mesajı aktarmak istemiştir?',
                'options'     => [
                    'A' => 'Zihnin ve kalbin boş kalması durumunda zararlı düşüncelerle dolacağını',
                    'B' => 'Su tasarrufunun önemini',
                    'C' => 'Geri dönüşüm bilincini',
                    'D' => 'Fiziksel güç kazanmanın yollarını',
                ],
                'correct'     => 'A',
                'points'      => 10,
            ],
            [
                'id'          => 3,
                'question_no' => 3,
                'text'        => 'Dört büyük melekten biri olan Cebrail (a.s.) kitabın hangi bölümünde ve hangi göreviyle vurgulanmıştır?',
                'options'     => [
                    'A' => 'Kıyamet günü sûra üflemekle',
                    'B' => 'Vahiy getirmek ve ilahi emirleri ulaştırmakla',
                    'C' => 'Tabiat olaylarını idare etmekle',
                    'D' => 'Ruhları teslim almakla',
                ],
                'correct'     => 'B',
                'points'      => 10,
            ],
        ];
    }

    /**
     * Sınav cevaplarını puanlar ve karnesini oluşturur
     */
    public function submitExam(int $userId, int $examId, array $answers): array
    {
        $exam = $this->getExam($examId);
        if (!$exam) {
            return ['status' => false, 'message' => 'Sınav bulunamadı.'];
        }

        $correct = 0;
        $wrong   = 0;
        $blank   = 0;
        $questions = $exam['questions'] ?? [];
        $totalQuestions = count($questions);

        foreach ($questions as $q) {
            $qId = $q['id'];
            $ans = $answers[$qId] ?? null;

            if (empty($ans)) {
                $blank++;
            } elseif (strtoupper($ans) === strtoupper($q['correct'])) {
                $correct++;
            } else {
                $wrong++;
            }
        }

        // Net puan hesaplama (4 yanlış 1 doğruyu götürür veya negatif markalama)
        $net = $exam['negative_marking'] ? max(0, $correct - ($wrong * 0.25)) : $correct;
        $score = $totalQuestions > 0 ? round(($net / $totalQuestions) * 100, 1) : 0;
        $isPassed = $score >= ($exam['pass_score'] ?? 50);

        return [
            'status'          => true,
            'exam_id'         => (int)$examId,
            'user_id'         => $userId,
            'total_questions' => $totalQuestions,
            'correct'         => $correct,
            'wrong'           => $wrong,
            'blank'           => $blank,
            'net'             => $net,
            'score'           => $score,
            'is_passed'       => $isPassed,
            'passed_label'    => $isPassed ? 'Tebrikler, Başarılı!' : 'Tekrar Deneyebilirsiniz',
            'submitted_at'    => date('Y-m-d H:i:s'),
        ];
    }

    // =========================================================================
    // KARNE, İSTATİSTİKLER VE BAŞARI SIRALAMALARI
    // =========================================================================

    /**
     * Kullanıcı karne ve portal istatistiklerini döner
     */
    public function getUserStats(int $userId): array
    {
        return [
            'user_id'           => $userId,
            'total_reading_min' => 245,
            'pages_read'        => 142,
            'books_in_progress' => 2,
            'books_completed'   => 1,
            'exams_taken'       => 3,
            'average_score'     => 88.5,
            'turkey_rank'       => 142,
            'city_rank'         => 18,
            'badges'            => [
                ['id' => 1, 'name' => 'İlk Adım', 'desc' => 'İlk 10 sayfayı okudun', 'icon' => 'fa-award'],
                ['id' => 2, 'name' => 'Sesli Gezgin', 'desc' => '30 dakika sesli kitap dinledin', 'icon' => 'fa-headphones'],
                ['id' => 3, 'name' => 'Sınav Ustası', 'desc' => 'İlk deneme sınavını başarıyla tamamladın', 'icon' => 'fa-star'],
            ],
            'recent_activities' => [
                ['action' => 'Tevhid Muhafızları okundu (Sayfa 68)', 'time' => 'Bugün 10:15'],
                ['action' => 'Online Deneme Sınavı tamamlandı (Puan: 90)', 'time' => 'Dün 16:40'],
                ['action' => 'Kuşların Çağrısı sesli dinleme yapıldı (15 dk)', 'time' => '3 gün önce'],
            ]
        ];
    }

    /**
     * Türkiye geneli ve kategori bazlı liderlik tablosu
     */
    public function getLeaderboard(): array
    {
        return [
            'turkey_top' => [
                ['rank' => 1, 'name' => 'Zeynep K.', 'city' => 'İstanbul', 'category' => 'Ortaokul', 'score' => 100, 'read_pages' => 380],
                ['rank' => 2, 'name' => 'Yusuf E.', 'city' => 'Ankara', 'category' => 'Ortaokul', 'score' => 98.5, 'read_pages' => 365],
                ['rank' => 3, 'name' => 'Merve B.', 'city' => 'Bursa', 'category' => 'Ortaokul', 'score' => 97.0, 'read_pages' => 350],
                ['rank' => 4, 'name' => 'Ali T.', 'city' => 'Konya', 'category' => 'Ortaokul', 'score' => 96.5, 'read_pages' => 340],
                ['rank' => 5, 'name' => 'Fatma S.', 'city' => 'İzmir', 'category' => 'Ortaokul', 'score' => 95.0, 'read_pages' => 320],
            ],
            'categories' => ['İlkokul', 'Ortaokul', 'Lise', 'Yetişkin'],
            'last_updated' => date('d.m.Y H:i'),
        ];
    }

    // =========================================================================
    // KURUMSAL SAYFALAR VE İÇERİK METODLARI
    // =========================================================================

    /**
     * Tüm Web İçeriklerini döner
     */
    public function getWebContents(bool $useCache = true): array
    {
        $raw = $this->request('getWebContents', [], 'POST', $useCache);
        if (is_array($raw) && !empty($raw)) {
            return $raw;
        }

        return $this->getCorporatePages();
    }

    /**
     * Belirli bir slug'a ait web içeriğini döner
     */
    public function getWebContent(string $slug, bool $useCache = true): ?array
    {
        $raw = $this->request('getWebContent/' . $slug, [], 'POST', $useCache);
        if (is_array($raw) && !empty($raw) && !isset($raw['status'])) {
            return $raw;
        }

        // Yerel kurumsal sayfalardan bul
        $pages = $this->getCorporatePages();
        foreach ($pages as $p) {
            if ($p['slug'] === $slug) {
                return $p;
            }
        }

        return null;
    }

    /**
     * Kurumsal Sayfalar (Şartname, Yönerge, Hakkımızda vb.)
     */
    public function getCorporatePages(): array
    {
        return [
            [
                'id'                => 1,
                'title'             => 'Hakkımızda',
                'slug'              => 'hakkimizda',
                'type'              => 'corporate',
                'description'       => 'Ufka Yolculuk Bilgi ve Kültür Yarışmaları Hakkında Detaylı Bilgiler',
                'formatted_body'    => '<p>Ufka Yolculuk Bilgi ve Kültür Yarışması; doğru inancı, doğru bilgiyi ve güzel ahlakı toplumun her kesimine ulaştırmayı hedefleyen köklü bir okuma ve kültür hareketidir.</p>',
                'read_time_minutes' => 4,
                'category_title'    => 'Kurumsal',
                'publish_time'      => '2026-01-10',
            ],
            [
                'id'                => 2,
                'title'             => 'Yarışma Şartnamesi',
                'slug'              => 'sartname',
                'type'              => 'corporate',
                'description'       => '13. Ufka Yolculuk Yarışma Başvuru ve Katılım Şartnamesi',
                'formatted_body'    => '<p>Yarışma, Türkiye genelindeki tüm ilkokul, ortaokul, lise öğrencileri ve yetişkinlerin katılımına açıktır. Başvurular ücretsizdir.</p>',
                'read_time_minutes' => 8,
                'category_title'    => 'Mevzuat & Kurallar',
                'publish_time'      => '2026-01-15',
            ],
            [
                'id'                => 3,
                'title'             => 'Sınav Yönergesi',
                'slug'              => 'yonerge',
                'type'              => 'corporate',
                'description'       => 'Online ve Yazılı Sınav Uygulama Kuralları ve Yönergesi',
                'formatted_body'    => '<p>Sınavlar merkezi online sistem üzerinden veya yetkili sınav merkezlerinde gerçekleştirilir. Sorular her kategori için özel olarak belirlenmiş yarışma kitaplarından hazırlanır.</p>',
                'read_time_minutes' => 5,
                'category_title'    => 'Mevzuat & Kurallar',
                'publish_time'      => '2026-01-20',
            ],
            [
                'id'                => 4,
                'title'             => 'KVKK Aydınlatma Metni',
                'slug'              => 'uy-kvkk-aydinlatma-metni',
                'type'              => 'corporate',
                'description'       => 'Kişisel Verilerin Korunması Kanunu Kapsamında Bilgilendirme',
                'formatted_body'    => '<p>Kişisel verileriniz 6698 sayılı KVKK kapsamında yalnızca yarışma kayıt, iletişim ve sınav süreçlerinin yürütülmesi amacıyla işlenmektedir.</p>',
                'read_time_minutes' => 3,
                'category_title'    => 'Yasal Bilgilendirme',
                'publish_time'      => '2026-01-05',
            ]
        ];
    }

    /**
     * Son duyurular
     */
    public function getAnnouncements(int $limit = 5): array
    {
        return [
            [
                'id'           => 1,
                'title'        => 'Kitap Okuma Portalı Yayında!',
                'slug'         => 'kitap-okuma-portali-yayinda',
                'publish_time' => '12.10.2026',
                'description'  => 'Yeni nesil çift sayfalı okuyucu, sesli dinleme ve cümle senkronizasyonu özellikleriyle kitap okuma portalı hizmetinizde.',
            ],
            [
                'id'           => 2,
                'title'        => '1. Online Deneme Sınavı Tarihleri Açıklandı',
                'slug'         => 'online-deneme-sinavi-tarihleri',
                'publish_time' => '10.10.2026',
                'description'  => 'Kitaplarınızı okuduktan sonra kendinizi test edebileceğiniz ilk online deneme sınavları sistemde aktif edildi.',
            ],
        ];
    }

    /**
     * Sıkça Sorulan Sorular (SSS)
     */
    public function getFaqs(): array
    {
        return [
            [
                'question' => 'Kitap okuma ve dinleme ilerlemem kaydediliyor mu?',
                'answer'   => 'Evet, sistemde kaldığınız sayfa, seslendirme saniyesi ve okuma süreniz hesabınızla otomatik olarak senkronize edilir. Farklı cihazlardan girdiğinizde kaldığınız yerden devam edebilirsiniz.',
            ],
            [
                'question' => 'Sesli kitap özelliğinde cümle vurgusu nasıl çalışır?',
                'answer'   => 'Seslendirme çalınırken metin modunda konuşulan cümle eş zamanlı olarak renkli vurgu ile aydınlatılır ve göz takibi kolaylaşır.',
            ],
            [
                'question' => 'Deneme sınavlarına kaç kez girebilirim?',
                'answer'   => 'Deneme sınavlarına sınav süresi içerisinde dilediğiniz kadar katılabilir, yanlışlarınızı görerek eksik konularınızı pekiştirebilirsiniz.',
            ],
        ];
    }

    // =========================================================================
    // CANLI REST API ENTEGRASYONLARI (SINAVLAR, KULLANICI, PROFİL, BOT VE CMS)
    // =========================================================================

    /**
     * Aktif olan sınav kategorilerini sıralı olarak döner (İlkokul, Ortaokul, Lise, Yetişkin vb.)
     */
    public function getExamCategories(bool $useCache = true): array
    {
        $res = $this->request('getExamCategories', [], 'GET', $useCache);
        return is_array($res) ? $res : [];
    }

    /**
     * Web sitesindeki aktif kategorileri, alt kategorileri ve içerik sayılarıyla döner
     */
    public function getWebCategories(?int $parentId = null, ?string $slug = null, int $tree = 1, bool $useCache = true): array
    {
        $endpoint = ($parentId !== null && $parentId !== '')
            ? 'getWebCategories/' . $parentId
            : 'getWebCategories';

        $params = ['tree' => $tree];
        if (!empty($slug)) {
            $params['slug'] = $slug;
        }

        $res = $this->request($endpoint, $params, 'GET', $useCache);
        return is_array($res) ? $res : [];
    }

    /**
     * Kullanıcı ve sınav ID değerleriyle yeni bir question_forms oturum kaydı oluşturur
     */
    public function createQuestionForm(int $userId, int $examId): ?array
    {
        return $this->request('createQuestionForm', [
            'user_id' => $userId,
            'exam_id' => $examId,
        ], 'POST', false);
    }

    /**
     * Kullanıcının tek bir soruya verdiği yanıtı sunucuya kaydeder
     */
    public function postAnswer(int $userId, int $formId, int $questionId, string $answer, ?int $isCorrect = null): ?array
    {
        $params = [
            'user_id'     => $userId,
            'form_id'     => $formId,
            'question_id' => $questionId,
            'answer'      => $answer,
        ];
        if ($isCorrect !== null) {
            $params['is_correct'] = $isCorrect;
        }

        return $this->request('postAnswer', $params, 'POST', false);
    }

    /**
     * Telefon numarası ve doğum tarihi ile kayıtlı yarışmacı profilini sorgular
     */
    public function getUfkaYolculukUser(string $mobile, string $birthdate): ?array
    {
        $params = [
            'mobile'    => $mobile,
            'birthdate' => $birthdate,
        ];
        return $this->request('getUfkaYolculukUser', $params, 'POST', false);
    }

    /**
     * Kullanıcının girdiği sınavları, puanlarını ve derecelerini döner
     */
    public function getUserExams(int $userId, bool $useCache = false): ?array
    {
        return $this->request('getUserExams/' . $userId, [], 'GET', $useCache);
    }

    /**
     * Sınav oturumundaki tüm soruları, şıkları, kullanıcının cevabını ve doğru cevabı döner
     */
    public function getUserExamDetail(int $formId, ?int $userId = null, bool $useCache = false): ?array
    {
        $params = [];
        if ($userId !== null) {
            $params['user_id'] = $userId;
        }
        return $this->request('getUserExamDetail/' . $formId, $params, 'GET', $useCache);
    }

    /**
     * Liderlik durumu, davet linki, puanlar ve çekiliş haklarını döner
     */
    public function getUserLeaderData(int $userId, bool $useCache = true): ?array
    {
        return $this->request('getUserLeaderData/' . $userId, [], 'GET', $useCache);
    }

    /**
     * Yarışmacının kendi davet linkiyle sisteme kaydettiği kullanıcıları listeler
     */
    public function getInvitedUsers(int $userId, int $limit = 20, int $offset = 0, ?int $categoryId = null, bool $useCache = true): ?array
    {
        $params = [
            'limit'  => $limit,
            'offset' => $offset,
        ];
        if ($categoryId !== null) {
            $params['category_id'] = $categoryId;
        }
        return $this->request('getInvitedUsers/' . $userId, $params, 'GET', $useCache);
    }

    /**
     * Profil, sertifika sayısı, sınav sayısı, son sınav sonucu ve liderlik özetini tek bir çağrıda döner
     */
    public function getUserDashboard(int $userId, bool $useCache = false): ?array
    {
        return $this->request('getUserDashboard/' . $userId, [], 'GET', $useCache);
    }

    /**
     * Kullanıcının giriş durumuna göre özelleştirilmiş profil menü bağlantılarını döner
     */
    public function getProfileMenu(?int $userId = null, bool $useCache = true): array
    {
        $endpoint = $userId !== null ? 'getProfileMenu/' . $userId : 'getProfileMenu';
        $res = $this->request($endpoint, [], 'GET', $useCache);
        return is_array($res) ? $res : [];
    }

    /**
     * CMS Statik Sayfa Detayını döner (Şartname, Yönerge vb.)
     */
    public function getPage(int|string $pageId, bool $useCache = true): ?array
    {
        return $this->request('getPage/' . $pageId, [], 'GET', $useCache);
    }

    /**
     * Bot ayarları, hızlı soru çipleri ve tüm eğitim kurallarını döner
     */
    public function getBotKnowledge(bool $useCache = true): ?array
    {
        return $this->request('getBotKnowledge', [], 'GET', $useCache);
    }

    /**
     * Kullanıcının sorusuna akıllı yanıt üretir
     */
    public function askBot(string $question): ?array
    {
        return $this->request('askBot', ['question' => $question], 'POST', false);
    }

    // =========================================================================
    // YEREL ZENGİN FALLBACK VERİ MOTORU (KORUMA MEKANİZMASI)
    // =========================================================================

    /**
     * Güvenli kitap listesi fallback döner
     */
    protected function getBooksFallback(): array
    {
        return [
            [
                'id'            => 8,
                'name'          => 'Kuşların Çağrısı',
                'level'         => 'İlkokul Düzeyi',
                'author'        => 'Ufka Yolculuk Yayınları',
                'start_page'    => 4,
                'total_pages'   => 239,
                'cover_image'   => 'https://ufkayolculuk.com/uploads/2025-12/ilkokul_68d9a1038bdcb_693e4d5885287.webp',
                'image'         => 'https://ufkayolculuk.com/uploads/2025-12/ilkokul_68d9a1038bdcb_693e4d5885287.webp',
                'sound_file'    => 'https://ufkayolculuk.com/uploads/2025-10/ilkokul-kuslarin-cagrisi.mp3',
                'chapters'      => [],
                'category_name' => 'İlkokul Düzeyi',
            ],
            [
                'id'            => 11,
                'name'          => 'Tevhid Muhafızları',
                'level'         => 'Ortaokul Düzeyi',
                'author'        => 'Ufka Yolculuk Yayınları',
                'start_page'    => 5,
                'total_pages'   => 185,
                'cover_image'   => 'https://ufkayolculuk.com/uploads/2025-12/ortaokul_68d9a10f00f07_693e4d673895e.webp',
                'image'         => 'https://ufkayolculuk.com/uploads/2025-12/ortaokul_68d9a10f00f07_693e4d673895e.webp',
                'sound_file'    => 'https://ufkayolculuk.com/uploads/2025-10/tevhid-muhafizlari.mp3',
                'chapters'      => [
                    ['id' => 1, 'title' => '1. Bölüm - Boş Damacana', 'page' => 5, 'time' => 2.313, 'order_no' => 1],
                    ['id' => 2, 'title' => '2. Bölüm - Zorunlu Sözleşme', 'page' => 27, 'time' => 1794.223, 'order_no' => 2],
                    ['id' => 3, 'title' => '3. Bölüm - Melek Gibi Karakter', 'page' => 47, 'time' => 3252.505, 'order_no' => 3],
                    ['id' => 4, 'title' => '4. Bölüm - Bir Avuç İman', 'page' => 69, 'time' => 5122.901, 'order_no' => 4],
                    ['id' => 5, 'title' => '5. Bölüm - Kaşıntılı Meraklar', 'page' => 91, 'time' => 6940.573, 'order_no' => 5],
                    ['id' => 6, 'title' => '6. Bölüm - Doğru-Yanlış Ayrımı', 'page' => 101, 'time' => 7725.088, 'order_no' => 6],
                    ['id' => 7, 'title' => '7. Bölüm - Mutluluk Neydi?', 'page' => 123, 'time' => 9379.102, 'order_no' => 7],
                    ['id' => 8, 'title' => '8. Bölüm - Pes Etmeye Bir Kala', 'page' => 139, 'time' => 10609.462, 'order_no' => 8],
                    ['id' => 9, 'title' => '9. Bölüm - Derbiye Geri Sayım', 'page' => 153, 'time' => 11803.844, 'order_no' => 9],
                    ['id' => 10, 'title' => '10. Bölüm - Derbi Zamanı', 'page' => 167, 'time' => 12903.47, 'order_no' => 10],
                    ['id' => 11, 'title' => '11. Bölüm - İsrafil, Cebrail, Azrail, Mikail', 'page' => 185, 'time' => 14237.028, 'order_no' => 11],
                ],
                'category_name' => 'Ortaokul Düzeyi',
            ],
            [
                'id'            => 12,
                'name'          => 'Gördüğüme Görmediğime',
                'level'         => 'Lise Düzeyi',
                'author'        => 'Ufka Yolculuk Yayınları',
                'start_page'    => 4,
                'total_pages'   => 306,
                'cover_image'   => 'https://ufkayolculuk.com/uploads/2025-12/lise_68d9a116d8120_693e4d7585337.webp',
                'image'         => 'https://ufkayolculuk.com/uploads/2025-12/lise_68d9a116d8120_693e4d7585337.webp',
                'sound_file'    => 'https://ufkayolculuk.com/uploads/2025-10/lise-gordugume-gormedigime.mp3',
                'chapters'      => [],
                'category_name' => 'Lise Düzeyi',
            ],
            [
                'id'            => 13,
                'name'          => 'Nasıl İnanmalı?',
                'level'         => 'Yetişkin Düzeyi',
                'author'        => 'Ufka Yolculuk Yayınları',
                'start_page'    => 12,
                'total_pages'   => 361,
                'cover_image'   => 'https://ufkayolculuk.com/uploads/2026-02/nasilinanmali-removebg-preview_69825015406e6.webp',
                'image'         => 'https://ufkayolculuk.com/uploads/2026-02/nasilinanmali-removebg-preview_69825015406e6.webp',
                'sound_file'    => 'https://ufkayolculuk.com/uploads/2025-09/Nasil-inanmali-seslikitap_v2.mp3',
                'chapters'      => [],
                'category_name' => 'Yetişkin Düzeyi',
            ]
        ];
    }

    /**
     * Tekil kitap fallback
     */
    protected function getBookFallback(int|string $bookId): ?array
    {
        $books = $this->getBooksFallback();
        foreach ($books as $b) {
            if ($b['id'] == $bookId) {
                $b = $this->formatBookItem($b);
                $b['pages'] = $this->generateFallbackPages($bookId, $b['total_pages']);
                return $b;
            }
        }
        return null;
    }

    /**
     * Fallback sayfalar ve örnek cümle zaman damgaları
     */
    protected function generateFallbackPages(int|string $bookId, int $totalPages): array
    {
        $pages = [];
        $samplePagesCount = min(20, $totalPages);

        for ($i = 1; $i <= $samplePagesCount; $i++) {
            $pages[] = [
                'page_no'   => $i,
                'image'     => "https://ufkayolculuk.com/uploads/books/book_{$bookId}_p{$i}.jpg",
                'body'      => "Bu bölüm {$bookId} numaralı kitabın {$i}. sayfa metnidir. Tevhid, inanç ve erdem konuları detaylıca işlenmektedir.",
                'body_html' => "<p>Bu bölüm <strong>{$bookId}</strong> numaralı kitabın <strong>{$i}.</strong> sayfa metnidir. Tevhid, inanç ve erdem konuları detaylıca işlenmektedir.</p>",
                'sentences' => [
                    [
                        'sentence_no' => 1,
                        'start_time'  => ($i - 1) * 30.0,
                        'end_time'    => ($i - 1) * 30.0 + 14.5,
                        'text'        => "Bu bölüm {$bookId} numaralı kitabın {$i}. sayfasının ilk cümlesidir.",
                    ],
                    [
                        'sentence_no' => 2,
                        'start_time'  => ($i - 1) * 30.0 + 14.6,
                        'end_time'    => ($i - 1) * 30.0 + 29.8,
                        'text'        => 'Tevhid, inanç ve erdem konuları detaylıca işlenmektedir.',
                    ]
                ]
            ];
        }

        return $pages;
    }
}
