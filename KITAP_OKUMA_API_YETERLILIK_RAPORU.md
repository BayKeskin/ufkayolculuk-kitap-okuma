# 📖 Ufka Yolculuk - Kitap Okuma & Sesli Dinleme Sistemi
## REST API Yeterlilik, Eksiklik ve Geliştirme Raporu

> **Belge Sürümü:** 1.0  
> **Tarih:** 12 Ekim 2026  
> **İlgili Projeler:**  
> - Kitap Okuma & Sınav Arayüzü: `C:\wamp64\www\ufkayolculuk-kitap-okuma`  
> - Ana Portal & API Backend: `C:\wamp64\www\ufkayolculuk` (`UfkaApiService.php`)  
> **Hedef:** Mevcut merkezi REST API servislerinin dijital kitap okuma, senkronize ses dinleme ve üye ilerleme takibi için yeterliliğini değerlendirmek ve gerekli API revizyonlarını belirlemek.

---

## 1. Yönetici Özeti (Executive Summary)

Ufka Yolculuk için geliştirilen yeni nesil **Çift Sayfalı Kitap Okuyucu (`reader.js`)**, kullanıcılara iki temel okuma modu sunmaktadır:
1. **Görsel Mod (Scan View):** Orijinal basılı kitabın taranmış yüksek çözünürlüklü sayfalarını sunar.
2. **Metin Modu & Canlı Ses Senkronizasyonu (Text & Synchronized Audio):** Cümle cümle ayrıştırılmış metin sunar; anlatıcı seslendirdikçe ilgili cümle parlak mavi arka planla (`.active-sentence`) vurgulanır ve metne tıklandığında ses tam o saniyeye atlar.

Mevcut merkezi API incelendiğinde; **Görsel Mod için API altyapısının kısmen mevcut olduğu**, ancak **Metin Modu, Cümle-Ses Senkronizasyonu, Bölümler/İçindekiler ve Ses Saniyesi Takibi için mevcut API'nin YETERSİZ olduğu** tespit edilmiştir.

| Fonksiyon / Özellik | Mevcut API Durumu | Yeterlilik | Gereken Eylem |
| :--- | :--- | :---: | :--- |
| **Kitap Listesi & Kapaklar** | `getBooks`, `getBookCategories` | 🟡 Kısmen Yeterli | Metadata alanları (`start_page`, `author`, `level`) eklenmeli. |
| **Görsel Sayfa Taramaları** | `getBook/{id}` (JPG linkleri) | 🟢 Yeterli | `image` URL listesi mevcut. |
| **İçindekiler / Bölümler (TOC)** | Mevcut değil | 🔴 **Yetersiz** | `chapters` dizisi API yanıtına eklenmeli. |
| **Metin Modu (Sayfa Metinleri)** | Mevcut değil | 🔴 **Yetersiz** | Her sayfanın `body` / `text_html` içeriği eklenmeli. |
| **Cümle-Ses Zaman Damgaları** | Mevcut değil | 🔴 **Yetersiz** | Cümle başlangıç/bitiş saniyeleri (`cues`) eklenmeli. |
| **Kaldığı Sayfayı Kaydetme** | `saveUserPage/{user}/{book}/{page}` | 🟢 Yeterli | Sayfa bazlı kayıt çalışıyor. |
| **Kaldığı Ses Saniyesini Kaydetme**| Mevcut değil | 🔴 **Yetersiz** | `saveUserProgress` (audio_time ile) oluşturulmalı. |

---

## 2. Mevcut API Uç Noktalarının İncelenmesi

### 2.1. `POST | GET` /rest/get/getBooks
- **Mevcut Yanıt:**
  ```json
  [
    {
      "id": "14",
      "name": "Dürüstlük Yolculuğu",
      "image": "uploads/books/durustluk.jpg",
      "pdf_file": "uploads/pdf/durustluk.pdf",
      "sound_file": "uploads/audio/durustluk.mp3",
      "total_image_size": 14859200
    }
  ]
  ```
- **Eksikler:**
  - `start_page`: Kitap kapağı, içindekiler ve jenerik sayfaları atlanıp asıl metin ve seslendirme kaçıncı sayfadan başlıyor? (Örn: Tevhid Muhafızları için sayfa 5). Bu alan API'de yoktur.
  - `total_pages`: Kitabın toplam sayfa sayısı eksik.
  - `author`: Yazar/yayın bilgisi eksik.
  - `category_name` / `level`: Kitabın yaş/kademe düzeyi ("İlkokul", "Ortaokul", "Lise") kitap nesnesinde doğrudan yer almıyor.
  - `chapters`: Bölüm listesi ve süreleri yok.

