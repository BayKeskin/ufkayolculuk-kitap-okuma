<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
  <link rel="stylesheet" href="<?= base_url('assets/css/kitaplar.css?v=3.5') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <main class="py-4">
    <div class="container-portal">

      <!-- 1. Hero Başlık ve İstatistik Şeridi -->
      <section class="books-hero-banner">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <h1 class="books-hero-title">Yarışma Kitapları & Geçmiş Yıllar Arşivi</h1>
            <p class="books-hero-subtitle">
              Ufka Yolculuk 13. yıl güncel yarışma kitapları ve 2013-2024 yılları arasında milyonlarca okura ulaşan
              geçmiş tüm yarışma eserleri. İstediğiniz kitabı seçerek anında okumaya veya dinlemeye başlayın.
            </p>

            <!-- 4'lü Hızlı Sayaç Şeridi -->
            <div class="books-stats-strip">

              <div class="books-stat-box">
                <div class="books-stat-icon">
                  <i class="fa-solid fa-star text-warning"></i>
                </div>
                <div class="books-stat-info">
                  <span class="books-stat-num"><?= !empty($books) ? count($books) : 4 ?> Kitap</span>
                  <span class="books-stat-label">2025 Güncel Yarışma</span>
                </div>
              </div>

              <div class="books-stat-box">
                <div class="books-stat-icon">
                  <i class="fa-solid fa-box-archive text-info"></i>
                </div>
                <div class="books-stat-info">
                  <span class="books-stat-num">20+ Kitap</span>
                  <span class="books-stat-label">Geçmiş Yıllar Arşivi</span>
                </div>
              </div>

              <div class="books-stat-box">
                <div class="books-stat-icon">
                  <i class="fa-solid fa-graduation-cap text-success"></i>
                </div>
                <div class="books-stat-info">
                  <span class="books-stat-num">4 Düzey</span>
                  <span class="books-stat-label">İlkokul, Orta, Lise, Yetişkin</span>
                </div>
              </div>

              <div class="books-stat-box">
                <div class="books-stat-icon">
                  <i class="fa-solid fa-headphones text-primary"></i>
                </div>
                <div class="books-stat-info">
                  <span class="books-stat-num">100+ Saat</span>
                  <span class="books-stat-label">Senkronize Seslendirme</span>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

      <!-- 2. Filtreleme & Arama Kontrol Çubuğu (Toolbar) -->
      <section class="books-toolbar-card">
        <div class="row g-3 align-items-center">

          <!-- Arama Kutusu -->
          <div class="col-lg-4">
            <div class="books-search-input-wrap">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" class="books-search-input" id="booksSearchInput"
                placeholder="Kitap adı, yazar veya konu ara...">
              <button type="button" class="btn-clear-search" id="btnClearSearch" title="Temizle">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
          </div>

          <!-- Kategori Filtresi Hapları -->
          <div class="col-lg-8">
            <div
              class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">

              <!-- Kategori Hapları -->
              <div class="filter-pills-row">
                <button type="button" class="filter-pill-btn cat-filter-pill active" data-cat="all">Tüm
                  Düzeyler</button>
                <button type="button" class="filter-pill-btn cat-filter-pill" data-cat="ilkokul">İlkokul</button>
                <button type="button" class="filter-pill-btn cat-filter-pill" data-cat="ortaokul">Ortaokul</button>
                <button type="button" class="filter-pill-btn cat-filter-pill" data-cat="lise">Lise</button>
                <button type="button" class="filter-pill-btn cat-filter-pill" data-cat="yetiskin">Yetişkin</button>
              </div>

            </div>
          </div>

        </div>

        <!-- Toolbar 2. Satır: Yıl Filtreleri & Görünüm Seçici -->
        <div class="books-toolbar-footer">

          <!-- Yıl Hapları -->
          <div class="filter-pills-row">
            <span class="fs-8 fw-bold text-muted me-1"><i class="fa-solid fa-calendar me-1"></i>Yıl:</span>
            <button type="button" class="filter-pill-btn year-filter-pill active" data-year="all">Tümü</button>
            <button type="button" class="filter-pill-btn year-filter-pill year-pill" data-year="2025">✨ 2025
              (Güncel)</button>
            <button type="button" class="filter-pill-btn year-filter-pill" data-year="archive">📁 Tüm Arşiv</button>
            <button type="button" class="filter-pill-btn year-filter-pill" data-year="2024">2024</button>
            <button type="button" class="filter-pill-btn year-filter-pill" data-year="2023">2023</button>
            <button type="button" class="filter-pill-btn year-filter-pill" data-year="2022">2022</button>
            <button type="button" class="filter-pill-btn year-filter-pill" data-year="2021">2021</button>
            <button type="button" class="filter-pill-btn year-filter-pill" data-year="2020">2020</button>
          </div>

          <!-- Sağ: Sayaç & Görünüm Değiştirici -->
          <div class="d-flex align-items-center gap-3">
            <div class="books-results-count">
              <span id="resultsCountNum">20</span> Kitap Listeleniyor
            </div>

            <div class="view-mode-toggle-group">
              <button type="button" class="view-mode-btn active" id="btnViewGrid" title="Izgara Görünümü">
                <i class="fa-solid fa-table-cells-large"></i>
              </button>
              <button type="button" class="view-mode-btn" id="btnViewList" title="Liste Görünümü">
                <i class="fa-solid fa-list"></i>
              </button>
            </div>
          </div>

        </div>
      </section>

      <!-- 3. Kitaplar Grid / Liste Galerisi -->
      <section>

        <!-- Grid Konteyneri (Canlı API Verileriyle Dinamik Önizleme) -->
        <div class="books-grid-container" id="booksGridContainer">
          <?php if (!empty($books)): ?>
            <?php foreach ($books as $b): 
              $bCat = $b['category_slug'] ?? 'ortaokul';
              $bStartPage = (int)($b['start_page'] ?? 1);
              $bTotalPages = (int)($b['total_pages'] ?? 180);
              $bReaderUrl = base_url('kitap-oku?book=' . urlencode($b['id']) . '&page=' . $bStartPage);
              $bAudioReaderUrl = $bReaderUrl . '&audio=1';
              $bAuthor = !empty($b['author']) ? $b['author'] : 'Ufka Yolculuk Yayınları';
              $bLevelBadge = $b['level'] ?? 'Tüm Düzeyler';
              $bHasAudio = !empty($b['sound_file']);
            ?>
            <div class="book-card-3d" data-book-id="<?= esc($b['id']) ?>">
              <div class="book-card-cover-stage">
                <span class="book-badge-year current">2025 • Güncel</span>
                <?php if ($bHasAudio): ?>
                  <a href="<?= $bAudioReaderUrl ?>" class="book-badge-audio text-decoration-none" title="Sesli Dinleme Mevcut (Tıkla ve Dinle)">
                    <i class="fa-solid fa-headphones me-1"></i>Sesli
                  </a>
                <?php endif; ?>
                <img src="<?= esc($b['cover_image']) ?>" alt="<?= esc($b['name']) ?>" loading="lazy" onerror="this.src='assets/images/books/book-kuslarin-cagrisi.svg'">
              </div>

              <div class="book-card-info">
                <span class="book-level-pill <?= esc($bCat) ?>"><?= esc($bLevelBadge) ?></span>
                <h3 class="book-card-title"><?= esc($b['name']) ?></h3>
                <div class="book-card-author"><?= esc($bAuthor) ?></div>
                <div class="book-card-meta-row">
                  <span><i class="fa-solid fa-book-open me-1"></i><?= $bTotalPages ?> Sayfa</span>
                  <?php if ($bHasAudio): ?>
                    <span><i class="fa-regular fa-clock me-1"></i>3+ saat</span>
                  <?php endif; ?>
                </div>
              </div>

              <div class="book-card-buttons">
                <a href="<?= $bReaderUrl ?>" class="btn-book-read-primary" title="Kitabı Oku">
                  <i class="fa-solid fa-book-open"></i> <span>Kitabı Oku</span>
                </a>
                <?php if ($bHasAudio): ?>
                  <a href="<?= $bAudioReaderUrl ?>" class="btn-book-audio-circle" title="Sesli Dinle">
                    <i class="fa-solid fa-headphones"></i>
                  </a>
                <?php endif; ?>
                <button type="button" class="btn-book-detail-circle btn-open-detail" data-id="<?= esc($b['id']) ?>" title="Özet ve Detaylar">
                  <i class="fa-solid fa-circle-info"></i>
                </button>
              </div>
            </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Liste Konteyneri -->
        <div class="books-list-container" id="booksListContainer" style="display: none;">
          <!-- JS dinamik dolduracak -->
        </div>

        <!-- Boş Arama Sonucu -->
        <div class="books-empty-state" id="booksEmptyState">
          <div class="empty-state-icon">
            <i class="fa-solid fa-book-open"></i>
          </div>
          <h3 class="fw-bold fs-5 text-dark mb-2">Aradığınız kriterlere uygun kitap bulunamadı</h3>
          <p class="text-muted fs-7 mb-3">Farklı bir arama terimi deneyebilir veya filtreleri sıfırlayabilirsiniz.</p>
          <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-bold fs-7"
            onclick="location.href='kitaplar.html'">
            Filtreleri Sıfırla
          </button>
        </div>

      </section>

    </div>
  </main>
