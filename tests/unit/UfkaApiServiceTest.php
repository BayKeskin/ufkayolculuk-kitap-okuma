<?php

namespace Tests\Unit;

use App\Services\UfkaApiService;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * UfkaApiService ve Dinamik Kitap API Entegrasyonu Birim Testleri
 * @internal
 */
final class UfkaApiServiceTest extends CIUnitTestCase
{
    protected UfkaApiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new UfkaApiService();
    }

    /**
     * Servis örneğinin doğru yapılandırıldığını test eder
     */
    public function testServiceInitialization(): void
    {
        $this->assertInstanceOf(UfkaApiService::class, $this->service);
    }

    /**
     * Canlı API Bearer Token mekanizmasını test eder
     */
    public function testGetAccessToken(): void
    {
        $token = $this->service->getAccessToken();
        $this->assertNotEmpty($token, 'API Bearer Token alınamadı.');
        $this->assertIsString($token);
        $this->assertStringStartsWith('uy_act_', $token);
    }

    /**
     * Canlı API getBooks() metodunu ve veri yapısını test eder
     */
    public function testGetBooks(): void
    {
        // Canlı API çağrısı
        $books = $this->service->getBooks(false);

        $this->assertIsArray($books);
        $this->assertNotEmpty($books, 'Kitap listesi boş döndü.');

        $firstBook = $books[0];
        $this->assertArrayHasKey('id', $firstBook);
        $this->assertArrayHasKey('name', $firstBook);
        $this->assertArrayHasKey('cover_image', $firstBook);
        $this->assertArrayHasKey('level', $firstBook);
        $this->assertArrayHasKey('author', $firstBook);
    }

    /**
     * Canlı API getBook($id) detay, sayfa ve bölüm entegrasyonunu test eder
     */
    public function testGetBookDetail(): void
    {
        // 8 numaralı aktif yarışma kitabı
        $book = $this->service->getBook(8, true, false);

        $this->assertNotNull($book, 'Kitap 8 detayı getirilemedi.');
        $this->assertIsArray($book);
        $this->assertEquals(8, $book['id']);
        $this->assertNotEmpty($book['name']);

        // Sayfa listesi ve görseller kontrolü
        $this->assertArrayHasKey('pages', $book);
        $this->assertIsArray($book['pages']);
        $this->assertNotEmpty($book['pages'], 'Kitabın sayfaları boş döndü.');

        $firstPage = $book['pages'][0];
        $this->assertArrayHasKey('page_no', $firstPage);
        $this->assertArrayHasKey('image', $firstPage);

        // Bölümler kontrolü
        $this->assertArrayHasKey('chapters', $book);
        $this->assertIsArray($book['chapters']);
    }

    /**
     * Kullanıcı okuma ilerlemesi kaydetme ve getirme döngüsünü test eder
     */
    public function testSaveAndGetUserProgress(): void
    {
        $userId = 1001;
        $bookId = 8;
        $page = 14;
        $audioTime = 42.5;
        $readSeconds = 180;

        // 1. İlerleme Kaydet (saveUserProgress)
        $saveResult = $this->service->saveUserProgress($userId, $bookId, $page, $audioTime, $readSeconds);
        $this->assertIsArray($saveResult);
        $this->assertTrue($saveResult['status'] ?? false, 'İlerleme kaydedilemedi.');

        // 2. İlerlemeyi Oku (getUserProgress)
        $progress = $this->service->getUserProgress($userId, $bookId, false);
        $this->assertNotNull($progress, 'Kaydedilen ilerleme okunamadı.');
        $this->assertIsArray($progress);
        $this->assertEquals($bookId, (int)($progress['book_id'] ?? 0));
        $this->assertEquals($page, (int)($progress['last_page'] ?? 0));
    }

    /**
     * 10 dakikalık cache katmanını ve önbellekten okumayı test eder
     */
    public function testCachingMechanism(): void
    {
        // İlk çağrı (önbelleğe kaydeder)
        $booksFirst = $this->service->getBooks(true);
        $this->assertIsArray($booksFirst);

        // İkinci çağrı (önbellekten getirmeli)
        $booksCached = $this->service->getBooks(true);
        $this->assertIsArray($booksCached);
        $this->assertEquals(count($booksFirst), count($booksCached));
    }

    /**
     * API hatası ve bulunamayan kitap durumunda güvenli fallback mimarisini test eder
     */
    public function testFallbackMechanism(): void
    {
        // Var olmayan bir kitap ID'si
        $fallbackBook = $this->service->getBook(9999999);
        $this->assertNull($fallbackBook, 'Olmayan kitap için güvenli null/fallback dönmeli.');

        // Fallback kitap listesi kontrolü
        $fallbackBooks = $this->service->getBooks();
        $this->assertIsArray($fallbackBooks);
        $this->assertNotEmpty($fallbackBooks);
    }
}
