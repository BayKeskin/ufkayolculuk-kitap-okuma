<?php

namespace App\Services;

use Config\Services;
use Config\UfkaApi;

/**
 * Ufka Yolculuk Merkezi REST API Servisi
 * API Kılavuzu: https://ufkayolculuk.com/rest
 */
class UfkaApiService
{
    protected UfkaApi $config;

    public function __construct(?UfkaApi $config = null)
    {
        $this->config = $config ?? config('UfkaApi');
    }

    /**
     * REST API uç noktasına HTTP isteği gönderir (Basic Auth & Cache)
     */
    public function request(string $endpoint, array $postData = [], string $method = 'POST', bool $useCache = true): ?array
    {
        $endpoint = ltrim($endpoint, '/');
        $cacheKey = 'ufka_api_' . md5($endpoint . '_' . json_encode($postData) . '_' . $method);

        if ($useCache) {
            try {
                $cached = cache($cacheKey);
                if ($cached !== null && is_array($cached)) {
                    return $cached;
                }
            } catch (\Throwable $e) {
                // Önbellek servisi hazır değilse devam et
            }
        }

        $url = rtrim($this->config->baseURL, '/') . '/' . $endpoint;

        try {
            $client = Services::curlrequest([
                'timeout'     => 12,
                'http_errors' => false,
                'verify'      => false,
            ]);

            $options = [
                'auth'    => [$this->config->username, $this->config->password],
                'headers' => [
                    'Accept'     => 'application/json',
                    'User-Agent' => 'UfkaYolculuk-KitapOkuma-CI4/1.0',
                ],
                'verify'  => false,
            ];

            if ($method === 'POST') {
                $options['form_params'] = $postData;
                $response = $client->post($url, $options);
            } else {
                $options['query'] = $postData;
                $response = $client->get($url, $options);
            }

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            if ($statusCode >= 200 && $statusCode < 300) {
                $data = json_decode($body, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                    if ($useCache && !empty($data)) {
                        try {
                            cache()->save($cacheKey, $data, $this->config->cacheTTL);
                        } catch (\Throwable $e) {
                            // ignore cache save failure
                        }
                    }
                    return $data;
                }
            }

            log_message('error', "UfkaApiService error: HTTP {$statusCode} on {$url}");
            return null;
        } catch (\Throwable $e) {
            log_message('error', "UfkaApiService exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tüm Web İçeriklerini veya filtreli içerikleri döner
     */
    public function getWebContents(array $filters = [], bool $useCache = true): array
    {
        $result = $this->request('getWebContents', $filters, 'POST', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Belirli bir içeriği slug veya ID'ye göre bulup döner (Alias ve Fallback destekli)
     */
    public function getWebContent(string $slugOrId, bool $useCache = true): ?array
    {
        $rawTarget = trim($slugOrId);
        $targetLower = strtolower($rawTarget);

        // 1. Doğrudan tekil slug sorgusu
        $direct = $this->getWebContents(['slug' => $rawTarget], $useCache);
        if (!empty($direct) && is_array($direct)) {
            $item = reset($direct);
            return $this->formatContentItem($item);
        }

        // 2. Yaygın URL takma adları (alias) eşleştirmesi
        $aliases = [
            'sartname'                  => ['sartname', 'mobil-yarisma-sartnamesi', 'yarisma-sartnamesi'],
            'yarisma-sartnamesi'        => ['sartname', 'mobil-yarisma-sartnamesi'],
            'yonerge'                   => ['yonerge', 'sinav-yonergesi'],
            'sinav-yonergesi'           => ['yonerge'],
            'kvkk'                      => ['uy-kvkk-aydinlatma-metni', 'kvkk'],
            'uy-kvkk-aydinlatma-metni'  => ['uy-kvkk-aydinlatma-metni', 'kvkk'],
            'gizlilik'                  => ['uy-mahremiyet-politikasi', 'mahremiyetpolitikasi', 'mahremiyet-politikasi'],
            'mahremiyet'                => ['uy-mahremiyet-politikasi', 'mahremiyetpolitikasi'],
            'uy-mahremiyet-politikasi'  => ['uy-mahremiyet-politikasi', 'mahremiyetpolitikasi'],
            'veli-izni'                 => ['uy-veli-izin-belgesi', 'veli-izin-belgesi'],
            'veli-izin-belgesi'         => ['uy-veli-izin-belgesi', 'veli-izin-belgesi'],
            'uy-veli-izin-belgesi'      => ['uy-veli-izin-belgesi', 'veli-izin-belgesi'],
            'resmi-onaylar'             => ['resmi-onaylar', 'meb-onaylari', 'onaylar'],
            'biz-kimiz'                 => ['biz-kimiz', 'bizkimiz'],
            'misyon-vizyon'             => ['misyon-vizyon', 'misyonumuz-vizyonumuz'],
        ];

        if (isset($aliases[$targetLower])) {
            foreach ($aliases[$targetLower] as $aliasSlug) {
                if ($aliasSlug !== $rawTarget) {
                    $aliasResult = $this->getWebContents(['slug' => $aliasSlug], $useCache);
                    if (!empty($aliasResult) && is_array($aliasResult)) {
                        $item = reset($aliasResult);
                        return $this->formatContentItem($item);
                    }
                }
            }
        }

        // 3. Fallback: Tüm içerik havuzunda arama
        $contents = $this->getWebContents([], $useCache);
        if (!empty($contents)) {
            foreach ($contents as $item) {
                $itemSlug = strtolower(trim($item['slug'] ?? ''));
                $itemId = (string)($item['id'] ?? '');

                if ($itemSlug === $targetLower || $itemId === $rawTarget) {
                    return $this->formatContentItem($item);
                }
            }
        }

        return null;
    }

    /**
     * Sıkça Sorulan Soruları (SSS) döner
     */
    public function getFaqs(bool $useCache = true): array
    {
        $contents = $this->getWebContents([], $useCache);
        $faqs = [];

        foreach ($contents as $item) {
            $type = strtolower($item['type'] ?? '');
            if ($type === 'sss' || $type === 'faq') {
                $faqs[] = $this->formatContentItem($item);
            }
        }

        return $faqs;
    }

    /**
     * Son Duyuruları Döner
     */
    public function getAnnouncements(int $limit = 5, bool $useCache = true): array
    {
        $contents = $this->getWebContents([], $useCache);
        $announcements = [];

        foreach ($contents as $item) {
            $type = strtolower($item['type'] ?? '');
            if (in_array($type, ['annoucement', 'announcement', 'duyuru', 'news', 'haber'])) {
                $announcements[] = $this->formatContentItem($item);
            }
        }

        return array_slice($announcements, 0, $limit);
    }

    /**
     * Kurumsal ve Yasal Sayfaların Standart Menü Listesi
     */
    public function getCorporatePages(): array
    {
        return [
            'hakkimizda'               => [
                'title' => 'Hakkımızda',
                'slug'  => 'hakkimizda',
                'icon'  => 'fa-solid fa-circle-info',
                'badge' => 'Genel',
            ],
            'konusu'                   => [
                'title' => 'Yarışma Konusu',
                'slug'  => 'konusu',
                'icon'  => 'fa-solid fa-bookmark',
                'badge' => '2025',
            ],
            'yonerge'                  => [
                'title' => 'Sınav Yönergesi',
                'slug'  => 'yonerge',
                'icon'  => 'fa-solid fa-clipboard-list',
                'badge' => 'Kılavuz',
            ],
            'sartname'                 => [
                'title' => 'Yarışma Şartnamesi',
                'slug'  => 'sartname',
                'icon'  => 'fa-solid fa-file-contract',
                'badge' => 'Resmi',
            ],
            'sss'                      => [
                'title' => 'Sıkça Sorulan Sorular',
                'slug'  => 'sss',
                'icon'  => 'fa-solid fa-circle-question',
                'badge' => 'SSS',
            ],
            'uy-kvkk-aydinlatma-metni' => [
                'title' => 'KVKK Aydınlatma Metni',
                'slug'  => 'uy-kvkk-aydinlatma-metni',
                'icon'  => 'fa-solid fa-shield-halved',
                'badge' => 'Yasal',
            ],
            'uy-mahremiyet-politikasi' => [
                'title' => 'Mahremiyet ve Gizlilik',
                'slug'  => 'uy-mahremiyet-politikasi',
                'icon'  => 'fa-solid fa-lock',
                'badge' => 'Güvenlik',
            ],
            'uy-veli-izin-belgesi'     => [
                'title' => 'Veli İzin Belgesi',
                'slug'  => 'uy-veli-izin-belgesi',
                'icon'  => 'fa-solid fa-file-signature',
                'badge' => 'İndir',
            ],
        ];
    }

    /**
     * İçerik öğesini zenginleştirir ve HTML gövdesini temizler
     */
    public function formatContentItem(array $item): array
    {
        $rawBody = $item['body'] ?? '';
        $item['formatted_body'] = $this->cleanHtmlBody($rawBody);

        // Tahmini okuma süresi hesaplama (~200 kelime / dakika)
        $textOnly = strip_tags($rawBody);
        $wordCount = str_word_count($textOnly);
        $item['read_time_minutes'] = max(1, (int)ceil($wordCount / 180));

        // Açıklama / Özeti doldur
        if (empty($item['description'])) {
            $cleanText = preg_replace('/\s+/', ' ', trim($textOnly));
            $item['description'] = mb_strlen($cleanText) > 160 ? mb_substr($cleanText, 0, 157) . '...' : $cleanText;
        }

        return $item;
    }

    /**
     * HTML gövdesindeki göreceli resim URL'lerini mutlaklaştırır ve WPBakery/WP etiketlerini temizler
     */
    public function cleanHtmlBody(string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Göreceli uploads linklerini https://yonetim.ufkayolculuk.com/uploads/... ile değiştir
        $html = preg_replace(
            '/(src|href)=["\'](?!https?:\/\/|\/\/)(?:\/?)(uploads\/[^"\']+)["\']/i',
            '$1="https://yonetim.ufkayolculuk.com/$2"',
            $html
        );

        // Görsellerin responsive olmasını sağla
        $html = preg_replace('/<img(?![^>]*class=)([^>]*)>/i', '<img class="img-fluid rounded-3 my-3" $1>', $html);

        return $html;
    }
}