<?= $this->endSection() ?>

<?= $this->section('modals') ?>
  <!-- =========================================================================
       Modal: Kitap Detay & Önizleme Penceresi
       ========================================================================= -->
  <div class="modal fade" id="modalBookDetail" tabindex="-1" aria-labelledby="modalDetailTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
        <div class="modal-header border-0 pb-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center">
              <div class="modal-cover-stage p-2 bg-light rounded-4 shadow-sm d-flex align-items-center justify-content-center mx-auto" style="width: 170px; height: 235px;">
                <img id="modalDetailImg" src="" alt="Kitap Kapağı"
                  style="width: 155px; height: 220px; object-fit: contain; border-radius: 8px; display: block;"
                  onerror="this.src='assets/images/books/book-kuslarin-cagrisi.svg'">
              </div>
            </div>
            <div class="col-md-8">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill" id="modalDetailLevel">Düzey</span>
                <span class="badge bg-light text-dark fw-bold" id="modalDetailYear">2025</span>
              </div>
              <h3 class="fw-bold text-dark mb-2" id="modalDetailTitle">Kitap Başlığı</h3>
              <p class="text-muted fs-7 mb-3" id="modalDetailSummary">Kitap özeti burada yer alır.</p>

              <div class="d-flex align-items-center gap-3 text-muted fs-8 fw-semibold mb-4">
                <span><i class="fa-solid fa-book-open me-1 text-primary"></i><span
                    id="modalDetailPages">185</span></span>
                <span><i class="fa-regular fa-clock me-1 text-warning"></i><span id="modalDetailAudio">3
                    saat</span></span>
                <span><i class="fa-solid fa-shield-halved me-1 text-success"></i>Resmi Yarışma Kitabı</span>
              </div>

              <div class="d-flex align-items-center gap-3">
                <a href="" id="modalDetailBtnRead" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">
                  <i class="fa-solid fa-book-open me-2"></i> Kitabı Oku & Dinle
                </a>
                <button type="button" class="btn btn-light px-3 py-2 fw-bold rounded-pill" data-bs-dismiss="modal">
                  Kapat
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script>
    window.DYNAMIC_BOOKS = <?= json_encode($books ?? [], JSON_UNESCAPED_UNICODE) ?>;
  </script>
  <script src="<?= base_url('assets/js/kitaplar.js?v=4.0') ?>"></script>
<?= $this->endSection() ?>