<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ufka Yolculuk - Kitap Okuma ve Sesli Dinleme Portalı</title>
  <meta name="description" content="Ufka Yolculuk Kitap Okuma ve Sesli Dinleme Portalı. Bilgini artır, kendini geliştir, ödüller kazan!">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS (Yerel) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome 6 Pro/Free (Yerel - CDN Yok) -->
  <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">

  <!-- Özel Stil Dosyası -->
  <link rel="stylesheet" href="assets/css/style.css?v=3.0">
</head>
<body>

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
              <a href="home.html" class="nav-link-custom active">
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
              <a href="kitaplar.html?year=archive" class="nav-link-custom">
                <i class="fa-solid fa-layer-group"></i>
                <span>Geçmiş Yıllar</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="kitap-oku.html?book=tevhid-muhafizlari&page=5" class="nav-link-custom">
                <i class="fa-solid fa-headphones"></i>
                <span>Sesli Kitap Oku</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="deneme-sinavlari.html" class="nav-link-custom">
                <i class="fa-solid fa-laptop-code text-primary"></i>
                <span>Deneme Sınavları</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="dashboard.html" class="nav-link-custom">
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
          <button type="button" class="icon-action-btn" id="navSearchTrigger" title="Arama Yap">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>

          <!-- 1. Bildirimler Açılır Menüsü (Dropdown) -->
          <div class="nav-dropdown-wrapper" id="notifDropdownWrap">
            <button type="button" class="icon-action-btn" id="notificationBtn" title="Bildirimler" aria-expanded="false">
              <i class="fa-solid fa-bell"></i>
              <span class="notification-badge" id="notifCountBadge">3</span>
            </button>
            
            <!-- Bildirim Açılır Kartı -->
            <div class="portal-popover-menu notif-popover-menu" id="notifDropdownMenu">
              <div class="popover-header">
                <div class="d-flex align-items-center gap-2">
                  <span class="popover-title">Bildirimler</span>
                  <span class="badge-popover-count" id="notifUnreadPill">3 Yeni</span>
                </div>
                <button type="button" class="btn-popover-text" id="markAllNotifsRead">Tümünü Okundu Say</button>
              </div>
              
              <div class="popover-body-scroll">
                <!-- Bildirim 1 -->
                <div class="notif-item-row unread">
                  <div class="notif-item-icon bg-primary-subtle text-primary">
                    <i class="fa-solid fa-headphones"></i>
                  </div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Yeni Sesli Kitap Eklendi</div>
                    <div class="notif-item-text">"Nasıl İnanmalı?" sesli dinleme bölümü aktif edildi.</div>
                    <div class="notif-item-time"><i class="fa-regular fa-clock me-1"></i>10 dakika önce</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </div>

                <!-- Bildirim 2 -->
                <div class="notif-item-row unread">
                  <div class="notif-item-icon bg-warning-subtle text-warning">
                    <i class="fa-solid fa-trophy"></i>
                  </div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Tebrikler! Rozet Kazandınız</div>
                    <div class="notif-item-text">Günlük okuma hedefini tamamlayarak 50 bonus puan kazandınız.</div>
                    <div class="notif-item-time"><i class="fa-regular fa-clock me-1"></i>2 saat önce</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </div>

                <!-- Bildirim 3 -->
                <div class="notif-item-row unread">
                  <div class="notif-item-icon bg-success-subtle text-success">
                    <i class="fa-solid fa-calendar-check"></i>
                  </div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Deneme Sınavı Hatırlatması</div>
                    <div class="notif-item-text">Online deneme sınavına 2 gün kaldı. Hazırlıklarını gözden geçir!</div>
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

          <!-- 2. Kullanıcı Profil Açılır Menüsü (Dropdown) -->
          <div class="nav-dropdown-wrapper" id="userProfileDropdownWrap">
            <button type="button" class="user-nav-dropdown cursor-pointer" id="userNavDropdownBtn" title="Kullanıcı Menüsü" aria-expanded="false">
              <div class="user-initial-avatar" title="Ahmet Yılmaz">AY</div>
              <div class="user-nav-text d-none d-sm-block">
                <span class="user-nav-greeting">Merhaba,</span>
                <span class="user-nav-name">Ahmet Yılmaz</span>
              </div>
              <i class="fa-solid fa-chevron-down user-nav-chevron ms-1 d-none d-sm-inline-block"></i>
            </button>

            <!-- Profil Açılır Kartı -->
            <div class="portal-popover-menu profile-popover-menu" id="userProfileDropdownMenu">
              <div class="profile-popover-header">
                <div class="user-avatar-large user-initial-avatar" style="width: 44px; height: 44px; min-width: 44px; font-size: 1rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">AY</div>
                <div class="profile-popover-user-info">
                  <div class="profile-popover-name">Ahmet Yılmaz</div>
                  <div class="profile-popover-email">ahmet.yilmaz@ufkayolculuk.com</div>
                  <span class="badge bg-primary-subtle text-primary rounded-pill mt-1" style="font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.55rem;">Katılımcı (2025)</span>
                </div>
              </div>

              <div class="popover-divider"></div>

              <div class="profile-popover-menu-list">
                <a href="dashboard.html" class="profile-menu-item">
                  <i class="fa-solid fa-chart-pie menu-icon text-primary"></i>
                  <span>İstatistiklerim & Dashboard</span>
                </a>
                <a href="dashboard.html#rozetler" class="profile-menu-item">
                  <i class="fa-solid fa-trophy menu-icon text-warning"></i>
                  <span>Puanlarım & Rozetlerim</span>
                  <span class="badge bg-warning-subtle text-dark ms-auto" style="font-size: 0.68rem; font-weight: 700;">2.450 P</span>
                </a>
                <a href="kitaplar.html" class="profile-menu-item">
                  <i class="fa-solid fa-bookmark menu-icon text-primary"></i>
                  <span>Yarışma Kitapları</span>
                </a>
                <a href="index.html" class="profile-menu-item">
                  <i class="fa-solid fa-layer-group menu-icon text-info"></i>
                  <span>Tüm Sayfalar (Sunum)</span>
                </a>
              </div>

              <div class="popover-divider"></div>

              <a href="#" class="profile-menu-item logout-item text-danger">
                <i class="fa-solid fa-arrow-right-from-bracket menu-icon text-danger"></i>
                <span>Çıkış Yap</span>
              </a>
            </div>
          </div>

          <!-- Mobil Menü Butonu -->
          <button type="button" class="icon-action-btn d-lg-none" id="mobileMenuToggle" title="Menü">
            <i class="fa-solid fa-bars"></i>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- =========================================================================
       Ana İçerik Bölümü (2 Sütunlu Grid Düzeni)
       ========================================================================= -->
  <main class="py-4">
    <div class="container-portal">
      <div class="row g-4">
        
        <!-- =====================================================================
             SOL SÜTUN: Hero Banner, Arama, Özellikler, Kitaplar, Sesli Çalar, Arşiv
             ===================================================================== -->
        <div class="portal-main-col">
          
          <!-- 1. Hero Tanıtım Bannerı -->
          <section class="hero-showcase-card">
            <div class="row align-items-center">
              
              <!-- Hero Sol Metin ve Butonlar -->
              <div class="col-md-5 hero-left-content">
                <div class="hero-brand-title">
                  <img src="assets/images/logo.png" alt="Ufka Yolculuk" class="hero-ufka-logo">
                </div>
                <h1 class="hero-main-title">
                  Oku • Dinle • Öğren • Yarış
                </h1>
                <p class="hero-subtitle">
                  Bilgini artır, kendini geliştir, ödüller kazan!<br>
                  13 yıldır milyonlarca gönüle ilham oluyoruz.
                </p>
                <div class="hero-actions">
                  <a href="kitaplar.html" class="btn-primary-hero">
                    <span>Yarışmaya Katıl</span>
                    <i class="fa-solid fa-chevron-right"></i>
                  </a>
                  <a href="#kitaplar" class="btn-outline-hero">
                    <span>Kitapları İncele</span>
                    <i class="fa-solid fa-book-open"></i>
                  </a>
                </div>
              </div>

              <!-- Hero Sağ: 3D Kitaplar (Masaüstü: 4'lü Yan Yana, Mobil: Tekli 3D Slider) -->
              <div class="col-md-7 hero-stage-container" id="heroStageContainer">
                <div class="hero-books-row" id="heroBooksRow">
                  <!-- Kitap 1: İlkokul -->
                  <div class="hero-3d-book btn-listen-trigger active-mobile-slide" 
                       data-book-title="Kuşların Çağrısı" 
                       data-book-chapter="Bölüm 3 - Cesaretin Kaynağı" 
                       data-book-img="assets/images/books/book-kuslarin-cagrisi.svg"
                       data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                       data-slide-index="0"
                       title="Kuşların Çağrısı (İlkokul Düzeyi)">
                    <img src="assets/images/books/book-kuslarin-cagrisi.svg" alt="Kuşların Çağrısı">
                  </div>
                  <!-- Kitap 2: Ortaokul -->
                  <div class="hero-3d-book btn-listen-trigger" 
                       data-book-title="Tevhid Muhafızları" 
                       data-book-chapter="1. Bölüm - Boş Damacana (Sayfa 5)" 
                       data-book-img="assets/images/books/book-tevhid-muhafizlari.svg"
                       data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                       data-start-time="2.313"
                       data-start-page="5"
                       data-slide-index="1"
                       title="Tevhid Muhafızları (Ortaokul Düzeyi)">
                    <img src="assets/images/books/book-tevhid-muhafizlari.svg" alt="Tevhid Muhafızları">
                  </div>
                  <!-- Kitap 3: Lise -->
                  <div class="hero-3d-book btn-listen-trigger" 
                       data-book-title="Gördüğüme Görmediğime" 
                       data-book-chapter="Bölüm 2 - Buzdağının Görünmeyen Yüzü" 
                       data-book-img="assets/images/books/book-gordugume-gormedigime.svg"
                       data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                       data-slide-index="2"
                       title="Gördüğüme Görmediğime (Lise Düzeyi)">
                    <img src="assets/images/books/book-gordugume-gormedigime.svg" alt="Gördüğüme Görmediğime">
                  </div>
                  <!-- Kitap 4: Yetişkin -->
                  <div class="hero-3d-book btn-listen-trigger" 
                       data-book-title="Nasıl İnanmalı?" 
                       data-book-chapter="Bölüm 1 - İnanç ve Akıl Dengesi" 
                       data-book-img="assets/images/books/book-nasil-inanmali.svg"
                       data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                       data-slide-index="3"
                       title="Nasıl İnanmalı? (Yetişkin Düzeyi)">
                    <img src="assets/images/books/book-nasil-inanmali.svg" alt="Nasıl İnanmalı?">
                  </div>
                </div>

                <!-- Mobil Tekli Kitap Slider Navigasyon Kontrolleri -->
                <div class="hero-mobile-slider-controls d-md-none" id="heroMobileControls">
                  <button type="button" class="hero-slider-btn prev" id="heroPrevBookBtn" title="Önceki Kitap">
                    <i class="fa-solid fa-chevron-left"></i>
                  </button>
                  <div class="hero-slider-dots" id="heroSliderDots">
                    <span class="hero-dot active" data-index="0"></span>
                    <span class="hero-dot" data-index="1"></span>
                    <span class="hero-dot" data-index="2"></span>
                    <span class="hero-dot" data-index="3"></span>
                  </div>
                  <button type="button" class="hero-slider-btn next" id="heroNextBookBtn" title="Sonraki Kitap">
                    <i class="fa-solid fa-chevron-right"></i>
                  </button>
                </div>

                <!-- Podyum Altlığı -->
                <div class="podium-stage-ellipse"></div>
              </div>

            </div>
          </section>

          <!-- 2. Arama ve Filtreleme Kartı -->
          <section class="search-filter-card">
            <div class="row g-2 align-items-center">
              <div class="col-md-5">
                <div class="search-input-wrap">
                  <input type="text" class="search-field-control" id="mainSearchInput" placeholder="Kitap adı, yazar veya konu ara..." autocomplete="off">
                  <i class="fa-solid fa-magnifying-glass search-icon-inside"></i>
                  <div class="home-search-dropdown" id="homeSearchDropdown"></div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <select class="custom-select-control w-100" id="categorySelect">
                  <option value="all">Kategori: Tüm Kategoriler</option>
                  <option value="ilkokul">İlkokul Düzeyi</option>
                  <option value="ortaokul">Ortaokul Düzeyi</option>
                  <option value="lise">Lise Düzeyi</option>
                  <option value="yetiskin">Yetişkin Düzeyi</option>
                </select>
              </div>
              <div class="col-sm-6 col-md-2">
                <select class="custom-select-control w-100" id="yearSelect">
                  <option value="all">Yıl: Tümü</option>
                  <option value="2025">2025</option>
                  <option value="2024">2024</option>
                  <option value="2023">2023</option>
                  <option value="2022">2022</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn-search-submit w-100" id="searchBtn">
                  <span>Ara</span>
                </button>
              </div>
            </div>
          </section>

          <!-- 3. Öne Çıkan Özellikler Şeridi (6 Rozet) -->
          <section class="features-strip-card">
            <div class="row g-2 row-cols-2 row-cols-md-3 row-cols-xl-6">
              
              <!-- 1. E-Kitap Oku -->
              <div class="col">
                <div class="feature-strip-item">
                  <div class="feature-icon-box">
                    <i class="fa-solid fa-book-open"></i>
                  </div>
                  <div class="feature-text-group">
                    <div class="feature-title">E-Kitap Oku</div>
                    <div class="feature-desc">Online oku, istediğin yerde</div>
                  </div>
                </div>
              </div>

              <!-- 2. Sesli Dinle -->
              <div class="col">
                <div class="feature-strip-item">
                  <div class="feature-icon-box">
                    <i class="fa-solid fa-headphones"></i>
                  </div>
                  <div class="feature-text-group">
                    <div class="feature-title">Sesli Dinle</div>
                    <div class="feature-desc">Kitapları sesli olarak dinle</div>
                  </div>
                </div>
              </div>

              <!-- 3. Okuma Takibi -->
              <div class="col">
                <div class="feature-strip-item">
                  <div class="feature-icon-box">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                  </div>
                  <div class="feature-text-group">
                    <div class="feature-title">Okuma Takibi</div>
                    <div class="feature-desc">İlerlemeni takip et</div>
                  </div>
                </div>
              </div>

              <!-- 4. Kişisel Kütüphane -->
              <div class="col">
                <div class="feature-strip-item">
                  <div class="feature-icon-box">
                    <i class="fa-solid fa-bookmark"></i>
                  </div>
                  <div class="feature-text-group">
                    <div class="feature-title">Kişisel Kütüphane</div>
                    <div class="feature-desc">Kendi kitaplığını oluştur</div>
                  </div>
                </div>
              </div>

              <!-- 5. Puan ve Ödüller -->
              <div class="col">
                <div class="feature-strip-item">
                  <div class="feature-icon-box orange">
                    <i class="fa-solid fa-trophy"></i>
                  </div>
                  <div class="feature-text-group">
                    <div class="feature-title">Puan ve Ödüller</div>
                    <div class="feature-desc">Puan kazan, ödül al</div>
                  </div>
                </div>
              </div>

              <!-- 6. Güvenli Platform -->
              <div class="col">
                <div class="feature-strip-item">
                  <div class="feature-icon-box green">
                    <i class="fa-solid fa-shield-halved"></i>
                  </div>
                  <div class="feature-text-group">
                    <div class="feature-title">Güvenli Platform</div>
                    <div class="feature-desc">Kişisel verilerin korunur</div>
                  </div>
                </div>
              </div>

            </div>
          </section>

          <!-- 4. Yarışma Kitapları & Sesli Kitaplar Satırı -->
          <div class="row g-3 mb-4" id="kitaplar">
            
            <!-- Yarışma Kitapları Slider / Carousel (Geniş Alan) -->
            <div class="col-xl-7 col-lg-7 col-md-12">
              <div class="portal-section-card">
                <div class="section-header-row">
                  <h2 class="section-main-heading">Yarışma Kitapları</h2>
                  <a href="kitaplar.html" class="section-link-all">Tümünü Gör</a>
                </div>

                <div class="books-carousel-wrapper">
                  <button type="button" class="carousel-nav-btn prev" id="prevBookBtn" title="Önceki Kitaplar">
                    <i class="fa-solid fa-chevron-left"></i>
                  </button>

                  <div class="books-slider-scroll" id="contestBooksSlider">
                    
                    <!-- Kitap Kartı 1: Kuşların Çağrısı -->
                    <div class="book-card-item" data-category="ilkokul">
                      <div class="book-thumb-container">
                        <a href="kitap-oku.html?book=kuslarin-cagrisi">
                          <img src="assets/images/books/book-kuslarin-cagrisi.svg" alt="Kuşların Çağrısı">
                        </a>
                      </div>
                      <div class="book-item-title" title="Kuşların Çağrısı">Kuşların Çağrısı</div>
                      <div class="book-item-level">İlkokul Düzeyi</div>
                      <div class="book-progress-wrap">
                        <div class="progress-track-custom">
                          <div class="progress-fill-custom" style="width: 35%;"></div>
                        </div>
                        <span class="progress-text-badge">%35 Okundu</span>
                      </div>
                      <div class="book-action-btns">
                        <a href="kitap-oku.html?book=kuslarin-cagrisi" class="btn-book-action btn-book-continue">Devam Et</a>
                        <button type="button" class="btn-book-action btn-book-audio btn-listen-trigger"
                                data-book-id="kuslarin-cagrisi"
                                data-book-title="Kuşların Çağrısı"
                                data-book-chapter="Bölüm 1 - Başlangıç (Sayfa 1)"
                                data-book-img="assets/images/books/book-kuslarin-cagrisi.svg"
                                data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                                data-start-time="2.313"
                                data-start-page="1"
                                title="Sesli Dinle">
                          <i class="fa-solid fa-headphones"></i>
                          <span>Sesli Dinle</span>
                        </button>
                      </div>
                    </div>

                    <!-- Kitap Kartı 2: Tevhid Muhafızları -->
                    <div class="book-card-item" data-category="ortaokul">
                      <div class="book-thumb-container">
                        <a href="kitap-oku.html?book=tevhid-muhafizlari&page=5">
                          <img src="assets/images/books/book-tevhid-muhafizlari.svg" alt="Tevhid Muhafızları">
                        </a>
                      </div>
                      <div class="book-item-title" title="Tevhid Muhafızları">Tevhid Muhafızları</div>
                      <div class="book-item-level">Ortaokul Düzeyi</div>
                      <div class="book-progress-wrap">
                        <div class="progress-track-custom">
                          <div class="progress-fill-custom" style="width: 68%;"></div>
                        </div>
                        <span class="progress-text-badge">%68 Okundu</span>
                      </div>
                      <div class="book-action-btns">
                        <a href="kitap-oku.html?book=tevhid-muhafizlari&page=5" class="btn-book-action btn-book-continue">Devam Et</a>
                        <button type="button" class="btn-book-action btn-book-audio btn-listen-trigger"
                                data-book-id="tevhid-muhafizlari"
                                data-book-title="Tevhid Muhafızları"
                                data-book-chapter="1. Bölüm - Boş Damacana (Sayfa 5)"
                                data-book-img="assets/images/books/book-tevhid-muhafizlari.svg"
                                data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                                data-start-time="2.313"
                                data-start-page="5"
                                title="Sesli Dinle">
                          <i class="fa-solid fa-headphones"></i>
                          <span>Sesli Dinle</span>
                        </button>
                      </div>
                    </div>

                    <!-- Kitap Kartı 3: Gördüğüme Görmediğime -->
                    <div class="book-card-item" data-category="lise">
                      <div class="book-thumb-container">
                        <a href="kitap-oku.html?book=gordugume-gormedigime">
                          <img src="assets/images/books/book-gordugume-gormedigime.svg" alt="Gördüğüme Görmediğime">
                        </a>
                      </div>
                      <div class="book-item-title" title="Gördüğüme Görmediğime">Gördüğüme Görmediğime</div>
                      <div class="book-item-level">Lise Düzeyi</div>
                      <div class="book-progress-wrap">
                        <div class="progress-track-custom">
                          <div class="progress-fill-custom" style="width: 20%;"></div>
                        </div>
                        <span class="progress-text-badge">%20 Okundu</span>
                      </div>
                      <div class="book-action-btns">
                        <a href="kitap-oku.html?book=gordugume-gormedigime" class="btn-book-action btn-book-continue">Devam Et</a>
                        <button type="button" class="btn-book-action btn-book-audio btn-listen-trigger"
                                data-book-id="gordugume-gormedigime"
                                data-book-title="Gördüğüme Görmediğime"
                                data-book-chapter="Bölüm 1 - Giriş (Sayfa 1)"
                                data-book-img="assets/images/books/book-gordugume-gormedigime.svg"
                                data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                                data-start-time="2.313"
                                data-start-page="1"
                                title="Sesli Dinle">
                          <i class="fa-solid fa-headphones"></i>
                          <span>Sesli Dinle</span>
                        </button>
                      </div>
                    </div>

                    <!-- Kitap Kartı 4: Nasıl İnanmalı? -->
                    <div class="book-card-item" data-category="yetiskin">
                      <div class="book-thumb-container">
                        <a href="kitap-oku.html?book=nasil-inanmali">
                          <img src="assets/images/books/book-nasil-inanmali.svg" alt="Nasıl İnanmalı?">
                        </a>
                      </div>
                      <div class="book-item-title" title="Nasıl İnanmalı?">Nasıl İnanmalı?</div>
                      <div class="book-item-level">Yetişkin Düzeyi</div>
                      <div class="book-progress-wrap">
                        <div class="progress-track-custom">
                          <div class="progress-fill-custom" style="width: 40%;"></div>
                        </div>
                        <span class="progress-text-badge">%40 Okundu</span>
                      </div>
                      <div class="book-action-btns">
                        <a href="kitap-oku.html?book=nasil-inanmali" class="btn-book-action btn-book-continue">Devam Et</a>
                        <button type="button" class="btn-book-action btn-book-audio btn-listen-trigger"
                                data-book-id="nasil-inanmali"
                                data-book-title="Nasıl İnanmalı?"
                                data-book-chapter="Bölüm 1 - Temel İnançlar (Sayfa 1)"
                                data-book-img="assets/images/books/book-nasil-inanmali.svg"
                                data-audio-src="assets/audio/tevhid-muhafizlari.mp3"
                                data-start-time="2.313"
                                data-start-page="1"
                                title="Sesli Dinle">
                          <i class="fa-solid fa-headphones"></i>
                          <span>Sesli Dinle</span>
                        </button>
                      </div>
                    </div>

                  </div>

                  <button type="button" class="carousel-nav-btn next" id="nextBookBtn" title="Sonraki Kitaplar">
                    <i class="fa-solid fa-chevron-right"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Sesli Kitaplar Çalar Kartı (Kompakt / Dar Alan) -->
            <div class="col-xl-5 col-lg-5 col-md-12" id="audioPlayerSection">
              <div class="portal-section-card">
                <div class="section-header-row">
                  <h2 class="section-main-heading">Sesli Kitaplar</h2>
                  <a href="kitaplar.html" class="section-link-all">Tümünü Gör</a>
                </div>

                <div class="audio-player-component">
                  <!-- Albüm / Kitap Bilgisi -->
                  <div class="audio-track-header">
                    <div class="audio-album-thumb">
                      <img src="assets/images/books/book-tevhid-muhafizlari.svg" alt="Tevhid Muhafızları" id="currentAudioThumb">
                    </div>
                    <div class="audio-info-details">
                      <div class="audio-track-title" id="currentAudioTitle">Tevhid Muhafızları</div>
                      <div class="audio-track-chapter" id="currentAudioChapter">1. Bölüm - Boş Damacana (Sayfa 5)</div>
                    </div>
                  </div>

                  <!-- Canlı Senkronizasyon & Okuma Butonu Şeridi -->
                  <div class="audio-live-sync-wrap">
                    <div class="d-flex align-items-center gap-1 text-muted fs-8">
                      <i class="fa-solid fa-circle-play text-success"></i>
                      <span id="audioLivePageText">Şu an okunan: <strong class="text-dark">Sayfa 5</strong></span>
                    </div>
                    <a href="kitap-oku.html?book=tevhid-muhafizlari&page=5" id="btnOpenInReader" class="btn-open-in-reader" title="Kitap Okuma Sayfasında Aç">
                      <i class="fa-solid fa-book-open"></i>
                      <span>Kitapta Senkronize Aç</span>
                    </a>
                  </div>

                  <!-- Ses Dalga Görselleştiricisi (Waveform) -->
                  <div class="waveform-visualizer-container">
                    <div class="waveform-bars-wrap" id="waveformBars" title="Süreye Atlamak İçin Tıklayın"></div>
                    <div class="audio-timestamps">
                      <span id="audioCurrentTime">00:02</span>
                      <span id="audioDuration">03:53:14</span>
                    </div>
                  </div>

                  <!-- Ana Oynatıcı Kontrolleri (10s Geri, Oynat, 10s İleri) -->
                  <div class="audio-main-controls">
                    <button type="button" class="audio-control-btn" id="audioRewindBtn" title="10 Saniye Geri">
                      <i class="fa-solid fa-rotate-left"></i>
                      <span class="skip-seconds">10</span>
                    </button>

                    <button type="button" class="btn-play-master" id="playMasterBtn" title="Oynat / Duraklat">
                      <i class="fa-solid fa-play"></i>
                    </button>

                    <button type="button" class="audio-control-btn" id="audioForwardBtn" title="10 Saniye İleri">
                      <i class="fa-solid fa-rotate-right"></i>
                      <span class="skip-seconds">10</span>
                    </button>
                  </div>

                  <!-- Alt Araç Çubuğu (Hız, Uyku Zamanlayıcı, Bölüm Listesi) -->
                  <div class="audio-bottom-toolbar">
                    <button type="button" class="audio-tool-pill" id="audioSpeedBtn" title="Oynatma Hızı">
                      <strong>1.0x</strong> Hız
                    </button>

                    <button type="button" class="audio-tool-pill" id="sleepTimerBtn" title="Uyku Zamanlayıcı">
                      <i class="fa-solid fa-moon"></i>
                      <span>Uyku Zamanlayıcı</span>
                    </button>

                    <button type="button" class="audio-tool-pill" id="chapterListBtn" title="Bölüm Listesi">
                      <i class="fa-solid fa-list-ul"></i>
                      <span>Bölüm Listesi</span>
                    </button>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <!-- 5. Geçmiş Yıllar Arşivi -->
          <section class="portal-section-card mb-4">
            <div class="section-header-row">
              <h2 class="section-main-heading">Geçmiş Yıllar</h2>
              <a href="kitaplar.html?year=archive" class="section-link-all">Tümünü Gör</a>
            </div>

            <div class="archive-years-grid">
              
              <!-- 2024 -->
              <a href="kitaplar.html?year=2024" class="archive-year-card text-decoration-none">
                <div class="archive-card-left">
                  <div class="archive-year-num">2024</div>
                  <div class="archive-year-title">Ufka Yolculuk 12</div>
                  <div class="archive-book-count">8 Kitap</div>
                </div>
                <div class="archive-card-thumb">
                  <img src="assets/images/books/archive-2024.svg" alt="2024">
                </div>
              </a>

              <!-- 2023 -->
              <a href="kitaplar.html?year=2023" class="archive-year-card text-decoration-none">
                <div class="archive-card-left">
                  <div class="archive-year-num" style="color: #f59e0b;">2023</div>
                  <div class="archive-year-title">Ufka Yolculuk 11</div>
                  <div class="archive-book-count">8 Kitap</div>
                </div>
                <div class="archive-card-thumb">
                  <img src="assets/images/books/archive-2023.svg" alt="2023">
                </div>
              </a>

              <!-- 2022 -->
              <a href="kitaplar.html?year=2022" class="archive-year-card text-decoration-none">
                <div class="archive-card-left">
                  <div class="archive-year-num" style="color: #10b981;">2022</div>
                  <div class="archive-year-title">Ufka Yolculuk 10</div>
                  <div class="archive-book-count">8 Kitap</div>
                </div>
                <div class="archive-card-thumb">
                  <img src="assets/images/books/archive-2022.svg" alt="2022">
                </div>
              </a>

              <!-- 2021 -->
              <a href="kitaplar.html?year=2021" class="archive-year-card text-decoration-none">
                <div class="archive-card-left">
                  <div class="archive-year-num" style="color: #059669;">2021</div>
                  <div class="archive-year-title">Ufka Yolculuk 9</div>
                  <div class="archive-book-count">8 Kitap</div>
                </div>
                <div class="archive-card-thumb">
                  <img src="assets/images/books/archive-2021.svg" alt="2021">
                </div>
              </a>

              <!-- 2020 -->
              <a href="kitaplar.html?year=2020" class="archive-year-card text-decoration-none">
                <div class="archive-card-left">
                  <div class="archive-year-num" style="color: #0284c7;">2020</div>
                  <div class="archive-year-title">Ufka Yolculuk 8</div>
                  <div class="archive-book-count">8 Kitap</div>
                </div>
                <div class="archive-card-thumb">
                  <img src="assets/images/books/archive-2020.svg" alt="2020">
                </div>
              </a>

            </div>
          </section>

          <!-- 6. Alt Tanıtım Bannerı (Öğrenci İllüstrasyonu) -->
          <section class="bottom-promo-card">
            <div class="row align-items-center">
              <div class="col-auto d-none d-sm-block">
                <img src="assets/images/student-reading.svg" alt="Kitap Okuyan Öğrenci" class="promo-illustration-box">
              </div>
              <div class="col">
                <p class="promo-main-slogan mb-3">
                  Her gün düzenli oku, bilgini artır, <strong>hayatına değer kat!</strong>
                </p>
                <div class="promo-feature-list">
                  
                  <div class="promo-feature-point">
                    <i class="fa-solid fa-mobile-screen-button promo-point-icon"></i>
                    <div class="promo-point-text">
                      <div class="promo-point-title">İstediğin Yerde Oku</div>
                      <div class="promo-point-desc">Telefon, tablet, bilgisayar</div>
                    </div>
                  </div>

                  <div class="promo-feature-point">
                    <i class="fa-solid fa-clock-rotate-left promo-point-icon"></i>
                    <div class="promo-point-text">
                      <div class="promo-point-title">İlerlemeni Kaydet</div>
                      <div class="promo-point-desc">Kaldığın yerden devam et</div>
                    </div>
                  </div>

                  <div class="promo-feature-point">
                    <i class="fa-solid fa-headphones promo-point-icon"></i>
                    <div class="promo-point-text">
                      <div class="promo-point-title">Sesli Dinle</div>
                      <div class="promo-point-desc">Gözlerini dinlendir, sen öğrenmeye devam et</div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </section>

        </div>


        <!-- =====================================================================
             SAĞ SÜTUN (SIDEBAR): Profil, Hedef, İstatistikler, Etkinlikler, Mobil İndir
             ===================================================================== -->
        <div class="portal-sidebar-col">
          <div class="sidebar-sticky-wrap">
            
            <!-- 1. Kullanıcı Profil Kartı -->
            <div class="user-profile-card">
              <div class="user-header-info">
                <div class="user-avatar-large user-initial-avatar large" title="Ahmet Yılmaz">AY</div>
                <div class="user-text-info">
                  <div class="user-full-name">
                    <span>Ahmet Yılmaz</span>
                    <span class="user-badge-tag">Katılımcı</span>
                  </div>
                  <div class="user-sub-edition">Ufka Yolculuk 2025</div>
                </div>
              </div>

              <!-- 3'lü İstatistik Barı (Puanım, Sıralamam, Rozetlerim) -->
              <div class="user-stats-bar">
                <div class="user-stat-cell">
                  <div class="stat-cell-title">
                    <i class="fa-regular fa-user"></i>
                    <span>Puanım</span>
                  </div>
                  <div class="stat-cell-value">2.450</div>
                </div>

                <div class="user-stat-cell">
                  <div class="stat-cell-title">
                    <i class="fa-regular fa-id-badge"></i>
                    <span>Sıralamam</span>
                  </div>
                  <div class="stat-cell-value">1.245</div>
                </div>

                <div class="user-stat-cell">
                  <div class="stat-cell-title">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Rozetlerim</span>
                  </div>
                  <div class="stat-cell-value">
                    <span>8</span>
                    <i class="fa-solid fa-star star-icon ms-1"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- 2. Günlük Okuma Hedefi Kartı -->
            <div class="goal-progress-card">
              <div class="goal-card-header">
                <div class="goal-title-wrap">
                  <span class="goal-title-text">Günlük Okuma Hedefi</span>
                </div>
                <div class="target-icon-wrap" title="Hedef">
                  <i class="fa-solid fa-bullseye"></i>
                </div>
              </div>

              <div class="goal-fraction-text">300 / 600 dk</div>

              <div class="goal-progress-track">
                <div class="goal-progress-bar" style="width: 50%;"></div>
              </div>

              <p class="goal-encouragement">Harika! Hedefinin %50'sine ulaştın.</p>
            </div>

            <!-- 3. İstatistiklerim Kartı & Haftalık Grafik -->
            <div class="stats-overview-card">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="section-main-heading mb-0">İstatistiklerim</h3>
                <select class="stats-filter-select">
                  <option value="week">Bu Hafta</option>
                  <option value="month">Bu Ay</option>
                  <option value="all">Tüm Zamanlar</option>
                </select>
              </div>

              <!-- 2x2 Metrik Kutuları -->
              <div class="metrics-2x2-grid">
                
                <!-- Okunan Sayfa -->
                <div class="metric-box-item">
                  <div class="metric-item-icon blue">
                    <i class="fa-solid fa-tablet-screen-button"></i>
                  </div>
                  <div class="metric-content-wrap">
                    <div class="metric-label-text">Okuduğun Sayfa</div>
                    <div class="metric-value-row">
                      <span class="metric-number-bold">125</span>
                      <span class="metric-growth-pill">+18%</span>
                    </div>
                  </div>
                </div>

                <!-- Dinlenen Dakika -->
                <div class="metric-box-item">
                  <div class="metric-item-icon purple">
                    <i class="fa-solid fa-headphones"></i>
                  </div>
                  <div class="metric-content-wrap">
                    <div class="metric-label-text">Dinlenen Dakika</div>
                    <div class="metric-value-row">
                      <span class="metric-number-bold">245</span>
                      <span class="metric-growth-pill">+24%</span>
                    </div>
                  </div>
                </div>

                <!-- Tamamlanan Kitap -->
                <div class="metric-box-item">
                  <div class="metric-item-icon blue">
                    <i class="fa-solid fa-book-bookmark"></i>
                  </div>
                  <div class="metric-content-wrap">
                    <div class="metric-label-text">Tamamlanan Kitap</div>
                    <div class="metric-value-row">
                      <span class="metric-number-bold">2</span>
                      <span class="metric-growth-pill">+1</span>
                    </div>
                  </div>
                </div>

                <!-- Toplam Puan -->
                <div class="metric-box-item">
                  <div class="metric-item-icon gold">
                    <i class="fa-solid fa-trophy"></i>
                  </div>
                  <div class="metric-content-wrap">
                    <div class="metric-label-text">Toplam Puan</div>
                    <div class="metric-value-row">
                      <span class="metric-number-bold">2.450</span>
                      <span class="metric-growth-pill">+350</span>
                    </div>
                  </div>
                </div>

              </div>

              <!-- Haftalık Aktivite Grafiği (İnteraktif Bezier Spline SVG) -->
              <div class="chart-container-wrap">
                <div class="chart-tooltip-popup" id="chartTooltip"></div>
                <svg class="activity-svg-chart" viewBox="0 0 380 120">
                  <!-- Yatay Izgara Çizgileri -->
                  <line x1="40" y1="20" x2="360" y2="20" class="chart-grid-line"/>
                  <text x="15" y="23" class="chart-axis-text">600</text>

                  <line x1="40" y1="45" x2="360" y2="45" class="chart-grid-line"/>
                  <text x="15" y="48" class="chart-axis-text">450</text>

                  <line x1="40" y1="70" x2="360" y2="70" class="chart-grid-line"/>
                  <text x="15" y="73" class="chart-axis-text">300</text>

                  <line x1="40" y1="95" x2="360" y2="95" class="chart-grid-line"/>
                  <text x="15" y="98" class="chart-axis-text">150</text>

                  <line x1="40" y1="115" x2="360" y2="115" class="chart-grid-line"/>
                  <text x="25" y="118" class="chart-axis-text">0</text>

                  <!-- Spline Eğrisi (Pzt-Paz) -->
                  <!-- Points: (50,75), (100,50), (150,68), (200,25), (250,52), (300,35), (350,15) -->
                  <path d="M 50 75 C 75 75, 75 50, 100 50 C 125 50, 125 68, 150 68 C 175 68, 175 25, 200 25 C 225 25, 225 52, 250 52 C 275 52, 275 35, 300 35 C 325 35, 325 15, 350 15" class="chart-spline-path"/>

                  <!-- Veri Noktaları -->
                  <circle cx="50" cy="75" class="chart-dot-marker" data-index="0"></circle>
                  <circle cx="100" cy="50" class="chart-dot-marker" data-index="1"></circle>
                  <circle cx="150" cy="68" class="chart-dot-marker" data-index="2"></circle>
                  <circle cx="200" cy="25" class="chart-dot-marker" data-index="3"></circle>
                  <circle cx="250" cy="52" class="chart-dot-marker" data-index="4"></circle>
                  <circle cx="300" cy="35" class="chart-dot-marker" data-index="5"></circle>
                  <circle cx="350" cy="15" class="chart-dot-marker" data-index="6"></circle>

                  <!-- Gün Etiketleri -->
                  <text x="50" y="115" class="chart-axis-text" text-anchor="middle">Pzt</text>
                  <text x="100" y="115" class="chart-axis-text" text-anchor="middle">Sal</text>
                  <text x="150" y="115" class="chart-axis-text" text-anchor="middle">Çar</text>
                  <text x="200" y="115" class="chart-axis-text" text-anchor="middle">Per</text>
                  <text x="250" y="115" class="chart-axis-text" text-anchor="middle">Cum</text>
                  <text x="300" y="115" class="chart-axis-text" text-anchor="middle">Cmt</text>
                  <text x="350" y="115" class="chart-axis-text" text-anchor="middle">Paz</text>
                </svg>
              </div>
            </div>

            <!-- 4. Yaklaşan Etkinlikler Kartı -->
            <div class="events-list-card">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="section-main-heading mb-0">Yaklaşan Etkinlikler</h3>
                <a href="#" class="section-link-all">Tümünü Gör</a>
              </div>

              <div class="events-items-group">
                
                <!-- Etkinlik 1: Online Deneme Sınavı -->
                <div class="event-entry-item">
                  <div class="event-left-details">
                    <div class="event-icon-circle blue">
                      <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="event-info-text">
                      <div class="event-title-name">Online Deneme Sınavı</div>
                      <div class="event-datetime-sub">20 Mayıs 2025 - 20:00</div>
                    </div>
                  </div>
                  <div class="event-countdown-badge">
                    <span class="countdown-day-count">2</span>
                    <span class="countdown-day-label">Gün kaldı</span>
                  </div>
                </div>

                <!-- Etkinlik 2: Bilgi Yarışması -->
                <div class="event-entry-item">
                  <div class="event-left-details">
                    <div class="event-icon-circle red">
                      <i class="fa-solid fa-clipboard-question"></i>
                    </div>
                    <div class="event-info-text">
                      <div class="event-title-name">Bilgi Yarışması</div>
                      <div class="event-datetime-sub">25 Mayıs 2025 - 14:00</div>
                    </div>
                  </div>
                  <div class="event-countdown-badge">
                    <span class="countdown-day-count">7</span>
                    <span class="countdown-day-label">Gün kaldı</span>
                  </div>
                </div>

                <!-- Etkinlik 3: Son Başvuru Tarihi -->
                <div class="event-entry-item">
                  <div class="event-left-details">
                    <div class="event-icon-circle orange">
                      <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="event-info-text">
                      <div class="event-title-name">Son Başvuru Tarihi</div>
                      <div class="event-datetime-sub">31 Mayıs 2025 - 23:59</div>
                    </div>
                  </div>
                  <div class="event-countdown-badge">
                    <span class="countdown-day-count">13</span>
                    <span class="countdown-day-label">Gün kaldı</span>
                  </div>
                </div>

              </div>
            </div>

            <!-- 5. Mobil Uygulama İndir Kartı -->
            <div class="app-download-banner">
              <div class="app-banner-title">Ufka Yolculuk mobil uygulamasını indir!</div>
              <div class="app-buttons-group">
                
                <!-- App Store -->
                <a href="#" class="app-store-btn" title="App Store'dan İndir">
                  <svg class="store-badge-icon apple-icon" viewBox="0 0 170 170" width="22" height="22">
                    <path fill="#ffffff" d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.69-3.08-7.73-7.94-12.11-14.58-6.19-9.35-11.08-19.82-14.67-31.4-3.59-11.58-5.39-22.61-5.39-33.09 0-14.94 3.86-27.17 11.58-36.68 7.72-9.52 17.37-14.39 28.96-14.62 4.46 0 9.45 1.13 14.96 3.39 5.51 2.26 9.41 3.44 11.69 3.54 1.95 0 6.04-1.28 12.26-3.83 6.22-2.56 11.59-3.72 16.12-3.49 12.03.8 21.68 5.67 28.96 14.62-10.74 6.52-16.01 15.52-15.82 27 .22 9.02 3.65 16.58 10.3 22.68 6.64 6.1 14.56 9.54 23.75 10.33-2.17 6.42-4.8 12.82-7.88 19.2zm-28.74-106.6c0 6.62-2.52 12.92-7.55 17.89-5.04 4.97-11.16 7.84-18.36 8.62-.12-.91-.18-1.77-.18-2.58 0-6.4 2.65-12.82 7.95-18.25 5.3-5.43 11.75-8.52 19.34-9.27.13 1.2.2 2.06.2 2.59z"/>
                  </svg>
                  <div class="app-btn-texts">
                    <span class="app-btn-small">App Store'dan</span>
                    <span class="app-btn-strong">İndirin</span>
                  </div>
                </a>

                <!-- Google Play -->
                <a href="#" class="app-store-btn" title="Google Play'den Alın">
                  <svg class="store-badge-icon gplay-icon" viewBox="0 0 512 512" width="20" height="20">
                    <path fill="#00C3FF" d="M38.5 28.5c-3.7 4.1-5.9 10.3-5.9 18.2v418.6c0 7.9 2.2 14.1 5.9 18.2l1.3 1.2L262.3 262.2v-4.4L39.8 27.3l-1.3 1.2z"/>
                    <path fill="#00E676" d="M336.8 336.7l-74.5-74.5v-4.4l74.5-74.5 1.7.9 88.3 50.2c25.2 14.3 25.2 37.8 0 52.2l-88.3 50.1-1.7.9z"/>
                    <path fill="#FF3D00" d="M338.5 335.8L262.3 259.6 38.5 484.7c8.3 8.8 22.1 9.9 37.6 1.1l262.4-150z"/>
                    <path fill="#FFC107" d="M338.5 176.2L76.1 26.2c-15.5-8.8-29.3-7.7-37.6 1.1l223.8 225.1 76.2-76.2z"/>
                  </svg>
                  <div class="app-btn-texts">
                    <span class="app-btn-small">Google Play</span>
                    <span class="app-btn-strong">DEN ALIN</span>
                  </div>
                </a>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- =========================================================================
       Modallar ve Açılır Pencereler
       ========================================================================= -->

  <!-- Uyku Zamanlayıcı Modalı -->
  <div class="custom-modal-backdrop" id="sleepTimerModal">
    <div class="custom-modal-card">
      <div class="modal-header-custom">
        <h4 class="modal-title-custom">Uyku Zamanlayıcı</h4>
        <button type="button" class="modal-close-btn" id="closeSleepModal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <p class="text-muted small mb-3">Sesli kitap oynatımı belirlenen süre sonunda otomatik olarak duraklatılır.</p>
      <div class="d-grid gap-2">
        <button type="button" class="btn btn-outline-primary timer-opt-btn" data-time="15">15 Dakika</button>
        <button type="button" class="btn btn-outline-primary timer-opt-btn" data-time="30">30 Dakika</button>
        <button type="button" class="btn btn-outline-primary timer-opt-btn" data-time="45">45 Dakika</button>
        <button type="button" class="btn btn-outline-primary timer-opt-btn" data-time="60">60 Dakika</button>
        <button type="button" class="btn btn-outline-primary timer-opt-btn" data-time="Bölüm Sonu">Bölüm Bitince Kapat</button>
      </div>
    </div>
  </div>

  <!-- Bölüm Listesi Modalı -->
  <div class="custom-modal-backdrop" id="chapterListModal">
    <div class="custom-modal-card">
      <div class="modal-header-custom">
        <h4 class="modal-title-custom">Bölüm Listesi</h4>
        <button type="button" class="modal-close-btn" id="closeChapterModal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div class="chapter-list-wrap">
        <div class="chapter-item-row active" data-title="1. Bölüm - Boş Damacana (Sayfa 5)" data-start-time="2.313" data-page="5">
          <span>1. Boş Damacana (Sayfa 5)</span>
          <span class="text-muted small">00:02</span>
        </div>
        <div class="chapter-item-row" data-title="2. Bölüm - Açlık ve Emniyet (Sayfa 10)" data-start-time="379.95" data-page="10">
          <span>2. Açlık ve Emniyet (Sayfa 10)</span>
          <span class="text-muted small">06:20</span>
        </div>
        <div class="chapter-item-row" data-title="3. Bölüm - Tevekkül Notu (Sayfa 20)" data-start-time="1228.72" data-page="20">
          <span>3. Tevekkül Notu (Sayfa 20)</span>
          <span class="text-muted small">20:28</span>
        </div>
        <div class="chapter-item-row" data-title="4. Bölüm - Peygamber Sevgisi (Sayfa 35)" data-start-time="2394.5" data-page="35">
          <span>4. Peygamber Sevgisi (Sayfa 35)</span>
          <span class="text-muted small">39:54</span>
        </div>
        <div class="chapter-item-row" data-title="5. Bölüm - İmanın Tadı (Sayfa 50)" data-start-time="3481.4" data-page="50">
          <span>5. İmanın Tadı (Sayfa 50)</span>
          <span class="text-muted small">58:01</span>
        </div>
        <div class="chapter-item-row" data-title="6. Bölüm - İmtihan ve Sabır (Sayfa 70)" data-start-time="5047.7" data-page="70">
          <span>6. İmtihan ve Sabır (Sayfa 70)</span>
          <span class="text-muted small">01:24:07</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobil Menü Çekmecesi -->
  <div class="custom-modal-backdrop" id="mobileNavDrawer">
    <div class="custom-modal-card" style="margin-top: 0; align-self: flex-start; border-radius: 0 0 20px 20px;">
      <div class="modal-header-custom">
        <img src="assets/images/logo.png" alt="Ufka Yolculuk" style="height: 32px;">
        <button type="button" class="modal-close-btn" id="closeMobileNav">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <ul class="nav flex-column gap-2 mt-3">
        <li class="nav-item">
          <a class="nav-link text-primary fw-bold" href="home.html"><i class="fa-solid fa-house me-2"></i> Anasayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="kitaplar.html"><i class="fa-solid fa-book-open me-2"></i> Yarışma Kitapları</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="kitaplar.html?year=archive"><i class="fa-solid fa-layer-group me-2"></i> Geçmiş Yıllar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="kitap-oku.html?book=tevhid-muhafizlari&page=5"><i class="fa-solid fa-headphones me-2"></i> Sesli Kitap Oku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="dashboard.html"><i class="fa-solid fa-chart-pie me-2"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="index.html"><i class="fa-solid fa-layer-group me-2"></i> Tüm Sayfalar (Sunum)</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- JavaScript Dosyaları (Yerel Bootstrap JS ve Saf JS) -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/header-search.js?v=4.0"></script>
  <script src="assets/js/main.js?v=4.0"></script>
</body>
</html>
