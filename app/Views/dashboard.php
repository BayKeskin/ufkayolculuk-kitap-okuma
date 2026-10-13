<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Üye Dashboard & Okuma İstatistikleri - Ufka Yolculuk</title>
  <meta name="description"
    content="Ufka Yolculuk kişisel okuma istatistikleri, kitap ilerlemeleri, sesli dinleme süreleri, rozetler ve sınav sonuçları paneli.">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap"
    rel="stylesheet">

  <!-- Bootstrap 5.3 CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome 6 Pro/Free -->
  <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">

  <!-- Ana Stil & Dashboard Özel Stili -->
  <link rel="stylesheet" href="assets/css/style.css?v=3.5">
  <link rel="stylesheet" href="assets/css/dashboard.css?v=3.5">
</head>

<body class="dashboard-body">

  <!-- =========================================================================
       Üst Navigasyon Menüsü (Header / Navbar)
       ========================================================================= -->
  <header class="portal-navbar">
    <div class="container-portal">
      <div class="d-flex align-items-center justify-content-between">

        <!-- Sol: Logo -->
        <a href="home.html" class="brand-logo-wrap" title="Ufka Yolculuk Anasayfa">
          <img src="assets/images/logo.png" alt="Ufka Yolculuk Logo" class="brand-logo-img">
        </a>

        <!-- Orta: Ana Menü Linkleri -->
        <nav class="d-none d-lg-block">
          <ul class="nav-menu-list">
            <li class="nav-menu-item">
              <a href="home.html" class="nav-link-custom">
                <i class="fa-solid fa-house"></i>
                <span>Anasayfa</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="kitaplar.html" class="nav-link-custom">
                <i class="fa-solid fa-book-open"></i>
                <span>Yarışma Kitapları</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="kitap-oku.html?book=tevhid-muhafizlari&page=5" class="nav-link-custom">
                <i class="fa-solid fa-headphones"></i>
                <span>Sesli Kitap Oku</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="dashboard.html" class="nav-link-custom active">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="index.html" class="nav-link-custom text-warning">
                <i class="fa-solid fa-layer-group"></i>
                <span>Sayfalar (Sunum)</span>
              </a>
            </li>
          </ul>
        </nav>

        <!-- Sağ: Arama, Bildirim ve Kullanıcı Dropdown Menüleri -->
        <div class="nav-actions">
          <button type="button" class="icon-action-btn" id="navSearchTrigger" title="Arama Yap (Ctrl+K)" aria-expanded="false">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>

          <!-- Bildirimler Açılır Menüsü -->
          <div class="nav-dropdown-wrapper" id="notifDropdownWrap">
            <button type="button" class="icon-action-btn" id="notificationBtn" title="Bildirimler"
              aria-expanded="false">
              <i class="fa-solid fa-bell"></i>
              <span class="notification-badge" id="notifCountBadge">3</span>
            </button>

            <div class="portal-popover-menu notif-popover-menu" id="notifDropdownMenu">
              <div class="popover-header">
                <div class="d-flex align-items-center gap-2">
                  <span class="popover-title">Bildirimler</span>
                  <span class="badge-popover-count" id="notifUnreadPill">3 Yeni</span>
                </div>
                <button type="button" class="btn-popover-text" id="markAllNotifsRead">Tümünü Okundu Say</button>
              </div>

              <div class="popover-body-scroll">
                <div class="notif-item-row unread">
                  <div class="notif-item-icon bg-primary-subtle text-primary">
                    <i class="fa-solid fa-headphones"></i>
                  </div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Yeni Sesli Kitap Eklendi</div>
                    <div class="notif-item-text">"Tevhid Muhafızları" 163MB tam sesli okuması hazırlandı.</div>
                    <div class="notif-item-time"><i class="fa-regular fa-clock me-1"></i>10 dakika önce</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </div>

                <div class="notif-item-row unread">
                  <div class="notif-item-icon bg-warning-subtle text-warning">
                    <i class="fa-solid fa-trophy"></i>
                  </div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Tebrikler! Rozet Kazandınız</div>
                    <div class="notif-item-text">7 Günlük Okuma Serisi tamamlandı (+100 Puan).</div>
                    <div class="notif-item-time"><i class="fa-regular fa-clock me-1"></i>2 saat önce</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </div>

                <div class="notif-item-row unread">
                  <div class="notif-item-icon bg-success-subtle text-success">
                    <i class="fa-solid fa-calendar-check"></i>
                  </div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Deneme Sınavı Hatırlatması</div>
                    <div class="notif-item-text">Online deneme sınavına 2 gün kaldı!</div>
                    <div class="notif-item-time"><i class="fa-regular fa-clock me-1"></i>1 gün önce</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </div>
              </div>

              <div class="popover-footer">
                <a href="#" class="popover-footer-link">
                  <span>Tüm Bildirimleri Görüntüle</span>
                  <i class="fa-solid fa-chevron-right ms-1"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Kullanıcı Profil Menüsü -->
          <div class="nav-dropdown-wrapper" id="userProfileDropdownWrap">
            <button type="button" class="user-nav-dropdown cursor-pointer" id="userNavDropdownBtn"
              title="Kullanıcı Menüsü" aria-expanded="false">
              <div class="user-initial-avatar" title="Ahmet Yılmaz">AY</div>
              <div class="user-nav-text d-none d-sm-block">
                <span class="user-nav-greeting">Merhaba,</span>
                <span class="user-nav-name">Ahmet Yılmaz</span>
              </div>
              <i class="fa-solid fa-chevron-down user-nav-chevron ms-1 d-none d-sm-inline-block"></i>
            </button>

            <div class="portal-popover-menu profile-popover-menu" id="userProfileDropdownMenu">
              <div class="profile-popover-header">
                <div class="user-avatar-large user-initial-avatar"
                  style="width: 44px; height: 44px; min-width: 44px; font-size: 1rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                  AY</div>
                <div class="profile-popover-user-info">
                  <div class="profile-popover-name">Ahmet Yılmaz</div>
                  <div class="profile-popover-email">ahmet.yilmaz@ufkayolculuk.com</div>
                  <span class="badge bg-primary-subtle text-primary rounded-pill mt-1"
                    style="font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.55rem;">Katılımcı (2025)</span>
                </div>
              </div>

              <div class="popover-divider"></div>

              <div class="profile-popover-menu-list">
                <a href="dashboard.html" class="profile-menu-item active">
                  <i class="fa-solid fa-chart-pie menu-icon text-primary"></i>
                  <span>İstatistiklerim & Dashboard</span>
                </a>
                <a href="#rozetler" class="profile-menu-item">
                  <i class="fa-solid fa-trophy menu-icon text-warning"></i>
                  <span>Puanlarım & Rozetlerim</span>
                  <span class="badge bg-warning-subtle text-dark ms-auto"
                    style="font-size: 0.68rem; font-weight: 700;">2.450 P</span>
                </a>
                <a href="index.html#kitaplar" class="profile-menu-item">
                  <i class="fa-solid fa-bookmark menu-icon text-primary"></i>
                  <span>Kayıtlı Kitaplar</span>
                </a>
                <a href="#" class="profile-menu-item">
                  <i class="fa-solid fa-gear menu-icon"></i>
                  <span>Hesap Ayarları</span>
                </a>
              </div>

              <div class="popover-divider"></div>

              <a href="#" class="profile-menu-item logout-item text-danger">
                <i class="fa-solid fa-arrow-right-from-bracket menu-icon text-danger"></i>
                <span>Çıkış Yap</span>
              </a>
            </div>
          </div>

        </div>

      </div>
    </div>
  </header>

  <!-- =========================================================================
       Dashboard Ana Gövde
       ========================================================================= -->
  <main class="py-4">
    <div class="container-portal">

      <!-- 1. Hero Profil Karşılama Kartı -->
      <section class="dashboard-hero-card">
        <div class="row align-items-center g-4">

          <!-- Sol: Kullanıcı Profil Başlığı -->
          <div class="col-lg-5">
            <div class="dash-user-profile-wrap">
              <div class="dash-avatar-large">
                <span>AY</span>
                <span class="dash-avatar-online-dot" title="Aktif Kullanıcı"></span>
              </div>
              <div class="dash-user-titles">
                <span class="dash-user-greeting">
                  <i class="fa-regular fa-hand-wave text-warning"></i>
                  <span>Tekrar Hoş Geldin,</span>
                </span>
                <h1 class="dash-user-name">Ahmet Yılmaz</h1>
                <div class="dash-user-tags-row">
                  <span class="dash-tag-pill blue">
                    <i class="fa-solid fa-graduation-cap me-1"></i> Ortaokul Düzeyi
                  </span>
                  <span class="dash-tag-pill gold">
                    <i class="fa-solid fa-star me-1"></i> 2025 Yarışmacısı
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Sağ: 4'lü Hızlı Skor Kartı -->
          <div class="col-lg-7">
            <div class="dash-quick-scores-row">

              <!-- Puanım -->
              <div class="dash-score-cell">
                <span class="dash-score-label">
                  <i class="fa-solid fa-trophy text-warning"></i> Toplam Puan
                </span>
                <div class="dash-score-value">
                  <span>2.450</span> <span class="score-unit">P</span>
                </div>
                <span class="dash-score-sub"><i class="fa-solid fa-arrow-trend-up me-1"></i>+350 Bu Hafta</span>
              </div>

              <!-- Sıralamam -->
              <div class="dash-score-cell">
                <span class="dash-score-label">
                  <i class="fa-solid fa-ranking-star text-primary"></i> Sıralamam
                </span>
                <div class="dash-score-value">
                  <span>1.245</span> <span class="score-unit">/ 48.000</span>
                </div>
                <span class="dash-score-sub" style="color: #0284c7;">%2.5 Diliminde</span>
              </div>

              <!-- Rozetlerim -->
              <div class="dash-score-cell">
                <span class="dash-score-label">
                  <i class="fa-solid fa-shield-halved text-success"></i> Rozetlerim
                </span>
                <div class="dash-score-value">
                  <span>8</span> <span class="score-unit">/ 12 Rozet</span>
                </div>
                <span class="dash-score-sub" style="color: #6366f1;">4 Kilitli Hedef</span>
              </div>

              <!-- Günlük Seri -->
              <div class="dash-score-cell">
                <span class="dash-score-label">
                  <i class="fa-solid fa-fire text-danger"></i> Okuma Serisi
                </span>
                <div class="dash-score-value">
                  <span>14</span> <span class="score-unit">Gün</span>
                </div>
                <span class="dash-score-sub" style="color: #ea580c;">🔥 Kesintisiz</span>
              </div>

            </div>
          </div>

        </div>
      </section>

      <!-- 2. İki Sütunlu Dashboard Grid Düzeni -->
      <div class="row g-4">

        <!-- =====================================================================
             SOL SÜTUN: Kitap İlerlemeleri, Detaylı Aktivite Grafiği, Sınav Sonuçları
             ===================================================================== -->
        <div class="col-lg-8">

          <!-- 1. Devam Eden Kitaplarım & İlerleme Takibi -->
          <section class="dashboard-card">
            <div class="dash-card-header">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon blue">
                  <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <div>
                  <h2 class="dash-card-heading">Kayıtlı Kitaplarım & Okuma Takibi</h2>
                  <p class="dash-card-sub">Kaldığınız sayfadan okumaya veya dinlemeye devam edin</p>
                </div>
              </div>
              <a href="index.html#kitaplar" class="btn-outline-hero py-1 px-3 fs-7">
                <span>Tüm Kitaplar</span>
                <i class="fa-solid fa-chevron-right ms-1"></i>
              </a>
            </div>

            <div class="dash-books-grid">

              <!-- Kitap 1: Tevhid Muhafızları (Aktif & Devam Ediyor) -->
              <div class="dash-book-progress-card">
                <div class="dash-book-cover-wrap">
                  <img src="assets/images/books/book-tevhid-muhafizlari.svg" alt="Tevhid Muhafızları">
                </div>
                <div class="dash-book-details">
                  <div>
                    <h3 class="dash-book-title">Tevhid Muhafızları</h3>
                    <div class="dash-book-level">Ortaokul Düzeyi • 185 Sayfa</div>
                  </div>
                  <div>
                    <div class="dash-book-progress-track">
                      <div class="dash-book-progress-fill" style="width: 68%;"></div>
                    </div>
                    <div class="dash-book-progress-meta">
                      <span>%68 Tamamlandı</span>
                      <span>Sayfa 125 / 185</span>
                    </div>
                    <div class="dash-book-actions-row">
                      <a href="kitap-oku.html?book=tevhid-muhafizlari&page=125" class="btn-dash-read"
                        title="Kaldığın Yerden Oku">
                        <i class="fa-solid fa-book-open"></i> <span>Kaldığın Yerden Oku</span>
                      </a>
                      <a href="kitap-oku.html?book=tevhid-muhafizlari&page=125" class="btn-dash-listen"
                        title="Sesli Dinle">
                        <i class="fa-solid fa-headphones"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kitap 2: Kuşların Çağrısı (Tamamlandı) -->
              <div class="dash-book-progress-card">
                <div class="dash-book-cover-wrap">
                  <img src="assets/images/books/book-kuslarin-cagrisi.svg" alt="Kuşların Çağrısı">
                </div>
                <div class="dash-book-details">
                  <div>
                    <h3 class="dash-book-title">Kuşların Çağrısı</h3>
                    <div class="dash-book-level">İlkokul Düzeyi • 160 Sayfa</div>
                  </div>
                  <div>
                    <div class="dash-book-progress-track">
                      <div class="dash-book-progress-fill green" style="width: 100%;"></div>
                    </div>
                    <div class="dash-book-progress-meta">
                      <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i>Tamamlandı</span>
                      <span>160 / 160 Sayfa</span>
                    </div>
                    <div class="dash-book-actions-row">
                      <a href="kitap-oku.html?book=kuslarin-cagrisi&page=1" class="btn-dash-read bg-success"
                        title="Tekrar Oku">
                        <i class="fa-solid fa-rotate-left"></i> <span>Gözden Geçir</span>
                      </a>
                      <a href="kitap-oku.html?book=kuslarin-cagrisi&page=1" class="btn-dash-listen" title="Sesli Dinle">
                        <i class="fa-solid fa-headphones"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kitap 3: Gördüğüme Görmediğime (%35) -->
              <div class="dash-book-progress-card">
                <div class="dash-book-cover-wrap">
                  <img src="assets/images/books/book-gordugume-gormedigime.svg" alt="Gördüğüme Görmediğime">
                </div>
                <div class="dash-book-details">
                  <div>
                    <h3 class="dash-book-title">Gördüğüme Görmediğime</h3>
                    <div class="dash-book-level">Lise Düzeyi • 190 Sayfa</div>
                  </div>
                  <div>
                    <div class="dash-book-progress-track">
                      <div class="dash-book-progress-fill" style="width: 35%;"></div>
                    </div>
                    <div class="dash-book-progress-meta">
                      <span>%35 Tamamlandı</span>
                      <span>Sayfa 66 / 190</span>
                    </div>
                    <div class="dash-book-actions-row">
                      <a href="kitap-oku.html?book=gordugume-gormedigime&page=66" class="btn-dash-read"
                        title="Devam Et">
                        <i class="fa-solid fa-book-open"></i> <span>Devam Et</span>
                      </a>
                      <a href="kitap-oku.html?book=gordugume-gormedigime&page=66" class="btn-dash-listen"
                        title="Sesli Dinle">
                        <i class="fa-solid fa-headphones"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kitap 4: Nasıl İnanmalı? (%15) -->
              <div class="dash-book-progress-card">
                <div class="dash-book-cover-wrap">
                  <img src="assets/images/books/book-nasil-inanmali.svg" alt="Nasıl İnanmalı?">
                </div>
                <div class="dash-book-details">
                  <div>
                    <h3 class="dash-book-title">Nasıl İnanmalı?</h3>
                    <div class="dash-book-level">Yetişkin Düzeyi • 210 Sayfa</div>
                  </div>
                  <div>
                    <div class="dash-book-progress-track">
                      <div class="dash-book-progress-fill" style="width: 15%;"></div>
                    </div>
                    <div class="dash-book-progress-meta">
                      <span>%15 Tamamlandı</span>
                      <span>Sayfa 32 / 210</span>
                    </div>
                    <div class="dash-book-actions-row">
                      <a href="kitap-oku.html?book=nasil-inanmali&page=32" class="btn-dash-read" title="Okumaya Başla">
                        <i class="fa-solid fa-book-open"></i> <span>Devam Et</span>
                      </a>
                      <a href="kitap-oku.html?book=nasil-inanmali&page=32" class="btn-dash-listen" title="Sesli Dinle">
                        <i class="fa-solid fa-headphones"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </section>

          <!-- 2. Detaylı Aktivite Grafiği & İstatistik Metrikleri -->
          <section class="dashboard-card">
            <div class="dash-card-header">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon purple">
                  <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                  <h2 class="dash-card-heading">Okuma & Dinleme Performansım</h2>
                  <p class="dash-card-sub">Günlük ve haftalık aktivite dağılımınız</p>
                </div>
              </div>

              <!-- Filtre Sekmeleri -->
              <div class="dash-filter-tabs">
                <button type="button" class="dash-tab-btn active" data-filter="week">Bu Hafta</button>
                <button type="button" class="dash-tab-btn" data-filter="month">Bu Ay</button>
                <button type="button" class="dash-tab-btn" data-filter="all">Tümü</button>
              </div>
            </div>

            <!-- 4'lü Metrik Kartları -->
            <div class="dash-metrics-grid">

              <!-- Okunan Sayfa -->
              <div class="dash-metric-card">
                <div class="dash-metric-icon-box blue">
                  <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="dash-metric-body">
                  <span class="dash-metric-title">Okunan Sayfa</span>
                  <div class="dash-metric-num-row">
                    <span class="dash-metric-num" id="statMetricPage">125</span>
                    <span class="dash-metric-growth">+18%</span>
                  </div>
                </div>
              </div>

              <!-- Dinlenen Süre -->
              <div class="dash-metric-card">
                <div class="dash-metric-icon-box purple">
                  <i class="fa-solid fa-headphones"></i>
                </div>
                <div class="dash-metric-body">
                  <span class="dash-metric-title">Dinlenen Süre</span>
                  <div class="dash-metric-num-row">
                    <span class="dash-metric-num" id="statMetricAudio">245 dk</span>
                    <span class="dash-metric-growth">+24%</span>
                  </div>
                </div>
              </div>

              <!-- Tamamlanan Kitap -->
              <div class="dash-metric-card">
                <div class="dash-metric-icon-box green">
                  <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="dash-metric-body">
                  <span class="dash-metric-title">Biten Kitap</span>
                  <div class="dash-metric-num-row">
                    <span class="dash-metric-num" id="statMetricBook">2</span>
                    <span class="dash-metric-growth">+1</span>
                  </div>
                </div>
              </div>

              <!-- Kazanılan Puan -->
              <div class="dash-metric-card">
                <div class="dash-metric-icon-box gold">
                  <i class="fa-solid fa-star"></i>
                </div>
                <div class="dash-metric-body">
                  <span class="dash-metric-title">Kazanılan Puan</span>
                  <div class="dash-metric-num-row">
                    <span class="dash-metric-num" id="statMetricPoint">2.450</span>
                    <span class="dash-metric-growth">+350</span>
                  </div>
                </div>
              </div>

            </div>

            <!-- İnteraktif SVG Bezier Eğri Grafiği -->
            <div class="dash-chart-wrapper">
              <div class="dash-chart-legend">
                <div class="dash-legend-item">
                  <span class="dash-legend-dot blue"></span>
                  <span>Okunan Sayfa (Sayfa / Gün)</span>
                </div>
                <div class="dash-legend-item">
                  <span class="dash-legend-dot purple"></span>
                  <span>Dinlenen Süre (Dakika / Gün)</span>
                </div>
              </div>

              <!-- Tooltip Açılır Baloncuğu -->
              <div class="chart-tooltip-popup" id="chartTooltip"></div>

              <svg class="dash-svg-chart" viewBox="0 0 520 160">
                <!-- Yatay Kılavuz Çizgileri -->
                <line x1="40" y1="20" x2="490" y2="20" class="dash-chart-grid" />
                <text x="15" y="24" class="dash-chart-axis-text">100</text>

                <line x1="40" y1="55" x2="490" y2="55" class="dash-chart-grid" />
                <text x="15" y="59" class="dash-chart-axis-text">75</text>

                <line x1="40" y1="90" x2="490" y2="90" class="dash-chart-grid" />
                <text x="15" y="94" class="dash-chart-axis-text">50</text>

                <line x1="40" y1="125" x2="490" y2="125" class="dash-chart-grid" />
                <text x="15" y="129" class="dash-chart-axis-text">25</text>

                <line x1="40" y1="150" x2="490" y2="150" class="dash-chart-grid" />
                <text x="25" y="154" class="dash-chart-axis-text">0</text>

                <!-- Mavi Çizgi (Okuma Eğrisi) -->
                <path id="chartBluePath"
                  d="M 50 120 C 85 120, 85 85, 120 85 C 155 85, 155 105, 190 105 C 225 105, 225 45, 260 45 C 295 45, 295 80, 330 80 C 365 80, 365 55, 400 55 C 435 55, 435 25, 470 25"
                  class="dash-chart-line-blue" />

                <!-- Mor Çizgi (Dinleme Eğrisi) -->
                <path id="chartPurplePath"
                  d="M 50 135 C 85 135, 85 110, 120 110 C 155 110, 155 90, 190 90 C 225 90, 225 65, 260 65 C 295 65, 295 95, 330 95 C 365 95, 365 75, 400 75 C 435 75, 435 45, 470 45"
                  class="dash-chart-line-purple" />

                <!-- İnteraktif Veri Noktaları -->
                <g id="chartDotsGroup">
                  <circle cx="50" cy="120" class="dash-chart-dot" data-info="Pzt: 12 sf / 20 dk"></circle>
                  <circle cx="120" cy="85" class="dash-chart-dot" data-info="Sal: 25 sf / 35 dk"></circle>
                  <circle cx="190" cy="105" class="dash-chart-dot" data-info="Çar: 18 sf / 45 dk"></circle>
                  <circle cx="260" cy="45" class="dash-chart-dot" data-info="Per: 40 sf / 60 dk"></circle>
                  <circle cx="330" cy="80" class="dash-chart-dot" data-info="Cum: 28 sf / 30 dk"></circle>
                  <circle cx="400" cy="55" class="dash-chart-dot" data-info="Cmt: 36 sf / 50 dk"></circle>
                  <circle cx="470" cy="25" class="dash-chart-dot" data-info="Paz: 52 sf / 85 dk"></circle>
                </g>

                <!-- Gün İsimleri -->
                <text x="50" y="154" class="dash-chart-axis-text" text-anchor="middle">Pzt</text>
                <text x="120" y="154" class="dash-chart-axis-text" text-anchor="middle">Sal</text>
                <text x="190" y="154" class="dash-chart-axis-text" text-anchor="middle">Çar</text>
                <text x="260" y="154" class="dash-chart-axis-text" text-anchor="middle">Per</text>
                <text x="330" y="154" class="dash-chart-axis-text" text-anchor="middle">Cum</text>
                <text x="400" y="154" class="dash-chart-axis-text" text-anchor="middle">Cmt</text>
                <text x="470" y="154" class="dash-chart-axis-text" text-anchor="middle">Paz</text>
              </svg>
            </div>

          </section>

          <!-- 3. Sınav & Quiz Performansı -->
          <section class="dashboard-card">
            <div class="dash-card-header">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon gold">
                  <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                  <h2 class="dash-card-heading">Deneme Sınavları & Quiz Performansı</h2>
                  <p class="dash-card-sub">Online sınavlarda elde ettiğiniz başarı ve analizler</p>
                </div>
              </div>
              <span class="badge bg-success-subtle text-success fs-7 fw-bold px-3 py-2 rounded-pill">
                <i class="fa-solid fa-trophy me-1"></i> Başarı Ortalaması: %91
              </span>
            </div>

            <div class="dash-exam-cards-row">

              <!-- Sınav 1 -->
              <div class="dash-exam-item-card">
                <div>
                  <div class="dash-exam-header">
                    <span class="dash-exam-title">1. Online Deneme</span>
                    <span class="dash-exam-score-badge">88 Puan</span>
                  </div>
                  <div class="dash-exam-stats-list">
                    <span class="stat-correct"><i class="fa-solid fa-check me-1"></i>44 Doğru</span>
                    <span class="stat-wrong"><i class="fa-solid fa-xmark me-1"></i>6 Yanlış</span>
                    <span class="text-muted"><i class="fa-solid fa-ranking-star me-1"></i>Sıra: 1.420</span>
                  </div>
                </div>
                <div class="dash-book-progress-track">
                  <div class="dash-book-progress-fill" style="width: 88%;"></div>
                </div>
              </div>

              <!-- Sınav 2 -->
              <div class="dash-exam-item-card">
                <div>
                  <div class="dash-exam-header">
                    <span class="dash-exam-title">2. Online Deneme</span>
                    <span class="dash-exam-score-badge" style="color: #10b981; background: rgba(16, 185, 129, 0.1);">94
                      Puan</span>
                  </div>
                  <div class="dash-exam-stats-list">
                    <span class="stat-correct"><i class="fa-solid fa-check me-1"></i>47 Doğru</span>
                    <span class="stat-wrong"><i class="fa-solid fa-xmark me-1"></i>3 Yanlış</span>
                    <span class="text-muted"><i class="fa-solid fa-ranking-star me-1"></i>Sıra: 890</span>
                  </div>
                </div>
                <div class="dash-book-progress-track">
                  <div class="dash-book-progress-fill green" style="width: 94%;"></div>
                </div>
              </div>

              <!-- Quizler -->
              <div class="dash-exam-item-card">
                <div>
                  <div class="dash-exam-header">
                    <span class="dash-exam-title">Bölüm Değerlendirmeleri</span>
                    <span class="dash-exam-score-badge"
                      style="color: #6366f1; background: rgba(99, 102, 241, 0.1);">%92</span>
                  </div>
                  <div class="dash-exam-stats-list">
                    <span class="stat-correct"><i class="fa-solid fa-star me-1"></i>12 Quiz</span>
                    <span class="text-muted"><i class="fa-solid fa-trophy me-1"></i>+450 Bonus P</span>
                  </div>
                </div>
                <div class="dash-book-progress-track">
                  <div class="dash-book-progress-fill" style="width: 92%; background: #6366f1;"></div>
                </div>
              </div>

            </div>
          </section>

          <!-- 4. Son Aktiviteler Zaman Çizelgesi -->
          <section class="dashboard-card">
            <div class="dash-card-header">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon green">
                  <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                  <h2 class="dash-card-heading">Son Aktiviteler & Zaman Çizelgesi</h2>
                  <p class="dash-card-sub">Kitap okuma, sesli dinleme ve puan kazanma geçmişiniz</p>
                </div>
              </div>
            </div>

            <div class="dash-timeline-list">

              <!-- Aktivite 1 -->
              <div class="dash-timeline-item">
                <span class="dash-timeline-dot"></span>
                <div class="dash-timeline-content">
                  <div>
                    <div class="dash-timeline-title">Tevhid Muhafızları okundu & dinlendi</div>
                    <div class="dash-timeline-sub">Sayfa 110-125 arası okundu • 22 dakika sesli dinleme yapıldı • Dün
                      21:40</div>
                  </div>
                  <span class="dash-timeline-points">+45 Puan</span>
                </div>
              </div>

              <!-- Aktivite 2 -->
              <div class="dash-timeline-item">
                <span class="dash-timeline-dot gold"></span>
                <div class="dash-timeline-content">
                  <div>
                    <div class="dash-timeline-title">7 Günlük Seri Rozeti Kazanıldı!</div>
                    <div class="dash-timeline-sub">1 hafta boyunca her gün en az 30 dakika okuma yapıldı • 2 gün önce
                    </div>
                  </div>
                  <span class="dash-timeline-points">+100 Puan</span>
                </div>
              </div>

              <!-- Aktivite 3 -->
              <div class="dash-timeline-item">
                <span class="dash-timeline-dot green"></span>
                <div class="dash-timeline-content">
                  <div>
                    <div class="dash-timeline-title">2. Online Deneme Sınavı Tamamlandı</div>
                    <div class="dash-timeline-sub">50 soruda 47 doğru ile %94 başarı puanı elde edildi • 3 gün önce
                    </div>
                  </div>
                  <span class="dash-timeline-points">+250 Puan</span>
                </div>
              </div>

              <!-- Aktivite 4 -->
              <div class="dash-timeline-item">
                <span class="dash-timeline-dot"></span>
                <div class="dash-timeline-content">
                  <div>
                    <div class="dash-timeline-title">Kuşların Çağrısı Kitabı Tamamlandı</div>
                    <div class="dash-timeline-sub">160 sayfa ve tüm seslendirme bölümleri başarıyla bitirildi • 4 gün
                      önce</div>
                  </div>
                  <span class="dash-timeline-points">+300 Puan</span>
                </div>
              </div>

            </div>
          </section>

        </div>


        <!-- =====================================================================
             SAĞ SÜTUN: Günlük Hedef, Rozetler Galerisi, Liderlik & Etkinlikler
             ===================================================================== -->
        <div class="col-lg-4">

          <!-- 1. Günlük Okuma Hedefi Kartı -->
          <div class="dash-daily-goal-card">
            <div class="dash-goal-header">
              <span class="dash-goal-title">
                <i class="fa-solid fa-bullseye me-2"></i> Günlük Okuma Hedefi
              </span>
              <button type="button" class="btn btn-sm btn-light py-0 px-2 fs-8 fw-bold" id="btnEditGoal"
                title="Hedefi Düzenle">
                <i class="fa-solid fa-pen me-1"></i> Düzenle
              </button>
            </div>

            <div class="dash-goal-nums" id="dashGoalNums">
              300 <span>/ 600 dk</span>
            </div>

            <div class="dash-goal-track">
              <div class="dash-goal-fill" id="dashGoalFill" style="width: 50%;"></div>
            </div>

            <p class="dash-goal-info" id="dashGoalInfo">
              Harika gidiyorsun! Günlük hedefin %50'sine ulaştın.
            </p>
          </div>

          <!-- 2. Kazanılan & Kilitli Rozetler Koleksiyonu -->
          <section class="dashboard-card" id="rozetler">
            <div class="dash-card-header mb-3">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon gold">
                  <i class="fa-solid fa-trophy"></i>
                </div>
                <div>
                  <h3 class="dash-card-heading fs-6">Rozetlerim & Başarımlar</h3>
                  <p class="dash-card-sub fs-8">8 Kazanılan • 4 Kilitli</p>
                </div>
              </div>
            </div>

            <div class="dash-badges-grid">

              <!-- Rozet 1 -->
              <div class="dash-badge-item" data-badge-name="İlk Adım"
                data-badge-desc="Ufka Yolculuk portalına kayıt olup ilk kitabı okumaya başladın."
                data-badge-date="12 Ekim 2024" data-badge-points="+50 Puan">
                <div class="dash-badge-icon-box gold">
                  <i class="fa-solid fa-shoe-prints"></i>
                </div>
                <span class="dash-badge-name">İlk Adım</span>
              </div>

              <!-- Rozet 2 -->
              <div class="dash-badge-item" data-badge-name="Ses Avcısı"
                data-badge-desc="100 dakikanın üzerinde sesli kitap dinlemesi gerçekleştirdin."
                data-badge-date="20 Ekim 2024" data-badge-points="+100 Puan">
                <div class="dash-badge-icon-box blue">
                  <i class="fa-solid fa-headphones"></i>
                </div>
                <span class="dash-badge-name">Ses Avcısı</span>
              </div>

              <!-- Rozet 3 -->
              <div class="dash-badge-item" data-badge-name="7 Günlük Seri"
                data-badge-desc="1 hafta boyunca kesintisiz her gün kitap okudun." data-badge-date="28 Ekim 2024"
                data-badge-points="+100 Puan">
                <div class="dash-badge-icon-box gold">
                  <i class="fa-solid fa-fire"></i>
                </div>
                <span class="dash-badge-name">7 Günlük Seri</span>
              </div>

              <!-- Rozet 4 -->
              <div class="dash-badge-item" data-badge-name="Hız Tutkunu"
                data-badge-desc="Kitabı 1.5x ve üzeri hızda dinleme deneyimi yaşadın." data-badge-date="2 Kasım 2024"
                data-badge-points="+50 Puan">
                <div class="dash-badge-icon-box purple">
                  <i class="fa-solid fa-gauge-high"></i>
                </div>
                <span class="dash-badge-name">Hız Tutkunu</span>
              </div>

              <!-- Rozet 5 -->
              <div class="dash-badge-item" data-badge-name="Şampiyon Adayı"
                data-badge-desc="Online deneme sınavında %90 üzeri başarı gösterdin." data-badge-date="10 Kasım 2024"
                data-badge-points="+150 Puan">
                <div class="dash-badge-icon-box gold">
                  <i class="fa-solid fa-award"></i>
                </div>
                <span class="dash-badge-name">Şampiyon Adayı</span>
              </div>

              <!-- Rozet 6 -->
              <div class="dash-badge-item" data-badge-name="Sayfa Canavarı"
                data-badge-desc="Toplam 500 sayfanın üzerinde kitap okuma tamamladın." data-badge-date="18 Kasım 2024"
                data-badge-points="+100 Puan">
                <div class="dash-badge-icon-box blue">
                  <i class="fa-solid fa-book-open"></i>
                </div>
                <span class="dash-badge-name">Sayfa Canavarı</span>
              </div>

              <!-- Rozet 7 -->
              <div class="dash-badge-item" data-badge-name="Sabah Kuşu"
                data-badge-desc="Sabah 06:00 - 09:00 saatleri arasında okuma yaptın." data-badge-date="22 Kasım 2024"
                data-badge-points="+50 Puan">
                <div class="dash-badge-icon-box purple">
                  <i class="fa-solid fa-sun"></i>
                </div>
                <span class="dash-badge-name">Sabah Kuşu</span>
              </div>

              <!-- Rozet 8 -->
              <div class="dash-badge-item" data-badge-name="Tevhid Kaşifi"
                data-badge-desc="Tevhid Muhafızları kitabında 100 sayfayı aştın." data-badge-date="25 Kasım 2024"
                data-badge-points="+100 Puan">
                <div class="dash-badge-icon-box gold">
                  <i class="fa-solid fa-compass"></i>
                </div>
                <span class="dash-badge-name">Tevhid Kaşifi</span>
              </div>

              <!-- Kilitli 1 -->
              <div class="dash-badge-item locked" data-badge-name="30 Günlük Seri"
                data-badge-desc="1 ay boyunca kesintisiz her gün kitap oku (Şu an: 14/30 gün)."
                data-badge-points="+300 Puan">
                <div class="dash-badge-icon-box locked">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <span class="dash-badge-name">30 Günlük Seri</span>
              </div>

              <!-- Kilitli 2 -->
              <div class="dash-badge-item locked" data-badge-name="Kitap Kurdu"
                data-badge-desc="Tüm yarışma kitaplarını baştan sona bitir (Şu an: 2/4 kitap)."
                data-badge-points="+500 Puan">
                <div class="dash-badge-icon-box locked">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <span class="dash-badge-name">Kitap Kurdu</span>
              </div>

              <!-- Kilitli 3 -->
              <div class="dash-badge-item locked" data-badge-name="1.lik Kürsüsü"
                data-badge-desc="Türkiye genel sıralamasında ilk 100'e gir." data-badge-points="+1000 Puan">
                <div class="dash-badge-icon-box locked">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <span class="dash-badge-name">1.lik Kürsüsü</span>
              </div>

              <!-- Kilitli 4 -->
              <div class="dash-badge-item locked" data-badge-name="Master Okuyucu"
                data-badge-desc="Tüm quizlerde %100 tam puan başarısına ulaş." data-badge-points="+400 Puan">
                <div class="dash-badge-icon-box locked">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <span class="dash-badge-name">Master Okuyucu</span>
              </div>

            </div>
          </section>

          <!-- 3. Kategori İçi Liderlik Tablosu (Leaderboard) -->
          <section class="dashboard-card">
            <div class="dash-card-header mb-3">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon blue">
                  <i class="fa-solid fa-ranking-star"></i>
                </div>
                <div>
                  <h3 class="dash-card-heading fs-6">Liderlik Sıralaması</h3>
                  <p class="dash-card-sub fs-8">Ortaokul Düzeyi • Türkiye Geneli</p>
                </div>
              </div>
            </div>

            <div class="dash-leaderboard-list">

              <!-- 1. Sıra -->
              <div class="dash-leader-row">
                <div class="dash-leader-left">
                  <span class="dash-rank-badge gold">1</span>
                  <span>Elif Kaya</span>
                </div>
                <span class="dash-leader-points">2.890 P</span>
              </div>

              <!-- 2. Sıra -->
              <div class="dash-leader-row">
                <div class="dash-leader-left">
                  <span class="dash-rank-badge silver">2</span>
                  <span>Mehmet Ali Ş.</span>
                </div>
                <span class="dash-leader-points">2.750 P</span>
              </div>

              <!-- 3. Sıra -->
              <div class="dash-leader-row">
                <div class="dash-leader-left">
                  <span class="dash-rank-badge bronze">3</span>
                  <span>Zeynep Demir</span>
                </div>
                <span class="dash-leader-points">2.610 P</span>
              </div>

              <!-- 4. Sıra -->
              <div class="dash-leader-row">
                <div class="dash-leader-left">
                  <span class="dash-rank-badge normal">4</span>
                  <span>Yusuf Emre K.</span>
                </div>
                <span class="dash-leader-points">2.540 P</span>
              </div>

              <!-- Sen (12. Sıra) -->
              <div class="dash-leader-row self">
                <div class="dash-leader-left">
                  <span class="dash-rank-badge normal bg-primary text-white">12</span>
                  <span>Ahmet Yılmaz (Sen)</span>
                </div>
                <span class="dash-leader-points">2.450 P</span>
              </div>

            </div>
          </section>

          <!-- 4. Yaklaşan Etkinlikler & Sınavlar Geri Sayım -->
          <section class="dashboard-card" id="etkinlikler">
            <div class="dash-card-header mb-3">
              <div class="dash-card-title-wrap">
                <div class="dash-card-icon green">
                  <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                  <h3 class="dash-card-heading fs-6">Yaklaşan Etkinlikler</h3>
                  <p class="dash-card-sub fs-8">Yarışma takvimi ve sınav tarihleri</p>
                </div>
              </div>
            </div>

            <div class="events-items-group">

              <!-- Etkinlik 1 -->
              <div class="event-entry-item">
                <div class="event-left-details">
                  <div class="event-icon-circle blue">
                    <i class="fa-solid fa-calendar-check"></i>
                  </div>
                  <div class="event-info-text">
                    <div class="event-title-name fs-7 fw-bold">Online Deneme Sınavı</div>
                    <div class="event-datetime-sub fs-8">20 Mayıs 2025 - 20:00</div>
                  </div>
                </div>
                <div class="event-countdown-badge">
                  <span class="countdown-day-count">2</span>
                  <span class="countdown-day-label">Gün kaldı</span>
                </div>
              </div>

              <!-- Etkinlik 2 -->
              <div class="event-entry-item">
                <div class="event-left-details">
                  <div class="event-icon-circle red">
                    <i class="fa-solid fa-clipboard-question"></i>
                  </div>
                  <div class="event-info-text">
                    <div class="event-title-name fs-7 fw-bold">Canlı Bilgi Yarışması</div>
                    <div class="event-datetime-sub fs-8">25 Mayıs 2025 - 14:00</div>
                  </div>
                </div>
                <div class="event-countdown-badge">
                  <span class="countdown-day-count">7</span>
                  <span class="countdown-day-label">Gün kaldı</span>
                </div>
              </div>

              <!-- Etkinlik 3 -->
              <div class="event-entry-item">
                <div class="event-left-details">
                  <div class="event-icon-circle orange">
                    <i class="fa-solid fa-clock"></i>
                  </div>
                  <div class="event-info-text">
                    <div class="event-title-name fs-7 fw-bold">Son Başvuru Tarihi</div>
                    <div class="event-datetime-sub fs-8">31 Mayıs 2025 - 23:59</div>
                  </div>
                </div>
                <div class="event-countdown-badge">
                  <span class="countdown-day-count">13</span>
                  <span class="countdown-day-label">Gün kaldı</span>
                </div>
              </div>

            </div>
          </section>

        </div>

      </div>

    </div>
  </main>

  <!-- =========================================================================
       Modal: Rozet Detay Penceresi
       ========================================================================= -->
  <div class="modal fade" id="modalBadgeDetail" tabindex="-1" aria-labelledby="badgeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; background: #ffffff !important; overflow: hidden;">
        <div class="modal-header border-0 pb-0 pt-3 px-4 d-flex justify-content-end">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body text-center px-4 pb-4 pt-0">
          <div class="badge-modal-icon-stage mb-3">
            <div id="badgeModalIcon" class="mx-auto"></div>
          </div>
          <h4 class="fw-bold mb-2 text-dark fs-5" id="badgeModalTitle">Rozet Başlığı</h4>
          <p class="text-muted fs-7 mb-4 px-2" id="badgeModalDesc" style="line-height: 1.5;">Rozet açıklaması burada yer alır.</p>
          <div class="badge-modal-meta-box p-3 bg-light rounded-4 d-flex align-items-center justify-content-between">
            <span class="badge bg-warning text-dark fs-7 fw-bold px-3 py-2 rounded-pill shadow-xs"
              id="badgeModalPoints">+50 Puan</span>
            <span class="text-muted fs-8 fw-semibold" id="badgeModalDate"><i class="fa-regular fa-calendar-check me-1 text-primary"></i>Kazanılma Tarihi</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- =========================================================================
       Modal: Günlük Hedef Düzenleme
       ========================================================================= -->
  <div class="modal fade" id="modalEditGoal" tabindex="-1" aria-labelledby="editGoalModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold fs-6" id="editGoalModalTitle">Günlük Hedefi Düzenle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body px-4">
          <label class="form-label fs-7 text-muted fw-semibold mb-2">Günlük Okuma Hedefi (Dakika):</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control fw-bold" id="inputGoalMinutes" value="600" min="30" max="1440"
              step="30">
            <span class="input-group-text bg-light fw-bold text-muted">dk</span>
          </div>
          <button type="button" class="btn btn-primary w-100 fw-bold rounded-pill" id="btnSaveGoal">Kaydet &
            Güncelle</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap JS (Yerel) -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/header-search.js?v=4.0"></script>
  <script src="assets/js/dashboard.js?v=4.0"></script>
</body>
</html>