<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\KitapApiService;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    protected KitapApiService $apiService;

    public function __construct()
    {
        $this->apiService = new KitapApiService();
    }

    /**
     * API Durum ve Sağlık Kontrolü
     */
    public function health()
    {
        return $this->respond([
            'status'      => 'success',
            'service'     => 'KitapApiService (Kitap Okuma & Sınav Bağımsız Servisi)',
            'message'     => 'Ufka Yolculuk Kitap Okuma & Sınav API V1 Servisi Aktif',
            'framework'   => 'CodeIgniter ' . \CodeIgniter\CodeIgniter::CI_VERSION,
            'environment' => ENVIRONMENT,
            'timestamp'   => date('c')
        ]);
    }

    /**
     * Kitaplar Listesi
     */
    public function books()
    {
        $books = $this->apiService->getBooks();

        return $this->respond([
            'status' => 'success',
            'total'  => count($books),
            'data'   => $books
        ]);
    }

    /**
     * Kitap Detayı (Bölümler ve Sayfa Verileriyle)
     */
    public function bookDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('Kitap ID belirtilmedi.');
        }

        $book = $this->apiService->getBook($id, true);

        if (!$book) {
            return $this->failNotFound('Kitap bulunamadı.');
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $book
        ]);
    }

    /**
     * Kitap Sayfaları ve Görsel Haritası
     */
    public function bookPages($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('Kitap ID belirtilmedi.');
        }

        $book = $this->apiService->getBook($id, false);

        if (!$book) {
            return $this->failNotFound('Kitap bulunamadı.');
        }

        $pageTimestamps = $this->apiService->getPageTimestamps($id);

        return $this->respond([
            'status'          => 'success',
            'book_id'         => (int)$id,
            'total_pages'     => $book['total_pages'] ?? count($book['pages'] ?? []),
            'pages'           => $book['pages'] ?? [],
            'page_timestamps' => $pageTimestamps,
        ]);
    }

    /**
     * Cümle & Ses Senkronizasyon Verisi (Altyazı & Zaman Damgaları)
     */
    public function audioSync($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('Kitap ID belirtilmedi.');
        }

        $sync = $this->apiService->getAudioSync($id);

        return $this->respond([
            'status'          => 'success',
            'book_id'         => (int)$id,
            'sound_file'      => $sync['sound_file'],
            'total_sentences' => $sync['total_sentences'],
            'sentences'       => $sync['sentences'],
            'page_timestamps' => $sync['page_timestamps'] ?? (object)[]
        ]);
    }

    /**
     * Tekil Sayfa Zengin Metin & Cümle Altyazı Verisi (Metin Modu İçin)
     */
    public function pageText($bookId = null, $pageNo = null)
    {
        if (empty($bookId) || $pageNo === null) {
            return $this->failNotFound('Kitap ID veya Sayfa Numarası belirtilmedi.');
        }

        $textData = $this->apiService->getPageText($bookId, (int)$pageNo);

        return $this->respond([
            'status'    => 'success',
            'book_id'   => (int)$bookId,
            'page_no'   => (int)$pageNo,
            'body_html' => $textData['body_html'] ?? '',
            'sentences' => $textData['sentences'] ?? []
        ]);
    }

    /**
     * Kullanıcı Okuma İlerlemesi Kaydetme & Senkronizasyon
     */
    public function saveProgress()
    {
        $json = null;
        try {
            $json = $this->request->getJSON(true);
        } catch (\Throwable $e) {
            $json = null;
        }
        if (empty($json) || !is_array($json)) {
            $json = $this->request->getPost();
        }
        if (empty($json) || !is_array($json)) {
            $raw = $this->request->getBody();
            if (!empty($raw)) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    $json = $decoded;
                }
            }
        }
        if (!is_array($json)) {
            $json = [];
        }

        $sessionUser = session()->get('ufka_user');

        $userId      = (int)($json['user_id'] ?? $sessionUser['id'] ?? (isset($_COOKIE['uy_user_id']) ? $_COOKIE['uy_user_id'] : 1001));
        $bookId      = (int)($json['book_id'] ?? 0);
        $page        = (int)($json['page'] ?? 1);
        $audioTime   = (float)($json['audio_time'] ?? 0.0);
        $readSeconds = (int)($json['read_seconds'] ?? 0);
        $isCompleted = (int)($json['is_completed'] ?? 0);

        if (empty($bookId)) {
            return $this->failValidationError('Geçerli bir book_id gönderilmelidir.');
        }

        $result = $this->apiService->saveUserProgress($userId, $bookId, $page, $audioTime, $readSeconds, $isCompleted);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Okuma ilerlemesi başarıyla kaydedildi.',
            'saved'   => $result
        ]);
    }

    /**
     * Kullanıcı İlerlemesini Getir
     */
    public function getProgress($userId = null, $bookId = null)
    {
        $sessionUser = session()->get('ufka_user');
        $targetUserId = (int)($userId ?? $sessionUser['id'] ?? 1001);
        $targetBookId = $bookId !== null ? (int)$bookId : null;

        $progress = $this->apiService->getUserProgress($targetUserId, $targetBookId);

        return $this->respond([
            'status'   => 'success',
            'user_id'  => $targetUserId,
            'book_id'  => $targetBookId,
            'progress' => $progress
        ]);
    }

    /**
     * Online Deneme Sınavları Listesi
     */
    public function exams()
    {
        $exams = $this->apiService->getExams();

        return $this->respond([
            'status' => 'success',
            'total'  => count($exams),
            'exams'  => $exams
        ]);
    }

    /**
     * Deneme Sınavı Detayı ve Soruları
     */
    public function examDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('Sınav ID belirtilmedi.');
        }

        $exam = $this->apiService->getExam($id);
        if (!$exam) {
            return $this->failNotFound('Sınav bulunamadı.');
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $exam
        ]);
    }

    /**
     * Sınav Cevaplarını Gönderme & Karne Puanlama
     */
    public function submitExam($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('Sınav ID belirtilmedi.');
        }

        $json = $this->request->getJSON(true) ?? $this->request->getPost();
        $sessionUser = session()->get('ufka_user');
        $userId = (int)($json['user_id'] ?? $sessionUser['id'] ?? 1001);
        $answers = $json['answers'] ?? [];

        $result = $this->apiService->submitExam($userId, (int)$id, $answers);

        return $this->respond($result);
    }

    /**
     * Kullanıcı İstatistikleri & Karne
     */
    public function stats()
    {
        $sessionUser = session()->get('ufka_user');
        $userId = (int)($sessionUser['id'] ?? 1001);

        $stats = $this->apiService->getUserStats($userId);

        return $this->respond([
            'status' => 'success',
            'data'   => $stats
        ]);
    }

    /**
     * Başarı Sıralamaları (Leaderboard)
     */
    public function leaderboard()
    {
        $leaderboard = $this->apiService->getLeaderboard();

        return $this->respond([
            'status' => 'success',
            'data'   => $leaderboard
        ]);
    }

    /**
     * Oturum Açmış Kullanıcı Bilgisi
     */
    public function me()
    {
        $session = session();
        if (!$session->has('ufka_user')) {
            return $this->failUnauthorized('Aktif oturum bulunamadı. Lütfen giriş yapınız.');
        }

        $user = $session->get('ufka_user');

        return $this->respond([
            'status'    => 'success',
            'logged_in' => true,
            'user'      => [
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
     * Yerel / Test Ortamı İçin Oturum Simülasyonu
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
            'status'  => 'success',
            'message' => 'Simüle edilmiş oturum (ufka_user) başarıyla oluşturuldu.',
            'user'    => $demoUser
        ]);
    }

    /**
     * Oturumu Sonlandır (Logout)
     */
    public function logout()
    {
        session()->remove('ufka_user');

        return $this->respond([
            'status'  => 'success',
            'message' => 'Oturum başarıyla sonlandırıldı.'
        ]);
    }

    /**
     * Tüm Web İçerikleri / Sayfalar API Listesi
     */
    public function pages()
    {
        $contents = $this->apiService->getWebContents();

        return $this->respond([
            'status' => 'success',
            'total'  => count($contents),
            'data'   => $contents
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

        $page = $this->apiService->getWebContent($slug);

        if (!$page) {
            return $this->failNotFound("'$slug' içeriği bulunamadı.");
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $page
        ]);
    }

    /**
     * Sıkça Sorulan Sorular (SSS) API Uç Noktası
     */
    public function faqs()
    {
        $faqs = $this->apiService->getFaqs();

        return $this->respond([
            'status' => 'success',
            'total'  => count($faqs),
            'data'   => $faqs
        ]);
    }
}
