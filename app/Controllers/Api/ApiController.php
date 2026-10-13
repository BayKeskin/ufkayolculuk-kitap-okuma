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
}
