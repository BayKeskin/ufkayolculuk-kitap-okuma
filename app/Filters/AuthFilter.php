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

        // 1. Oturum kontrolü ve yerel oturum garantisi (ufkayolculuk.com bağımlılığı tamamen kaldırıldı)
        if (!$session->has('ufka_user')) {
            // Portali bağımsız ve kesintisiz çalıştırmak için yerel katılımcı oturumu tanımla
            $defaultUser = [
                'id'        => 1,
                'name'      => 'Ahmet Yılmaz',
                'email'     => 'ahmet.yilmaz@okuma.tkmdev.com',
                'role'      => 'student',
                'grade'     => 'ortaokul',
                'school'    => 'Gazi Ortaokulu',
                'city'      => 'İstanbul',
            ];
            $session->set('ufka_user', $defaultUser);
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
        return base_url('/');
    }
}
