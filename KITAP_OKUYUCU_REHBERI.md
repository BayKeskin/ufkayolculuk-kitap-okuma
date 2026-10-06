# 📖 Ufka Yolculuk - Kitap Okuyucu ve Sesli Dinleme Sistemi Geliştirici & Kullanım Rehberi

Bu rehber; Ufka Yolculuk portalına **yeni bir kitap ekleme**, **ses ve sayfa senkronizasyonu yapma**, **okuma modlarını yönetme** ve **sistemi özelleştirme** adımlarını detaylı olarak açıklamaktadır.

---

## 1. Sisteme Yeni Bir Kitap Ekleme (Adım Adım)

Sisteme yeni bir kitap eklemek için 4 basit adım izlenir:

### Adım 1: Ses Dosyasını (`.mp3`) Ekleyin
- Kitabın tam seslendirme dosyasını `assets/audio/` dizinine kopyalayın.
- *Örnek:* `assets/audio/yeni-kitap.mp3`

### Adım 2: Kitap Kapağını Ekleyin
- Kitap kapak görselini `assets/images/books/` dizinine ekleyin.
- *Örnek:* `assets/images/books/book-yeni-kitap.svg` (veya `.png`, `.webp`, `.jpg`)

### Adım 3: Kitap Konfigürasyonunu Tanımlayın
`assets/js/build_reader.js` (veya `assets/js/reader.js`) dosyasındaki `this.books` nesnesine yeni kitabınızı ekleyin:

```javascript
'yeni-kitap': {
  id: 'yeni-kitap',
  apiId: 14,                                     // Ufka Yolculuk API'deki kitap ID'si
  title: 'Yeni Kitap Başlığı',
  level: 'Lise Düzeyi',                           // Yaş / Kategori düzeyi
  badgeColor: '#6366f1',                         // Başlık yanındaki rozet rengi
  startPage: 5,                                  // Kapaklar atlanarak metnin başladığı sayfa
  totalPages: 200,                               // Kitabın toplam sayfa sayısı
  audioSrc: 'assets/audio/yeni-kitap.mp3?v=1.0', // Ses dosyasının yolu
  coverImg: 'assets/images/books/book-yeni-kitap.svg',
  author: 'Ufka Yolculuk Yayınları',
  chapters: [                                    // İçindekiler listesi ve başlangıç saniyeleri
    { title: '1. Bölüm - Giriş', page: 5, time: 2.5 },
    { title: '2. Bölüm - Yolculuk Başlıyor', page: 24, time: 820.0 },
    { title: '3. Bölüm - Büyük Sır', page: 58, time: 1950.0 }
  ]
}
```

### Adım 4: Sayfa ve Cümle Verilerini Önbelleğe Alma (Opsiyonel ama Tavsiye Edilir)
API'ye bağlı kalmadan 0 gecikmeyle (offline bile) çalışması için sayfaları JSON önbelleğe alıp derleyebilirsiniz:
```bash
node assets/js/build_reader.js
```

### Adım 5: Üst Menüye ve Ana Sayfaya Bağlantı Ekleyin
`kitap-oku.html` dosyasındaki kitap seçici açılır menüsüne (`.reader-book-menu`) yeni kitabınızı ekleyin:
```html
<li>
  <a class="dropdown-item" href="javascript:void(0)" data-switch-book="yeni-kitap">
    <img src="assets/images/books/book-yeni-kitap.svg" class="book-thumb-mini" alt="Yeni Kitap">
    <div>
      <div class="fw-bold">Yeni Kitap Başlığı</div>
      <small class="text-muted">Lise Düzeyi</small>
    </div>
  </a>
</li>
```
Ana sayfadan doğrudan o kitabı açmak için:
`<a href="kitap-oku.html?book=yeni-kitap">Kitabı Oku</a>`

---

## 2. Okuma Modları ve Özellikleri

### 🖼️ 1. Görsel Mod (Varsayılan)
- Orijinal taranmış kitap sayfalarını (`.jpg`) yüksek çözünürlükte gösterir.
- Sayfa oranları ve orijinal sayfa mizanpajı birebir korunur.

### 📝 2. Metin Modu (Text Mode)
- **Geçiş:** Üst barda yer alan **"Metin Modu"** butonuna basılarak veya klavyeden **`T`** tuşuna basılarak açılır.
- **Cümle Cümle Ayrıştırma:** Her cümle (`.subtitlePart`) bağımsız bir tıklanabilir elemandır.
- **Tıklayarak Dinleme:** Metindeki herhangi bir cümleye tıklandığında ses anında o cümlenin tam saniyesine (`data-time`) atlar ve seslendirmeye başlar.
- **Anlık Vurgulama:** Ses ilerledikçe anlatıcının telaffuz ettiği cümle canlı olarak mavi neon arka plan (`.active-sentence`) ile vurgulanır ve otomatik görünür alana kayar.

---

## 3. Sayfa Geçiş Mantığı (Çift Sayfa Kaydırmalı)

- **Başlangıç:** `startPage: 5` ayarlandığında sol tarafta **Sayfa 5**, sağ tarafta **Sayfa 6** açılır.
- **Sonraki Butonu (`→`):** Sağdaki sayfa sol tarafa geçer, sağ tarafa bir sonraki sayfa gelir (`5-6` ➔ `6-7` ➔ `7-8`).
- **Önceki Butonu (`←`):** İşlem geriye doğru işler (`7-8` ➔ `6-7` ➔ `5-6`).
- **Minimum Sayfa Sınırı:** Kitap 5. sayfadan başlıyorsa kullanıcı arama kutusuna `1`, `2`, `3`, `4` veya `0` yazsa dahi sistem otomatik olarak **`5`** değerine düzeltir ve 5. sayfayı açar.
- **Oto Çevir (Sesle İlerleme):** Alt çubuktaki *"Oto Çevir"* seçiliyken ses sayfadaki son cümleyi okuyup bitirdiğinde sayfalar otomatik olarak sıradaki sayfaya kayar.

---

## 4. Renk Temaları

Okuyucu 3 farklı ortam temasına sahiptir (üst bardaki tema ikonundan değiştirilebilir):
1. **Aydınlık (Light):** Gündüz okumaları için ferah beyaz kağıt dokusu.
2. **Sepya (Sepia):** Gözü yormayan sıcak sarı kitap kağıdı ve kahve tonları.
3. **Gece (Dark):** Düşük ışıklı ortamlar ve OLED ekranlar için derin koyu tema.

---

## 5. Klavye Kısayolları

| Kısayol Tuşu | Eylem |
| :--- | :--- |
| **`→` (Sağ Ok)** | Sonraki Sayfaya Geç |
| **`←` (Sol Ok)** | Önceki Sayfaya Geç |
| **`Boşluk` (Space)** | Sesli Okumayı Oynat / Duraklat |
| **`T`** | Görsel Mod / Metin Modu Değiştir |
| **`F`** | Tam Ekran Modunu Aç / Kapat |
| **`Z`** | Sayfayı Yakınlaştır / Uzaklaştır |
