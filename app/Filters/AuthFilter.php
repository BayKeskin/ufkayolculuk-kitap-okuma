<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    /**
     * Gelen istek öncesi oturum kontrolü
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        // 1. Ana siteden (ufkayolculuk.com) gelen oturum var mı?
        if (!$session->has('ufka_user')) {
            // Eğer istek API veya AJAX ise JSON 401 döndür
            if ($request->isAJAX() || str_contains($request->getUri()->getPath(), 'api/')) {
                return Services::response()
                    ->setStatusCode(401)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Oturum bulunamadı. Lütfen ufkayolculuk.com üzerinden giriş yapınız.',
                        'login_url' => self::getLoginUrl()
                    ]);
            }

            // Normal web sayfası ise ana sitenin giriş ekranına yönlendir
            $currentUrl = (string) current_url();
            $redirectUrl = self::getLoginUrl() . '?return_url=' . urlencode($currentUrl);

            return redirect()->to($redirectUrl);
        }

        // 2. Oturum varsa kullanıcı bilgilerini tüm View katmanına otomatik aktar
        $currentUser = $session->get('ufka_user');
        Services::renderer()->setData(['currentUser' => $currentUser]);
    }

    /**
     * İstek sonrası işlemler
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // İhtiyaç halinde ek işlem yapılabilir
    }

    /**
     * Giriş sayfası URL'ini belirle (Geliştirme / Canlı ortam uyumlu)
     */
    public static function getLoginUrl(): string
    {
        // Ortam değişkeninden veya config'den alınabilir
        $envLoginUrl = env('app.mainSiteLoginUrl');
        if (!empty($envLoginUrl)) {
            return $envLoginUrl;
        }

        // Yerel WAMP ortamında: http://localhost/ufkayolculuk/giris
        if (str_contains($_SERVER['HTTP_HOST'] ?? '', 'localhost')) {
            return 'http://localhost/ufkayolculuk/giris';
        }

        // Canlı ortamda: https://ufkayolculuk.com/giris
        return 'https://ufkayolculuk.com/giris';
    }
}
