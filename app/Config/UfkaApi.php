<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class UfkaApi extends BaseConfig
{
    /**
     * REST API Base URL
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
     * Base URL for uploads / images / pdfs
     */
    public string $uploadsURL = 'https://yonetim.ufkayolculuk.com/';

    /**
     * Cache duration in seconds for API responses (e.g. 600 = 10 mins)
     */
    public int $cacheTTL = 600;

    /**
     * Bearer Access Token cache duration in seconds
     */
    public int $tokenTTL = 6600;

    /**
     * HTTP request timeout in seconds
     */
    public int $timeout = 15;

    public function __construct()
    {
        parent::__construct();

        $this->baseURL    = env('api.ufka.baseURL', $this->baseURL);
        $this->username   = env('api.ufka.username', $this->username);
        $this->password   = env('api.ufka.password', $this->password);
        $this->uploadsURL = env('api.ufka.uploadsURL', $this->uploadsURL);
        $this->timeout    = (int)env('api.ufka.timeout', $this->timeout);
    }
}
