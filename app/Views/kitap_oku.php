<?php
$bId = (int)($activeBook['id'] ?? 11);
$bTitle = $activeBook['name'] ?? $activeBook['title'] ?? 'Kitap Oku';
$bAuthor = !empty($activeBook['author']) ? $activeBook['author'] : 'Ufka Yolculuk Yayınları';
$bLevel = $activeBook['level'] ?? 'Tüm Düzeyler';
$bTotalPages = (int)($activeBook['total_pages'] ?? 185);
$bMinPage = (int)($activeBook['start_page'] ?? 1);
$bStartPage = $bMinPage;
$bCurPage = (int)($startPage ?? $bMinPage);
if ($bCurPage < 1) $bCurPage = $bMinPage;
if ($bCurPage > $bTotalPages && $bTotalPages > 0) $bCurPage = $bTotalPages;

$bCoverImg = !empty($activeBook['cover_image']) ? $activeBook['cover_image'] : (!empty($activeBook['image']) ? $activeBook['image'] : base_url('assets/images/books/book-tevhid-muhafizlari.svg'));
$bSoundFile = !empty($activeBook['sound_file']) ? $activeBook['sound_file'] : '';

// İlk Çift Sayfa Hesaplaması
$leftPageNum = $bCurPage;
$rightPageNum = ($leftPageNum + 1 <= $bTotalPages) ? ($leftPageNum + 1) : null;

// $activeBook['pages'] içerisinden ilk sayfaları eşle
$leftPageData = null;
$rightPageData = null;
if (!empty($activeBook['pages']) && is_array($activeBook['pages'])) {
    foreach ($activeBook['pages'] as $p) {
        $pNo = (int)($p['page_no'] ?? 0);
        if ($pNo === $leftPageNum) {
            $leftPageData = $p;
        }
        if ($rightPageNum !== null && $pNo === $rightPageNum) {
            $rightPageData = $p;
        }
    }
}

