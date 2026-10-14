<?php

namespace App\Services;

use Config\KitapApi;
use Config\UfkaApi;

/**
 * UfkaApiService (Geriye Uyumluluk Köprüsü)
 * 
 * Bu sınıf, KitapOkuma projesinde KitapApiService üzerine inşa edilmiş uyumluluk sınıfıdır.
 * Tüm işlemler artık doğrudan App\Services\KitapApiService tarafından yürütülmektedir.
 */
class UfkaApiService extends KitapApiService
{
    public function __construct($config = null)
    {
        if ($config instanceof UfkaApi) {
            $kitapConfig = new KitapApi();
            $kitapConfig->baseURL    = $config->baseURL;
            $kitapConfig->username   = $config->username;
            $kitapConfig->password   = $config->password;
            $kitapConfig->uploadsURL = $config->uploadsURL;
            $kitapConfig->cacheTTL   = $config->cacheTTL;
            $kitapConfig->tokenTTL   = $config->tokenTTL;
            $kitapConfig->timeout    = $config->timeout;
            parent::__construct($kitapConfig);
        } else {
            parent::__construct($config instanceof KitapApi ? $config : null);
        }
    }
}
