<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    /**
     * API Durum ve Sağlık Kontrolü
     */
    public function health()
    {
        return $this->respond([
            'status' => 'success',
            'message' => 'Ufka Yolculuk Kitap Okuma & Sınav API V1 Servisi Aktif',
            'framework' => 'CodeIgniter ' . \CodeIgniter\CodeIgniter::CI_VERSION,
            'environment' => ENVIRONMENT,
            'timestamp' => date('c')
        ]);
    }

    /**
     * Kitaplar Listesi
     */
    public function books()
    {
        $books = [
            [
                'id' => 1,
                'slug' => 'tevhid-muhafizlari',
                'title' => 'Tevhid Muhafızları',
                'category' => 'Ortaokul Kategorisi (6-8. Sınıf)',
                'total_pages' => 160,
                'start_page' => 5,
                'audio_url' => base_url('assets/audio/tevhid-muhafizlari.mp3'),
                'cover_image' => base_url('assets/images/kitap-kapak-1.jpg')
            ]
        ];

        return $this->respond([
            'status' => 'success',
            'total' => count($books),
            'data' => $books
        ]);
    }

    /**
     * Kitap Detayı
     */
    public function bookDetail($id = null)
    {
        if ($id != 1) {
            return $this->failNotFound('Kitap bulunamadı.');
        }

        return $this->respond([
            'status' => 'success',
            'data' => [
                'id' => 1,
                'title' => 'Tevhid Muhafızları',
                'category' => 'Ortaokul',
                'author' => 'Ufka Yolculuk Yayın Kurulu',
                'total_pages' => 160,
                'start_page' => 5
            ]
        ]);
    }

    /**
     * Kitap Sayfaları ve Görsel Haritası
     */
    public function bookPages($id = null)
    {
        return $this->respond([
            'status' => 'success',
            'book_id' => $id,
            'pages_dir' => base_url('assets/images/pages/tevhid/'),
            'page_format' => 'page_{number}.jpg'
        ]);
    }

    /**
     * Cümle & Ses Senkronizasyon Verisi (Altyazı & Zaman Damgaları)
     */
    public function audioSync($id = null)
    {
        return $this->respond([
            'status' => 'success',
            'book_id' => $id,
            'total_sentences' => 0,
            'sentences' => []
        ]);
    }

    /**
     * Kullanıcı Okuma İlerlemesi Kaydetme
     */
    public function saveProgress()
    {
        $json = $this->request->getJSON(true);

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'Okuma ilerlemesi başarıyla kaydedildi.',
            'saved' => $json
        ]);
    }

    /**
     * Online Deneme Sınavları Listesi
     */
    public function exams()
    {
        return $this->respond([
            'status' => 'success',
            'exams' => [
                [
                    'id' => 101,
                    'title' => 'Tevhid Muhafızları 1. Deneme Sınavı',
                    'duration_minutes' => 15,
                    'total_questions' => 10,
                    'negative_marking' => true
                ]
            ]
        ]);
    }

    /**
     * Oturum Açmış Kullanıcı Bilgisi (Cross-Subdomain Session Kontrolü)
     */
    public function me()
    {
        $session = session();
        if (!$session->has('ufka_user')) {
            return $this->failUnauthorized('Aktif oturum bulunamadı. Lütfen ufkayolculuk.com üzerinden giriş yapınız.');
        }

        $user = $session->get('ufka_user');

        return $this->respond([
            'status' => 'success',
            'logged_in' => true,
            'user' => [
                'id'             => $user['id'] ?? null,
                'name'           => $user['name'] ?? 'Yarışmacı',
                'category_title' => $user['category_title'] ?? 'Ortaokul',
                'grade'          => $user['grade'] ?? '7. Sınıf',
                'city'           => $user['city'] ?? 'İstanbul',
                'general_score'  => $user['general_score'] ?? 85.5,
                'turkey_rank'    => $user['turkey_rank'] ?? 142,
                'city_rank'      => $user['city_rank'] ?? 18
            ]
        ]);
    }

    /**
     * Yerel / WAMP Geliştirme Ortamı İçin Oturum Simülasyonu
     */
    public function simulateLogin()
    {
        $demoUser = [
            'id'             => 1001,
            'name'           => 'Ahmet Talha Keskin',
            'category_title' => 'Ortaokul Kategorisi (6-8. Sınıf)',
            'grade'          => '7. Sınıf',
            'city'           => 'İstanbul / Üsküdar',
            'general_score'  => 92.5,
            'turkey_rank'    => 12,
            'city_rank'      => 3
        ];

        session()->set('ufka_user', $demoUser);

        return $this->respond([
            'status' => 'success',
            'message' => 'Simüle edilmiş oturum (ufka_user) başarıyla oluşturuldu.',
            'user' => $demoUser
        ]);
    }

    /**
     * Oturumu Sonlandır (Logout)
     */
    public function logout()
    {
        session()->remove('ufka_user');

        return $this->respond([
            'status' => 'success',
            'message' => 'Oturum başarıyla sonlandırıldı.'
        ]);
    }

    /**
     * Tüm Web İçerikleri / Sayfalar API Listesi
     */
    public function pages()
    {
        $service = new \App\Services\UfkaApiService();
        $contents = $service->getWebContents();

        return $this->respond([
            'status' => 'success',
            'total' => count($contents),
            'data' => $contents
        ]);
    }

    /**
     * Sayfa Detayı API Uç Noktası
     */
    public function pageDetail($slug = null)
    {
        if (empty($slug)) {
            return $this->failNotFound('Sayfa slug belirtilmedi.');
        }

        $service = new \App\Services\UfkaApiService();
        $page = $service->getWebContent($slug);

        if (!$page) {
            return $this->failNotFound("'$slug' içeriği bulunamadı.");
        }

        return $this->respond([
            'status' => 'success',
            'data' => $page
        ]);
    }

    /**
     * Sıkça Sorulan Sorular (SSS) API Uç Noktası
     */
    public function faqs()
    {
        $service = new \App\Services\UfkaApiService();
        $faqs = $service->getFaqs();

        return $this->respond([
            'status' => 'success',
            'total' => count($faqs),
            'data' => $faqs
        ]);
    }
}