---

### 2.2. `POST | GET` /rest/get/getBook/{id}
- **Mevcut Yanıt:**
  ```json
  {
    "id": "14",
    "name": "Dürüstlük Yolculuğu",
    "pages": [
      {
        "id": "1",
        "image": "https://ufkayolculuk.com/uploads/books/14/page1.jpg",
        "image_size": 124500
      }
    ],
    "total_image_size": 244300
  }
  ```
- **Kritik Eksiklik:**
  - Yanıtta sayfalara ait **hiçbir metin içeriği** bulunmamaktadır.
  - Seslendirmeyle senkronize çalışan **cümle zaman damgaları (start time, end time)** bulunmamaktadır.
  - Bu haliyle okuyucu sadece taranmış resimleri (`.jpg`) gösterebilir; metin moduna geçildiğinde ekran boş kalacaktır.

---

### 2.3. `POST` /rest/get/saveUserPage/{user_id}/{book_id}/{page}
- **Mevcut Durum:** Yalnızca sayfa numarasını int olarak kaydeder.
- **Eksiklik:** Kullanıcı kitabı dinlerken 15. dakikada uygulamayı kapattığında, tekrar açtığında sesin kaldığı saniyeden (`current_audio_time`) devam edebilmesi için ses zamanı saklanmamaktadır.

---

## 3. Kitap Okuma Motorunun (`reader.js`) Veri İhtiyaçları

Prototipte yer alan ve 185 sayfalık Tevhid Muhafızları kitabında kusursuz çalışan `SEED_CACHE` veri şeması şu şekildedir:

```javascript
// Kitap Konfigürasyonu
{
  id: 'tevhid-muhafizlari',
  apiId: 11,
  title: 'Tevhid Muhafızları',
  level: 'Ortaokul Düzeyi',
  startPage: 5,        // İlk 4 sayfa kapak/boş; metin 5'te başlıyor
  totalPages: 185,
  audioSrc: 'assets/audio/tevhid-muhafizlari.mp3',
  chapters: [
    { title: '1. Bölüm - Boş Damacana', page: 5, time: 2.313 },
    { title: 'Sayfa 10 - Açlık ve Emniyet', page: 10, time: 379.95 }
  ]
}

// Sayfa İçi Cümle ve Zaman Verisi (Örnek: Sayfa 5)
"5": {
  "pageNo": 5,
  "image": "https://ufkayolculuk.com/uploads/2025-09/pdf_page_11_5.jpg",
  "body": "<a class='subtitlePart' data-time='2.313' data-time2='3.949' data-start='2313' data-end='3949'>1. Bölüm Boş Damacana</a> <a class='subtitlePart' data-time='4.942' data-time2='6.203'>Merhaba sevgili okur.</a>"
}
```

---

## 4. Önerilen API Güncelleme ve Çözüm Planı

Mevcut sistemleri kırmadan (geriye dönük uyumlu) API'ye yapılması gereken güncellemeler:

### 4.1. `getBooks` Servisine Yeni Alanlar Eklenmesi

`GET /rest/get/getBooks` yanıtına aşağıdaki alanlar dahil edilmelidir:

```json
{
  "id": 11,
  "name": "Tevhid Muhafızları",
  "category_id": 7,
  "category_name": "Ortaokul Düzeyi",
  "author": "Ufka Yolculuk Yayınları",
  "start_page": 5,
  "total_pages": 185,
  "sound_file": "https://ufkayolculuk.com/uploads/audio/tevhid-muhafizlari.mp3",
  "sound_duration": 14250,
  "cover_image": "https://ufkayolculuk.com/uploads/books/book-tevhid.svg",
  "chapters": [
    { "title": "1. Bölüm - Boş Damacana", "page": 5, "time": 2.313 },
    { "title": "2. Bölüm - Açlık ve Emniyet", "page": 10, "time": 379.95 },
    { "title": "3. Bölüm - Tevekkül Notu", "page": 20, "time": 1228.72 }
  ]
}
```

---

### 4.2. `getBook/{id}` Servisine Metin & Cümle Desteği (`with_text=1`)

İstemci `POST /rest/get/getBook/11` isteğinde `with_text=1` parametresi gönderdiğinde sayfa dizisine metin ve zaman damgaları eklenmelidir:

