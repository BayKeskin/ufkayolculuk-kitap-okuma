<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    /**
     * Gelen istek öncesi oturum kontrolü - Korumalı sayfalara izinsiz erişimi engeller
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        // 1. Oturum kontrolü
        $isLoggedIn = (bool)($session->get('isLoggedIn') || $session->has('ufka_user'));

        if (!$isLoggedIn) {
            // İsteğin yapıldığı URL'i kaydet (giriş sonrası geri yönlendirme için)
            $currentUri = (string)current_url(true);
            $session->set('redirect_after_login', $currentUri);

            // AJAX veya API isteği ise JSON 401 dön
            $isAjax = $request->isAJAX() 
                || str_contains($request->getHeaderLine('Accept'), 'application/json')
                || str_starts_with(trim($request->getUri()->getPath(), '/'), 'api/');

            if ($isAjax) {
                return Services::response()
                    ->setStatusCode(401)
                    ->setJSON([
                        'status'         => 'error',
                        'success'        => false,
                        'message'        => 'Bu sayfayı veya işlemi görüntülemek için giriş yapmanız gerekmektedir.',
                        'login_required' => true,
                        'login_url'      => base_url('/?auth_required=1')
                    ]);
            }

            // Normal web sayfası isteği ise anasayfaya yönlendir
            return redirect()
                ->to(base_url('/?auth_required=1'))
                ->with('error', 'Bu korumalı sayfaya erişebilmek için lütfen giriş yapınız.');
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
     * Giriş sayfası URL'ini belirle (Portal içi anasayfa yönlendirmesi)
     */
    public static function getLoginUrl(): string
    {
        return base_url('/?auth_required=1');
    }
}