$leftScanUrl = $leftPageData['image'] ?? $bCoverImg;
$rightScanUrl = $rightPageData ? ($rightPageData['image'] ?? $bCoverImg) : '';
$leftBody = $leftPageData['body_html'] ?? $leftPageData['body'] ?? '';
$rightBody = $rightPageData ? ($rightPageData['body_html'] ?? $rightPageData['body'] ?? '') : '';
?>
<!DOCTYPE html>
<html lang="tr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($bTitle) ?> - Kitap Oku ve Sesli Dinle | Ufka Yolculuk</title>
  <meta name="description" content="Ufka Yolculuk <?= esc($bTitle) ?> interaktif çift sayfalı kitap okuma ve senkronize sesli dinleme deneyimi.">

  <!-- Google Fonts: Plus Jakarta Sans & Merriweather -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS (Yerel) -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">

  <!-- Font Awesome 6 (Yerel) -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">

  <!-- Okuyucu Özel CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/reader.css?v=4.1') ?>">
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
        <a href="<?= base_url('/') ?>" class="reader-btn-back" title="Portala Geri Dön">
          <i class="fa-solid fa-arrow-left"></i>
          <span class="d-none d-sm-inline">Portala Dön</span>
        </a>
        <a href="<?= base_url('/') ?>" class="d-flex align-items-center">
          <img src="assets/images/logo.png" alt="Ufka Yolculuk" class="reader-brand-logo">
        </a>
      </div>

      <!-- Orta: Aktif Kitap Başlığı ve Kitap Değiştirici -->
      <div class="reader-book-selector-wrap">
        <span class="reader-book-badge d-none d-md-inline-block" id="currentBookBadge"><?= esc($bLevel) ?></span>
        <div class="dropdown">
          <button class="reader-book-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="currentBookTitle">
            <?= esc($bTitle) ?>
          </button>
          <ul class="dropdown-menu reader-book-menu shadow-lg">
            <li><h6 class="dropdown-header text-uppercase fs-7 fw-bold">Yarışma Kitapları</h6></li>
            <?php if (!empty($allBooks) && is_array($allBooks)): ?>
              <?php foreach ($allBooks as $bk): ?>
                <?php 
                  $bkId = (int)$bk['id'];
                  $isActive = ($bkId === $bId);
                  $bkCover = !empty($bk['cover_image']) ? $bk['cover_image'] : ($bk['image'] ?? 'assets/images/books/book-kuslarin-cagrisi.svg');
                  $bkLevel = $bk['level'] ?? 'Tüm Düzeyler';
                  $bkStartPage = (int)($bk['start_page'] ?? 1);
                ?>
                <li>
                  <a class="dropdown-item <?= $isActive ? 'active' : '' ?>" href="<?= base_url('kitap-oku?book_id=' . $bkId . '&start_page=' . $bkStartPage) ?>" data-switch-book="<?= $bkId ?>">
                    <img src="<?= esc($bkCover) ?>" class="book-thumb-mini" alt="<?= esc($bk['name']) ?>" onerror="this.src='<?= base_url('assets/images/books/book-kuslarin-cagrisi.svg') ?>'">
                    <div>
                      <div class="fw-bold"><?= esc($bk['name']) ?></div>
                      <small class="text-muted"><?= esc($bkLevel) ?></small>
                    </div>
                  </a>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>
                <a class="dropdown-item active" href="<?= base_url('kitap-oku?book_id=11&start_page=5') ?>" data-switch-book="11">
                  <img src="<?= base_url('assets/images/books/book-tevhid-muhafizlari.svg') ?>" class="book-thumb-mini" alt="Tevhid Muhafızları">
                  <div>
                    <div class="fw-bold">Tevhid Muhafızları</div>
                    <small class="text-muted">Ortaokul Düzeyi</small>
                  </div>
                </a>
              </li>
            <?php endif; ?>
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
        <a href="<?= base_url('dashboard') ?>" class="reader-action-btn reader-icon-btn-only text-decoration-none" title="Dashboard / İstatistiklerim">
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
        
        <!-- SOL SAYFA (Sol Yuva) -->
        <div class="page-frame left-page" id="leftPageFrame">
          
          <!-- Sol Sayfa Üst Bilgisi -->
          <div class="page-header-bar">
            <span class="book-name" id="currentBookAuthor"><?= esc($bAuthor) ?></span>
            <span class="chapter-info" id="leftPageChapter">Sayfa <?= $leftPageNum ?></span>
          </div>

          <!-- Sol Sayfa İçerik Alanı -->
          <div class="page-content-body">
            <!-- Görsel Tarama -->
            <img src="<?= esc($leftScanUrl) ?>" alt="Sol Sayfa" class="page-scan-img" id="leftPageScan" onerror="this.src='<?= esc($bCoverImg) ?>'">
            <!-- Metin Modu İçeriği -->
            <div class="page-text-container d-none" id="leftPageText"><?= $leftBody ?: '<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>' ?></div>
          </div>

          <!-- Sol Sayfa Numarası -->
          <div class="page-footer-bar">
            <span class="page-number-pill" id="leftPageNumber"><?= $leftPageNum ?></span>
          </div>
        </div>

        <!-- SAĞ SAYFA (Sağ Yuva) -->
        <div class="page-frame right-page" id="rightPageFrame" style="<?= $rightPageNum === null ? 'opacity: 0.4;' : '' ?>">
          
          <!-- Sağ Sayfa Üst Bilgisi -->
          <div class="page-header-bar">
            <span class="chapter-info" id="rightPageChapter"><?= $rightPageNum !== null ? 'Sayfa ' . $rightPageNum : '' ?></span>
            <span class="book-name" id="rightPageBookTitle"><?= esc($bTitle) ?></span>
          </div>

          <!-- Sağ Sayfa İçerik Alanı -->
          <div class="page-content-body">
            <!-- Görsel Tarama -->
            <img src="<?= esc($rightScanUrl) ?>" alt="Sağ Sayfa" class="page-scan-img" id="rightPageScan" style="<?= $rightPageNum === null ? 'display:none;' : '' ?>">
            <!-- Metin Modu İçeriği -->
            <div class="page-text-container d-none" id="rightPageText"><?= $rightBody ?: ($rightPageNum !== null ? '<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>' : '<div class="p-5 text-center text-muted"><em>Kitap Sonu</em></div>') ?></div>
          </div>

          <!-- Sağ Sayfa Numarası -->
          <div class="page-footer-bar">
            <span class="page-number-pill" id="rightPageNumber"><?= $rightPageNum !== null ? $rightPageNum : '' ?></span>
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
        <span class="cur-badge">Sayfa <?= $leftPageNum ?><?= $rightPageNum ? ' - ' . $rightPageNum : '' ?></span> / <span><?= $bTotalPages ?></span>
      </div>

      <!-- Hızlı Sayfaya Git Inputu -->
      <div class="dock-quick-jump d-none d-sm-flex">
        <span class="text-white-50 fs-7 fw-semibold">Git:</span>
        <input type="number" id="quickJumpInput" min="<?= $bMinPage ?>" max="<?= $bTotalPages ?>" value="<?= $leftPageNum ?>" title="Sayfa numarası yazıp Enter'a basın">
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
        <img src="<?= esc($bCoverImg) ?>" alt="Kapak" class="dock-audio-cover" id="dockAudioCover" onerror="this.src='assets/images/books/book-tevhid-muhafizlari.svg'">
        <div class="dock-audio-meta">
          <span class="audio-title" id="dockAudioTitle"><?= esc($bTitle) ?> - S. <?= $leftPageNum ?></span>
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
            <span id="dockAudioDuration">--:--</span>
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

  <!-- =========================================================================
       Kaldığınız Yerden Devam Edin Modalı (Resume Progress Modal)
       ========================================================================= -->
  <div class="modal fade" id="modalResumeProgress" tabindex="-1" aria-labelledby="modalResumeLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content resume-modal-content rounded-4 border-0 shadow-lg overflow-hidden">
        <div class="resume-modal-banner p-4 text-white text-center position-relative">
          <div class="resume-icon-circle mx-auto mb-3 shadow">
            <i class="fa-solid fa-bookmark"></i>
          </div>
          <h4 class="modal-title fw-bold" id="modalResumeLabel">Kaldığınız Yerden Devam Edin</h4>
          <p class="mb-0 text-white-50 fs-6" id="resumeBookTitle"><?= esc($bTitle) ?></p>
        </div>
        <div class="modal-body p-4 bg-white">
          <div class="resume-info-card p-3 rounded-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
              <div class="resume-stat-icon text-primary bg-primary-subtle rounded-circle p-3">
                <i class="fa-solid fa-book-open fa-lg"></i>
              </div>
              <div>
                <span class="text-muted d-block small">Kayıtlı Sayfa</span>
                <strong class="fs-5 text-dark" id="resumePageNumber">Sayfa <?= (int)($userProgress['last_page'] ?? $userProgress['page'] ?? 1) ?></strong>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="resume-stat-icon text-info bg-info-subtle rounded-circle p-3">
                <i class="fa-solid fa-clock fa-lg"></i>
              </div>
              <div>
                <span class="text-muted d-block small">Ses Konumu</span>
                <strong class="fs-5 text-dark" id="resumeAudioTime">00:00</strong>
              </div>
            </div>
          </div>
          <div class="progress mb-2" style="height: 8px; border-radius: 4px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="resumeProgressBar" role="progressbar" style="width: 0%"></div>
          </div>
          <div class="d-flex justify-content-between text-muted small mb-4">
            <span>Tamamlanma Oranı</span>
            <span class="fw-bold text-primary" id="resumeProgressPercent">%0</span>
          </div>
          <div class="d-grid gap-2">
            <button type="button" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm" id="btnResumeContinue">
              <i class="fa-solid fa-play me-2"></i> Kaldığım Yerden Devam Et
            </button>
            <button type="button" class="btn btn-outline-secondary rounded-pill py-2" id="btnResumeRestart" data-bs-dismiss="modal">
              <i class="fa-solid fa-rotate-left me-2"></i> Baştan Başla
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================================================
       Kitap Tamamlama Tebrik Modalı (Book Completed Celebration Modal)
       ========================================================================= -->
  <div class="modal fade" id="modalBookCompleted" tabindex="-1" aria-labelledby="modalCompletedLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content completed-modal-content rounded-4 border-0 shadow-lg overflow-hidden text-center">
        <div class="completed-modal-banner p-4 text-white position-relative">
          <div class="completed-trophy-circle mx-auto mb-3 shadow">
            <i class="fa-solid fa-trophy"></i>
          </div>
          <h3 class="modal-title fw-bold" id="modalCompletedLabel">Tebrikler! 🎉</h3>
          <p class="mb-0 text-white-50">Kitabı Başarıyla Tamamladınız!</p>
        </div>
        <div class="modal-body p-4 bg-white">
          <p class="text-muted mb-4 fs-6">
            <strong><?= esc($bTitle) ?></strong> kitabının tüm sayfalarını başarıyla okudunuz. Şimdi online deneme sınavlarına girerek bilgilerinizi test edebilir ve kürsüde yerinizi alabilirsiniz!
          </p>
          <div class="d-grid gap-3">
            <a href="<?= base_url('deneme-sinavlari') ?>" class="btn btn-warning btn-lg rounded-pill py-3 fw-bold shadow text-dark">
              <i class="fa-solid fa-file-signature me-2"></i> Online Deneme Sınavına Gir
            </a>
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-outline-secondary flex-grow-1 rounded-pill" id="btnCompletedRestart">
                <i class="fa-solid fa-arrow-rotate-left me-1"></i> Başa Dön
              </button>
              <button type="button" class="btn btn-light flex-grow-1 rounded-pill" data-bs-dismiss="modal">
                Kapat
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Otomatik Kayıt Toast Bildirimi -->
  <div class="reader-autosave-toast shadow" id="readerAutosaveToast">
    <i class="fa-solid fa-cloud-arrow-up text-success me-2"></i>
    <span>İlerlemeniz kaydedildi</span>
  </div>

  <!-- Dinamik CodeIgniter Veri Köprüsü -->
  <script>
    window.BASE_URL = '<?= rtrim(base_url(), '/') . '/' ?>';
    window.ACTIVE_BOOK = <?= json_encode($activeBook, JSON_UNESCAPED_UNICODE) ?>;
    window.ALL_BOOKS_LIST = <?= json_encode($allBooks ?? [], JSON_UNESCAPED_UNICODE) ?>;
    window.START_PAGE = <?= (int)$bStartPage ?>;
    window.TARGET_PAGE = <?= (int)$bCurPage ?>;
    window.AUTO_AUDIO = <?= $autoAudio ? 'true' : 'false' ?>;
    window.USER_ID = <?= (int)($userId ?? 1001) ?>;
    window.USER_PROGRESS = <?= json_encode($userProgress ?? null, JSON_UNESCAPED_UNICODE) ?>;
  </script>

  <!-- Bootstrap 5.3 JS (Yerel) -->
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

  <!-- Okuyucu Motoru (reader.js) -->
  <script src="<?= base_url('assets/js/reader.js?v=4.3') ?>"></script>
</body>
</html>
