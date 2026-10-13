<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tevhid Muhafızları - Kitap Oku ve Sesli Dinle | Ufka Yolculuk</title>
  <meta name="description" content="Ufka Yolculuk Tevhid Muhafızları interaktif çift sayfalı kitap okuma ve senkronize sesli dinleme deneyimi.">

  <!-- Google Fonts: Plus Jakarta Sans & Merriweather -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS (Yerel) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome 6 (Yerel) -->
  <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">

  <!-- Okuyucu Özel CSS -->
  <link rel="stylesheet" href="assets/css/reader.css?v=3.5">
</head>
<body class="reader-body" data-theme="light">

  <!-- Üst Okuma İlerleme Çizgisi -->
  <div class="reader-progress-line">
    <div class="reader-progress-fill" id="readingProgressFill"></div>
  </div>

  <!-- =========================================================================
       Üst Navigasyon Çubuğu (Header)
       ========================================================================= -->
  <header class="reader-top-header">
    <div class="reader-header-inner">
      
      <!-- Sol: Geri Dön ve Logo -->
      <div class="reader-header-left">
        <a href="home.html" class="reader-btn-back" title="Portala Geri Dön">
          <i class="fa-solid fa-arrow-left"></i>
          <span class="d-none d-sm-inline">Portala Dön</span>
        </a>
        <a href="home.html" class="d-flex align-items-center">
          <img src="assets/images/logo.png" alt="Ufka Yolculuk" class="reader-brand-logo">
        </a>
      </div>

      <!-- Orta: Aktif Kitap Başlığı ve Kitap Değiştirici -->
      <div class="reader-book-selector-wrap">
        <span class="reader-book-badge d-none d-md-inline-block" id="currentBookBadge">Ortaokul Düzeyi</span>
        <div class="dropdown">
          <button class="reader-book-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="currentBookTitle">
            Tevhid Muhafızları
          </button>
          <ul class="dropdown-menu reader-book-menu shadow-lg">
            <li><h6 class="dropdown-header text-uppercase fs-7 fw-bold">Yarışma Kitapları</h6></li>
            <li>
              <a class="dropdown-item" href="javascript:void(0)" data-switch-book="kuslarin-cagrisi">
                <img src="assets/images/books/book-kuslarin-cagrisi.svg" class="book-thumb-mini" alt="Kuşların Çağrısı">
                <div>
                  <div class="fw-bold">Kuşların Çağrısı</div>
                  <small class="text-muted">İlkokul Düzeyi</small>
                </div>
              </a>
            </li>
            <li>
              <a class="dropdown-item active" href="javascript:void(0)" data-switch-book="tevhid-muhafizlari">
                <img src="assets/images/books/book-tevhid-muhafizlari.svg" class="book-thumb-mini" alt="Tevhid Muhafızları">
                <div>
                  <div class="fw-bold">Tevhid Muhafızları</div>
                  <small class="text-muted">Ortaokul Düzeyi</small>
                </div>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0)" data-switch-book="gordugume-gormedigime">
                <img src="assets/images/books/book-gordugume-gormedigime.svg" class="book-thumb-mini" alt="Gördüğüme Görmediğime">
                <div>
                  <div class="fw-bold">Gördüğüme Görmediğime</div>
                  <small class="text-muted">Lise Düzeyi</small>
                </div>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0)" data-switch-book="nasil-inanmali">
                <img src="assets/images/books/book-nasil-inanmali.svg" class="book-thumb-mini" alt="Nasıl İnanmalı?">
                <div>
                  <div class="fw-bold">Nasıl İnanmalı?</div>
                  <small class="text-muted">Yetişkin Düzeyi</small>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Sağ: Araçlar (İçindekiler, Görsel/Metin Modu, Tema, Galeri, Tam Ekran) -->
      <div class="reader-header-actions">
        
        <!-- İçindekiler Çekmecesi Butonu -->
        <button type="button" class="reader-action-btn" id="btnOpenToc" title="İçindekiler / Bölümler">
          <i class="fa-solid fa-list-ul"></i>
          <span class="d-none d-lg-inline">Bölümler</span>
        </button>

        <!-- Görsel / Metin Modu Geçiş Butonu -->
        <button type="button" class="reader-action-btn" id="btnToggleViewMode" title="Görsel / Metin Modu Değiştir (Kısayol: T)">
          <i class="fa-solid fa-align-left"></i>
          <span class="d-none d-lg-inline">Metin Modu</span>
        </button>

        <!-- Tema Seçici Açılır Menü -->
        <div class="dropdown">
          <button type="button" class="reader-action-btn reader-icon-btn-only" data-bs-toggle="dropdown" title="Okuma Teması">
            <i class="fa-solid fa-circle-half-stroke"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end p-2 shadow" style="min-width: 150px; border-radius: 12px;">
            <button class="theme-option-btn" data-theme-select="light">
              <span class="theme-dot light"></span> Aydınlık
            </button>
            <button class="theme-option-btn" data-theme-select="sepia">
              <span class="theme-dot sepia"></span> Sepya
            </button>
            <button class="theme-option-btn" data-theme-select="dark">
              <span class="theme-dot dark"></span> Gece
            </button>
          </div>
        </div>

        <!-- Sayfa Galerisi (Thumbnails) -->
        <button type="button" class="reader-action-btn reader-icon-btn-only" data-bs-toggle="modal" data-bs-target="#modalThumbnails" title="Tüm Sayfalar Galerisi">
          <i class="fa-solid fa-table-cells-large"></i>
        </button>

        <!-- Büyüt / Yakınlaştır (Zoom) -->
        <button type="button" class="reader-action-btn reader-icon-btn-only d-none d-md-inline-flex" id="btnZoom" title="Yakınlaştır / Uzaklaştır">
          <i class="fa-solid fa-magnifying-glass-plus"></i>
        </button>

        <!-- Tam Ekran -->
        <button type="button" class="reader-action-btn reader-icon-btn-only d-none d-sm-inline-flex" id="btnFullscreen" title="Tam Ekran (Kısayol: F)">
          <i class="fa-solid fa-expand"></i>
        </button>

        <!-- Dashboard / İstatistikler Butonu -->
        <a href="dashboard.html" class="reader-action-btn reader-icon-btn-only text-decoration-none" title="Dashboard / İstatistiklerim">
          <i class="fa-solid fa-chart-pie text-primary"></i>
        </a>
      </div>

    </div>
  </header>

  <!-- =========================================================================
       Ana Kitap Okuma Sahnesi (Dual-Page Spread)
       ========================================================================= -->
  <main class="reader-main-stage">
    
    <div class="book-spread-container">
      
      <!-- Sol Sayfayı Çevirme Yan Oku -->
      <button type="button" class="edge-turn-btn prev-edge" id="edgePrevBtn" title="Önceki Sayfa [←]">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <!-- Çift Sayfa Kitap Gövdesi (Left & Right Pages) -->
      <div class="book-spread" id="bookSpread">
        
        <!-- SOL SAYFA (1. Sayfa / Sol Yuva) -->
        <div class="page-frame left-page" id="leftPageFrame">
          
          <!-- Sol Sayfa Üst Bilgisi -->
          <div class="page-header-bar">
            <span class="book-name" id="currentBookAuthor">Ufka Yolculuk</span>
            <span class="chapter-info" id="leftPageChapter">Bölüm 1</span>
          </div>

          <!-- Sol Sayfa İçerik Alanı -->
          <div class="page-content-body">
            <!-- Görsel Tarama -->
            <img src="https://ufkayolculuk.com/uploads/2025-09/pdf_page_11_5.jpg" alt="Sol Sayfa" class="page-scan-img" id="leftPageScan">
            <!-- Metin Modu İçeriği -->
            <div class="page-text-container d-none" id="leftPageText"></div>
          </div>

          <!-- Sol Sayfa Numarası -->
          <div class="page-footer-bar">
            <span class="page-number-pill" id="leftPageNumber">5</span>
          </div>
        </div>

        <!-- SAĞ SAYFA (6. Sayfa / Sağ Yuva) -->
        <div class="page-frame right-page" id="rightPageFrame">
          
          <!-- Sağ Sayfa Üst Bilgisi -->
          <div class="page-header-bar">
            <span class="chapter-info" id="rightPageChapter">1. Bölüm - Boş Damacana</span>
            <span class="book-name" id="rightPageBookTitle">Tevhid Muhafızları</span>
          </div>

          <!-- Sağ Sayfa İçerik Alanı -->
          <div class="page-content-body">
            <!-- Görsel Tarama -->
            <img src="https://ufkayolculuk.com/uploads/2025-09/pdf_page_11_6.jpg" alt="Sağ Sayfa" class="page-scan-img" id="rightPageScan">
            <!-- Metin Modu İçeriği -->
            <div class="page-text-container d-none" id="rightPageText"></div>
          </div>

          <!-- Sağ Sayfa Numarası -->
          <div class="page-footer-bar">
            <span class="page-number-pill" id="rightPageNumber">6</span>
          </div>
        </div>

      </div>

      <!-- Sağ Sayfayı Çevirme Yan Oku -->
      <button type="button" class="edge-turn-btn next-edge" id="edgeNextBtn" title="Sonraki Sayfa [→]">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

    </div>

  </main>

  <!-- =========================================================================
       Sabit Alt Kontrol Paneli & Senkronize Ses Oynatıcı (Dock)
       ========================================================================= -->
  <aside class="reader-bottom-dock" id="readerBottomDock">
    
    <!-- 1. Satır: Sayfa Navigasyonu, Slider ve Hızlı Giriş -->
    <div class="dock-nav-row">
      
      <!-- Önceki Sayfa Butonu -->
      <button type="button" class="dock-nav-btn" id="btnPrev" title="Önceki Sayfaya Geç [←]">
        <i class="fa-solid fa-chevron-left"></i>
        <span>Önceki</span>
        <span class="kbd-hint">←</span>
      </button>

      <!-- İnteraktif Sayfa Slider'ı -->
      <div class="dock-slider-wrap">
        <div class="dock-slider-track" id="dockSliderTrack">
          <div class="dock-slider-fill" id="dockSliderFill"></div>
          <div class="dock-slider-thumb" id="dockSliderThumb"></div>
        </div>
      </div>

      <!-- Canlı Sayfa Göstergesi -->
      <div class="dock-page-display" id="dockPageDisplay">
        <span class="cur-badge">Sayfa 5 - 6</span> / <span>186</span>
      </div>

      <!-- Hızlı Sayfaya Git Inputu -->
      <div class="dock-quick-jump d-none d-sm-flex">
        <span class="text-white-50 fs-7 fw-semibold">Git:</span>
        <input type="number" id="quickJumpInput" min="5" max="186" value="5" title="Sayfa numarası yazıp Enter'a basın">
      </div>

      <!-- Sonraki Sayfa Butonu -->
      <button type="button" class="dock-nav-btn" id="btnNext" title="Sonraki Sayfaya Geç [→]">
        <span>Sonraki</span>
        <i class="fa-solid fa-chevron-right"></i>
        <span class="kbd-hint">→</span>
      </button>

    </div>

    <!-- 2. Satır: Senkronize Ses Oynatıcı Kontrolleri -->
    <div class="dock-audio-row">
      
      <!-- Sol: Aktif Ses Bilgisi ve Kapak -->
      <div class="dock-audio-left">
        <img src="assets/images/books/book-tevhid-muhafizlari.svg" alt="Kapak" class="dock-audio-cover" id="dockAudioCover">
        <div class="dock-audio-meta">
          <span class="audio-title" id="dockAudioTitle">Tevhid Muhafızları - S. 5</span>
          <span class="audio-status">Sesli Okuma Senkronize</span>
        </div>
      </div>

      <!-- Orta: Ses Oynatma & Sarma Düğmeleri ve İlerleme Çubuğu -->
      <div class="dock-audio-center">
        
        <!-- 10sn Geri -->
        <button type="button" class="dock-ctrl-btn" id="btnRewind10" title="10 Saniye Geri Sar">
          <i class="fa-solid fa-rotate-left"></i>
        </button>

        <!-- Büyük Oynat / Duraklat Butonu -->
        <button type="button" class="dock-play-master-btn" id="btnPlayMaster" title="Kitabı Sesli Dinle / Duraklat (Kısayol: Boşluk)">
          <i class="fa-solid fa-play"></i>
        </button>

        <!-- 10sn İleri -->
        <button type="button" class="dock-ctrl-btn" id="btnForward10" title="10 Saniye İleri Sar">
          <i class="fa-solid fa-rotate-right"></i>
        </button>

        <!-- Ses İlerleme ve Süre Çubuğu -->
        <div class="dock-waveform-container">
          <div class="dock-audio-progress-bar" id="dockAudioProgressBar" title="Süreye Atla">
            <div class="dock-audio-progress-fill" id="dockAudioProgressFill"></div>
          </div>
          <div class="dock-time-row">
            <span id="dockAudioCurrentTime">00:00</span>
            <span id="dockAudioDuration">34:20</span>
          </div>
        </div>

      </div>

      <!-- Sağ: Çalma Hızı ve Otomatik Sayfa Çevirme Switch'i -->
      <div class="dock-audio-right">
        
        <!-- Hız Değiştirici -->
        <button type="button" class="dock-speed-btn" id="dockSpeedBtn" title="Oynatma Hızı">1.0x</button>

        <!-- Sesle Otomatik Çevir Switch'i -->
        <label class="dock-auto-toggle-wrap d-none d-md-flex" title="Ses ilerledikçe sayfaları otomatik çevir">
          <input type="checkbox" id="autoTurnCheckbox" checked>
          <span>Oto Çevir</span>
        </label>

      </div>

    </div>

  </aside>

  <!-- =========================================================================
       İçindekiler Çekmecesi (Table of Contents Drawer)
       ========================================================================= -->
  <div class="reader-drawer-overlay" id="drawerOverlay"></div>
  <aside class="reader-drawer" id="drawerToc">
    <div class="drawer-header">
      <h5><i class="fa-solid fa-book-open text-primary me-2"></i> İçindekiler & Bölümler</h5>
      <button type="button" class="drawer-close-btn" id="btnCloseDrawer" title="Kapat">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="drawer-content-list" id="drawerChaptersList">
      <!-- JavaScript tarafından dinamik oluşturulur -->
    </div>
  </aside>

  <!-- =========================================================================
       Sayfa Galerisi Modalı (Thumbnails Grid Modal)
       ========================================================================= -->
  <div class="modal fade" id="modalThumbnails" tabindex="-1" aria-labelledby="modalThumbnailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header border-bottom py-3">
          <h5 class="modal-title fw-bold" id="modalThumbnailsLabel">
            <i class="fa-solid fa-table-cells-large text-primary me-2"></i> Tüm Sayfalar Galerisi
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body p-4 bg-light">
          <div class="thumbnail-grid-modal" id="thumbnailsGrid">
            <!-- JavaScript tarafından dinamik oluşturulur -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5.3 JS (Yerel) -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Okuyucu Motoru (reader.js) -->
  <script src="assets/js/reader.js?v=3.5"></script>
</body>
</html>
