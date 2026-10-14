<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Kitap Okuma & Sınav Portalı - Bağımsız API Servis Yapılandırması
 * 
 * Bu yapılandırma sınıfı, Kitap Okuma projesinin (kitap-okuma) kendi API servisleri için kullanılır.
 * Harici Ufka Yolculuk web sitesi dizininden tamamen bağımsızdır.
 */
class KitapApi extends BaseConfig
{
    /**
     * Merkezi REST API Base URL
     */
    public string $baseURL = 'https://ufkayolculuk.com/rest/get/';

    /**
     * HTTP Basic Auth Username
     */
    public string $username = 'uy_Rest-Worker';

    /**
     * HTTP Basic Auth Password
     */
    public string $password = 'UfkA_Yol-1448';

    /**
     * Medya ve Yüklemeler URL Kökü
     */
    public string $uploadsURL = 'https://yonetim.ufkayolculuk.com/';

    /**
     * API Yanıtları Önbellek Süresi (saniye) - Örn: 600 = 10 dakika
     */
    public int $cacheTTL = 600;

    /**
     * Bearer Access Token Önbellek Süresi
     */
    public int $tokenTTL = 6600;

    /**
     * HTTP İstek Zaman Aşımı (saniye)
     */
    public int $timeout = 10;

    /**
     * Canlı API Bağlantı Hatasında Yerel Zengin Veri Motorunu Kullan (Fallback)
     */
    public bool $enableLocalFallback = true;

    public function __construct()
    {
        parent::__construct();

        $this->baseURL            = env('api.kitap.baseURL', $this->baseURL);
        $this->username           = env('api.kitap.username', $this->username);
        $this->password           = env('api.kitap.password', $this->password);
        $this->uploadsURL         = env('api.kitap.uploadsURL', $this->uploadsURL);
        $this->cacheTTL           = (int)env('api.kitap.cacheTTL', $this->cacheTTL);
        $this->tokenTTL           = (int)env('api.kitap.tokenTTL', $this->tokenTTL);
        $this->timeout            = (int)env('api.kitap.timeout', $this->timeout);
        $this->enableLocalFallback = (bool)env('api.kitap.enableLocalFallback', $this->enableLocalFallback);
    }
}
