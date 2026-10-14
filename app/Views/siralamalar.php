<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
  <link rel="stylesheet" href="<?= base_url('assets/css/siralamalar.css?v=1.0') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="container py-4">

    <!-- Hero Banner -->
    <section class="leaderboard-hero-card">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="leaderboard-hero-pill">
            <i class="fa-solid fa-bolt text-warning"></i>
            <span>Ufka Yolculuk 13. Bilgi & Kültür Yarışması</span>
          </div>
          <h1 class="leaderboard-hero-title">
            Türkiye Geneli <span class="text-info">Liderlik & Başarı Sıralaması</span>
          </h1>
          <p class="leaderboard-hero-desc">
            Online deneme sınavları ve konu testlerinde dereceye giren yarışmacıların canlı puan tablosu. Kendini dene,
            sıralamada yüksel ve ödülleri yakala!
          </p>
        </div>

        <div class="col-lg-4">
          <div class="row g-2">
            <div class="col-6">
              <div class="leaderboard-stat-badge-box">
                <div class="fs-4 fw-extrabold text-warning">248.512</div>
                <div class="small opacity-80 fw-bold">Aktif Yarışmacı</div>
              </div>
            </div>
            <div class="col-6">
              <div class="leaderboard-stat-badge-box">
                <div class="fs-4 fw-extrabold text-info">81 İl</div>
                <div class="small opacity-80 fw-bold">Türkiye Geneli</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Kullanıcının Kendi Sıralaması Şeridi (Sticky / Highlight) -->
    <section class="user-rank-highlight-card">
      <div class="user-rank-info-group">
        <div class="user-rank-num-badge">
          #142
        </div>
        <div>
          <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-warning text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">Sizin
              Sıralamanız</span>
            <span class="text-white opacity-90 small">Ahmet Yılmaz • Üsküdar Çamlıca İHL</span>
          </div>
          <div class="fw-bold fs-6">
            İstanbul İl Geneli: <span class="text-warning">14. Sıradasınız</span> (İlk %1'lik Dilim)
          </div>
        </div>
      </div>

      <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="user-rank-stat-mini">
          <div class="user-rank-stat-col">
            <div class="small opacity-80" style="font-size: 0.72rem;">Hesaplanan Net</div>
            <div class="fw-extrabold fs-5">89.00 / 100</div>
          </div>
          <div class="user-rank-stat-col">
            <div class="small opacity-80" style="font-size: 0.72rem;">Başarı Yüzdesi</div>
            <div class="fw-extrabold fs-5 text-warning">%91.2</div>
          </div>
          <div class="user-rank-stat-col">
            <div class="small opacity-80" style="font-size: 0.72rem;">Toplam Puan</div>
            <div class="fw-extrabold fs-5">89.4</div>
          </div>
        </div>

        <a href="<?= base_url('sinav-ekrani?sinav=genel') ?>" class="btn btn-light btn-sm fw-bold px-3 py-2 rounded-pill shadow-sm">
          <i class="fa-solid fa-arrow-trend-up text-primary me-1"></i> Sıralamamı Yükselt
        </a>
      </div>
    </section>

    <!-- TOP 3 PODIUM (Kürsü) VİTRİNİ -->
    <section class="podium-container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h2 class="h5 fw-bold text-dark mb-0">🏆 Zirvedeki Şampiyonlar (Kürsü)</h2>
          <p class="text-muted small mb-0">Genel sıralamada ilk 3 dereceyi paylaşan yarışmacılar</p>
        </div>
        <span class="badge bg-warning-subtle text-warning fw-bold px-3 py-1.5 rounded-pill">
          Canlı Güncellendi
        </span>
      </div>

      <div class="podium-grid">

        <!-- 2. Sıra (Gümüş) -->
        <div class="podium-card rank-2">
          <div class="podium-avatar-wrap">
            <div class="podium-initials-badge silver">ÖF</div>
            <span class="podium-rank-badge silver">2</span>
          </div>
          <div class="podium-name">Ömer Faruk Çelik</div>
          <div class="podium-school">Pursaklar Fen Lisesi<br><span class="text-muted">Ankara / Pursaklar</span></div>
          <div class="mb-3">
            <span class="badge bg-warning-subtle text-warning fw-bold" style="font-size: 0.72rem;">Gördüğüme Görmediğime
              (Lise)</span>
          </div>
          <div class="podium-score-pill silver">
            <i class="fa-solid fa-medal"></i> 98.8 Puan
          </div>
        </div>

        <!-- 1. Sıra (Altın - Şampiyon) -->
        <div class="podium-card rank-1">
          <div class="podium-crown-icon">
            <i class="fa-solid fa-crown"></i>
          </div>
          <div class="podium-avatar-wrap">
            <div class="podium-initials-badge gold">ZS</div>
            <span class="podium-rank-badge gold">1</span>
          </div>
          <div class="podium-name fs-5">Zeynep Sare Aydın</div>
          <div class="podium-school fw-semibold">Kadıköy Anadolu İHL<br><span class="text-primary fw-bold">İstanbul /
              Kadıköy</span></div>
          <div class="mb-3">
            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 0.75rem;">Tevhid Muhafızları
              (Ortaokul)</span>
          </div>
          <div class="podium-score-pill gold">
            <i class="fa-solid fa-trophy"></i> 100.0 Tam Puan
          </div>
        </div>

        <!-- 3. Sıra (Bronz) -->
        <div class="podium-card rank-3">
          <div class="podium-avatar-wrap">
            <div class="podium-initials-badge bronze">EB</div>
            <span class="podium-rank-badge bronze">3</span>
          </div>
          <div class="podium-name">Elif Berra Yılmaz</div>
          <div class="podium-school">Meram Mehmet Akif Ersoy OO<br><span class="text-muted">Konya / Meram</span></div>
          <div class="mb-3">
            <span class="badge bg-purple-subtle text-purple fw-bold" style="font-size: 0.72rem;">Kuşların Çağrısı
              (İlkokul)</span>
          </div>
          <div class="podium-score-pill bronze">
            <i class="fa-solid fa-award"></i> 97.5 Puan
          </div>
        </div>

      </div>
    </section>

    <!-- FİLTRELEME & CANLI ARAMA KARTI -->
    <section class="leaderboard-filter-card">
      <div class="row g-3 align-items-center">
        <!-- Kategori Filtresi -->
        <div class="col-12 col-md-3">
          <label class="form-label small fw-bold text-dark mb-1">Yarışma Kategorisi</label>
          <select class="form-select form-select-sm rounded-pill fw-semibold" id="siraCategoryFilter">
            <option value="all">Tüm Kategoriler (Genel)</option>
            <option value="ilkokul">İlkokul (Kuşların Çağrısı)</option>
            <option value="ortaokul">Ortaokul (Tevhid Muhafızları)</option>
            <option value="lise">Lise (Gördüğüme Görmediğime)</option>
            <option value="yetiskin">Yetişkin (Nasıl İnanmalı?)</option>
          </select>
        </div>

        <!-- Zaman Dilimi Filtresi -->
        <div class="col-12 col-md-3">
          <label class="form-label small fw-bold text-dark mb-1">Zaman Dilimi</label>
          <select class="form-select form-select-sm rounded-pill fw-semibold" id="siraTimeFilter">
            <option value="all">Tüm Zamanlar (Genel)</option>
            <option value="month">Bu Ay Yapılan Sınavlar</option>
            <option value="week">Bu Haftaki Hızlı Testler</option>
          </select>
        </div>

        <!-- İl Seçimi -->
        <div class="col-12 col-md-3">
          <label class="form-label small fw-bold text-dark mb-1">İl / Bölge</label>
          <select class="form-select form-select-sm rounded-pill fw-semibold" id="siraCityFilter">
            <option value="all">Tüm Türkiye (81 İl)</option>
            <option value="İstanbul">İstanbul</option>
            <option value="Ankara">Ankara</option>
            <option value="İzmir">İzmir</option>
            <option value="Konya">Konya</option>
            <option value="Bursa">Bursa</option>
            <option value="Kayseri">Kayseri</option>
            <option value="Gaziantep">Gaziantep</option>
            <option value="Antalya">Antalya</option>
            <option value="Samsun">Samsun</option>
          </select>
        </div>

        <!-- Arama Kutusu -->
        <div class="col-12 col-md-3">
          <label class="form-label small fw-bold text-dark mb-1">Yarışmacı veya Okul Ara</label>
          <div class="sira-search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="sira-search-input" id="siraSearchInput" placeholder="İsim veya okul yazın...">
          </div>
        </div>
      </div>
    </section>

    <!-- DETAYLI SIRALAMA TABLOSU -->
    <section class="leaderboard-table-card">
      <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <i class="fa-solid fa-list-ol text-primary"></i>
          <h3 class="h6 fw-bold text-dark mb-0">Resmi Başarı Sıralaması Listesi</h3>
        </div>
        <span class="badge bg-primary-subtle text-primary fw-bold" id="totalParticipantsCount">
          11 Yarışmacı Listelendi
        </span>
      </div>

      <div class="table-responsive">
        <table class="table leaderboard-table align-middle">
          <thead>
            <tr>
              <th class="text-center" style="width: 70px;">Sıra</th>
              <th>Yarışmacı & Okul</th>
              <th>Kategori / Kitap</th>
              <th>İl / İlçe</th>
              <th class="text-center">Doğru / Yanlış</th>
              <th class="text-center">Net Puan</th>
              <th class="text-center">Toplam Skor</th>
              <th class="text-center">Başarı Rozeti</th>
            </tr>
          </thead>
          <tbody id="leaderboardTableBody">
            <!-- JS ile dinamik render edilir -->
          </tbody>
        </table>
      </div>

      <!-- Sayfalama (Pagination) -->
      <div
        class="p-3 bg-light border-top d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
        <div class="small text-muted">
          Toplam <strong>248.512</strong> yarışmacı arasından <strong>1 - 10</strong> arası gösteriliyor.
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">250</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
          </ul>
        </nav>
      </div>
    </section>

  </main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script src="<?= base_url('assets/js/siralamalar.js?v=4.0') ?>"></script>
<?= $this->endSection() ?>
