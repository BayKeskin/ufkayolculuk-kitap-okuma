<?php

namespace App\Controllers;

use App\Services\KitapApiService;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Ufka Yolculuk Yarışmacı Giriş / Çıkış ve Oturum Denetleyicisi
 */
class Auth extends BaseController
{
    protected KitapApiService $apiService;

    public function __construct()
    {
        $this->apiService = new KitapApiService();
    }

    /**
     * Yarışmacı Giriş İşlemi (AJAX & Form POST)
     */
    public function login(): ResponseInterface
    {
        $json = null;
        try {
            $json = $this->request->getJSON(true);
        } catch (\Throwable $e) {
            $json = [];
        }
        $phone = $json['phone'] ?? $this->request->getPost('phone') ?? $this->request->getVar('phone') ?? '';
        $birthDate = $json['birthdate'] ?? $this->request->getPost('birthdate') ?? $this->request->getVar('birthdate') ?? '';

        $phone = trim((string)$phone);
        $birthDate = trim((string)$birthDate);

        if (empty($phone) || empty($birthDate)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'status'  => 'error',
                'message' => 'Lütfen telefon numarası ve doğum tarihini eksiksiz giriniz.',
            ]);
        }

        // Canlı API üzerinden yarışmacıyı doğrula
        $user = $this->apiService->verifyUser($phone, $birthDate);

        if ($user && !empty($user['id'])) {
            // Oturumu başlat
            session()->set('ufka_user', $user);
            
            // Çerez desteği (Cross-tab ve okuyucu için)
            setcookie('uy_user_id', (string)$user['id'], time() + (86400 * 30), '/');

            $redirectUrl = session()->get('redirect_after_login') ?? base_url('/');
            session()->remove('redirect_after_login');

            return $this->response->setJSON([
                'success'  => true,
                'status'   => 'success',
                'message'  => "Hoş geldiniz, {$user['name']}! Girişiniz başarıyla onaylandı.",
                'user'     => $user,
                'redirect' => $redirectUrl,
            ]);
        }

        return $this->response->setStatusCode(401)->setJSON([
            'success' => false,
            'status'  => 'error',
            'message' => 'Girdiğiniz telefon numarası veya doğum tarihi ile eşleşen bir yarışmacı kaydı bulunamadı. Lütfen yarışmaya kayıtlı bilgilerinizi kontrol ediniz.',
        ]);
    }

    /**
     * Oturumu Sonlandır (Logout)
     */
    public function logout()
    {
        session()->remove('ufka_user');
        session()->destroy();

        if (isset($_COOKIE['uy_user_id'])) {
            setcookie('uy_user_id', '', time() - 3600, '/');
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'status'  => 'success',
                'message' => 'Oturum başarıyla sonlandırıldı.',
                'redirect'=> base_url('/')
            ]);
        }

        return redirect()->to(base_url('/'))->with('info', 'Oturumunuz güvenli bir şekilde kapatıldı.');
    }

    /**
     * Aktif Oturum Bilgisini Getir
     */
    public function me(): ResponseInterface
    {
        $user = session()->get('ufka_user');

        if (!$user) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'    => 'error',
                'logged_in' => false,
                'message'   => 'Aktif oturum bulunamadı.'
            ]);
        }

        return $this->response->setJSON([
            'status'    => 'success',
            'logged_in' => true,
            'user'      => $user
        ]);
    }
}
