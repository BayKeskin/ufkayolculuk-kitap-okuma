<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Portal Ana Sayfası (Dinamik Kitap API Entegrasyonlu)
     */
    public function index(): string
    {
        $books = $this->apiService->getBooks();
        return view('home', ['books' => $books]);
    }

    /**
     * Çift Sayfalı Kitap Okuyucu
     */
    public function kitapOku(): string
    {
        return view('kitap_oku');
    }

    /**
     * Kitaplar Listesi & Arşiv (Dinamik Kitap API Entegrasyonlu)
     */
    public function kitaplar(): string
    {
        $books = $this->apiService->getBooks();
        return view('kitaplar', ['books' => $books]);
    }

    /**
     * Online Deneme Sınavları
     */
    public function denemeSinavlari(): string
    {
        return view('deneme_sinavlari');
    }

    /**
     * Sınav Odak Ekranı
     */
    public function sinavEkrani(): string
    {
        return view('sinav_ekrani');
    }

    /**
     * Öğrenci/Yarışmacı Karnesi & İstatistikler
     */
    public function dashboard(): string
    {
        return view('dashboard');
    }

    /**
     * Başarı Sıralamaları & Kürsü
     */
    public function siralamalar(): string
    {
        return view('siralamalar');
    }

    protected \App\Services\KitapApiService $apiService;

    public function __construct()
    {
        $this->apiService = new \App\Services\KitapApiService();
    }

    /**
     * Kurumsal Bilgi & Şartname Sayfası (Ufka Yolculuk API Entegrasyonlu)
     */
    public function sayfa(?string $slug = null): string
    {
        $targetSlug = $slug ?? $this->request->getGet('slug') ?? 'hakkimizda';
        $targetSlug = trim($targetSlug);

        $corporatePages = $this->apiService->getCorporatePages();
        $recentAnnouncements = $this->apiService->getAnnouncements(4);

        $isFaqPage = in_array(strtolower($targetSlug), ['sss', 'sikca-sorulan-sorular', 'faq']);
        $faqs = $isFaqPage ? $this->apiService->getFaqs() : [];

        $page = $this->apiService->getWebContent($targetSlug);

        // SSS sayfası için özel fallback
        if (!$page && $isFaqPage) {
            $page = [
                'id' => 0,
                'title' => 'Sıkça Sorulan Sorular (SSS)',
                'slug' => 'sss',
                'type' => 'sss',
                'description' => 'Yarışma kuralları, başvuru şartları, ödüller ve sınav süreci ile ilgili en çok merak edilen sorular.',
                'formatted_body' => '',
                'read_time_minutes' => 6,
                'category_title' => 'Rehber & Destek',
                'publish_time' => date('d.m.Y'),
            ];
        }

        $data = [
            'page'                => $page,
            'activeSlug'          => $targetSlug,
            'corporatePages'      => $corporatePages,
            'recentAnnouncements' => $recentAnnouncements,
            'isFaqPage'           => $isFaqPage,
            'faqs'                => $faqs,
        ];

        return view('sayfa', $data);
    }
}