```json
{
  "id": 11,
  "name": "Tevhid Muhafızları",
  "start_page": 5,
  "total_pages": 185,
  "pages": [
    {
      "page_no": 5,
      "image": "https://ufkayolculuk.com/uploads/2025-09/pdf_page_11_5.jpg",
      "image_size": 145000,
      "body_html": "<a class='subtitlePart' data-time='2.313' data-time2='3.949'>1. Bölüm Boş Damacana</a> <a class='subtitlePart' data-time='4.942' data-time2='6.203'>Merhaba sevgili okur.</a>",
      "sentences": [
        {
          "text": "1. Bölüm Boş Damacana",
          "start_time": 2.313,
          "end_time": 3.949
        },
        {
          "text": "Merhaba sevgili okur.",
          "start_time": 4.942,
          "end_time": 6.203
        }
      ]
    }
  ]
}
```

> **Performans Notu:** 185 sayfalık tam metin yaklaşık 800 KB tutar. İstemci mobil veri tasarrufu sağlamak isterse `page=5&limit=10` şeklinde sayfalı (paginated) çekme seçeneği de API'ye eklenebilir.

---

### 4.3. Yeni Uç Nokta: `saveUserProgress` (Gelişmiş İlerleme Kaydı)

- **Uç Nokta:** `POST /rest/get/saveUserProgress`
- **Açıklama:** Kullanıcının hem kaldığı sayfayı hem de seslendirmede kaldığı saniyeyi kaydeder.
- **İstek Parametreleri:**
  | Parametre | Tip | Zorunlu mu? | Açıklama |
  | :--- | :--- | :---: | :--- |
  | `user_id` | `int` | Evet | Kullanıcı ID |
  | `book_id` | `int` | Evet | Kitap ID |
  | `page` | `int` | Evet | Kalınan son sayfa no |
  | `audio_time` | `float` | Hayır | Ses çaların kaldığı saniye (örn: `412.5`) |
  | `read_seconds` | `int` | Hayır | Bu oturumda okunan toplam süre |
  | `is_completed` | `tinyint` | Hayır | Kitap bitti mi? (0 veya 1) |

- **Örnek Başarılı Yanıt:**
  ```json
  {
    "status": true,
    "message": "İlerleme başarıyla kaydedildi.",
    "page": 24,
    "audio_time": 412.5,
    "completion_percent": 13.5
  }
  ```

---

### 4.4. CodeIgniter 4 Servis Katmanı (`UfkaApiService.php`) Güncellemesi

Ana sitede (`C:\wamp64\www\ufkayolculuk\app\Services\UfkaApiService.php`) eksik olan şu metodlar eklenmelidir:

```php
/**
 * Kitabın tüm detaylarını, sayfalarını ve metin verilerini döner
 */
public function getBookDetails(int $bookId, bool $withText = true, bool $useCache = true): ?array
{
    $params = ['with_text' => $withText ? 1 : 0];
    return $this->request("getBook/{$bookId}", $params, 'POST', $useCache);
}

/**
 * Kullanıcının okuma ve ses dinleme ilerlemesini kaydeder
 */
public function saveUserProgress(int $userId, int $bookId, int $page, float $audioTime = 0.0): array
{
    $postData = [
        'user_id'    => $userId,
        'book_id'    => $bookId,
        'page'       => $page,
        'audio_time' => $audioTime,
    ];
    return $this->request('saveUserProgress', $postData, 'POST', false) ?? ['status' => false];
}
```

---

## 5. Uygulama ve Geliştirme Yol Haritası

1. **Aşama 1 (Veritabanı Hazırlığı):**
   - Kitap bölümleri için `book_chapters` (id, book_id, title, page_no, audio_time, order_no) tablosunun tanımlanması.
   - Sayfa metinleri ve cümle zaman damgaları için `book_pages` (id, book_id, page_no, image_url, body_html, sentences_json) yapısının netleştirilmesi.
   - Kullanıcı ilerlemesi için `user_book_progress` (user_id, book_id, last_page, last_audio_time, total_read_seconds, updated_at) tablosunun oluşturulması.

2. **Aşama 2 (Backend API Controller Güncellemesi):**
   - `getBooks` uç noktasına `start_page`, `author`, `level` ve `chapters` eklenmesi.
   - `getBook/{id}` servisine `with_text=1` parametresiyle metin ve cümle zaman damgalarının bağlanması.
   - `saveUserProgress` POST servisinin kodlanması.

3. **Aşama 3 (Frontend Entegrasyonu):**
   - `kitap-oku.html` ve `reader.js` içerisindeki statik `SEED_CACHE` mock verisinin, dinamik `fetch('/rest/get/getBook/{id}?with_text=1')` çağrısına bağlanması.
   - Ses durdurulduğunda veya sayfa değiştiğinde `saveUserProgress` API servisine anlık senkronizasyon yapılması.
