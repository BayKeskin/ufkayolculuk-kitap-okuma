<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sayfa Şablonu - Ufka Yolculuk</title>
  <meta name="description" content="Ufka Yolculuk kurumsal ve genel içerik sayfası şablonu.">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS (Yerel) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome 6 Pro/Free (Yerel) -->
  <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">

  <!-- Ana Portal Stili & İçerik Şablonu Stili -->
  <link rel="stylesheet" href="assets/css/style.css?v=3.0">
  <link rel="stylesheet" href="assets/css/content.css?v=1.0">
</head>
<body class="content-page-body">

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
              <a href="dashboard.html" class="nav-link-custom">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="sayfa.html" class="nav-link-custom active">
                <i class="fa-solid fa-file-lines"></i>
                <span>Kurumsal</span>
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

        <!-- Sağ: Bildirim & Kullanıcı Profil Menüsü -->
        <div class="nav-actions">
          <!-- Bildirimler Butonu -->
          <div class="nav-dropdown-wrapper" id="notifDropdownWrap">
            <button type="button" class="icon-action-btn" id="notificationBtn" title="Bildirimler" aria-expanded="false">
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
                  <div class="notif-item-icon bg-primary-subtle text-primary"><i class="fa-solid fa-headphones"></i></div>
                  <div class="notif-item-content">
                    <div class="notif-item-title">Yeni Sesli Kitap Eklendi</div>
                    <div class="notif-item-text">"Nasıl İnanmalı?" sesli dinleme bölümü aktif edildi.</div>
                    <div class="notif-item-time"><i class="fa-regular fa-clock me-1"></i>10 dakika önce</div>
                  </div>
                  <div class="notif-unread-dot"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Kullanıcı Profil Dropdown -->
          <div class="nav-dropdown-wrapper" id="userProfileDropdownWrap">
            <button type="button" class="user-nav-dropdown cursor-pointer" id="userNavDropdownBtn" title="Kullanıcı Menüsü" aria-expanded="false">
              <div class="user-initial-avatar" title="Ahmet Yılmaz">AY</div>
              <div class="user-nav-text d-none d-sm-block">
                <span class="user-nav-greeting">Merhaba,</span>
                <span class="user-nav-name">Ahmet Yılmaz</span>
              </div>
              <i class="fa-solid fa-chevron-down user-nav-chevron ms-1 d-none d-sm-inline-block"></i>
            </button>

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
                <a href="dashboard.html" class="profile-menu-item"><i class="fa-solid fa-chart-pie menu-icon text-primary"></i><span>Dashboard</span></a>
                <a href="kitaplar.html" class="profile-menu-item"><i class="fa-solid fa-bookmark menu-icon text-primary"></i><span>Yarışma Kitapları</span></a>
                <a href="index.html" class="profile-menu-item"><i class="fa-solid fa-layer-group menu-icon text-info"></i><span>Sayfalar (Sunum)</span></a>
              </div>
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
       Ana İçerik Bölümü
       ========================================================================= -->
  <main class="py-3">
    <div class="container-portal">
      
      <!-- 1. Breadcrumb Yol Haritası -->
      <nav class="content-breadcrumb-nav" aria-label="Breadcrumb">
        <ul class="content-breadcrumb">
          <li><a href="home.html"><i class="fa-solid fa-house me-1"></i> Anasayfa</a></li>
          <li class="breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
          <li><a href="#">Kurumsal</a></li>
          <li class="breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
          <li class="active-crumb">Hakkımızda & Genel Sayfa Şablonu</li>
        </ul>
      </nav>

      <!-- 2. Sayfa Başlık Hero Bannerı -->
      <section class="content-hero-card">
        <div class="content-hero-category">
          <i class="fa-solid fa-layer-group"></i>
          <span>Kurumsal & Genel Bilgi</span>
        </div>
        <h1 class="content-hero-title">Ufka Yolculuk Hakkında</h1>
        <p class="content-hero-subtitle">
          Doğru inanç ve güzel ahlakı merkeze alan, 13 yıldır milyonlarca okura ulaşan Türkiye’nin en kapsamlı kitap okuma yarışması platformu.
        </p>

        <div class="content-meta-bar">
          <div class="content-meta-item">
            <i class="fa-regular fa-calendar-check"></i>
            <span>Son Güncelleme: <strong>28 Ağustos 2025</strong></span>
          </div>
          <div class="content-meta-item">
            <i class="fa-regular fa-clock"></i>
            <span>Tahmini Okuma: <strong>4 Dakika</strong></span>
          </div>
          <div class="content-meta-item">
            <i class="fa-solid fa-shield-halved text-success"></i>
            <span>Resmi Bilgilendirme Metni</span>
          </div>
        </div>
      </section>

      <!-- 3. İki Sütunlu Sayfa Düzeni (Sol: CMS İçerik Alanı, Sağ: Kurumsal Yan Menü) -->
      <div class="row g-4">
        
        <!-- Sol: Admin Panelden Gelecek Zengin İçerik Alanı (.cms-content) -->
        <div class="col-lg-8">
          <article class="content-main-card">
            
            <div class="cms-content">
              
              <p>
                <strong>Ufka Yolculuk Bilgi ve Kültür Yarışmaları</strong>, Server Yaşam Vakfı bünyesinde her yıl belirlenen özel bir tema ve uzman akademisyenlerce hazırlanan özgün eserlerle düzenlenen, Türkiye’nin ve dünyanın dört bir yanından her yaştan katılımcıyı kitap okumaya teşvik eden uluslararası bir kültür hareketidir.
              </p>

              <div class="cms-callout info">
                <i class="fa-solid fa-circle-info"></i>
                <div>
                  <strong>Bilgi & Katılım Notu:</strong> 13. Ufka Yolculuk Bilgi ve Kültür Yarışması kapsamında bu yıl "İnanç ve Değerler" teması işlenmekte olup, yarışma ilkokul, ortaokul, lise ve yetişkin olmak üzere 4 farklı kategoride eş zamanlı yürütülmektedir.
                </div>
              </div>

              <h2>1. Vizyonumuz ve Misyonumuz</h2>
              <p>
                Okuma alışkanlığını toplumun tüm kesimlerine yaygınlaştırmak; katılımcıların eleştirel düşünme, anlama, yorumlama ve doğru bilgiye ulaşma becerilerini geliştirmektir. Yarışmamız yalnızca bir sınav değil, aynı zamanda aile içinde ve okullarda kitap okuma bilincini canlı tutan bir eğitim ve kültür sürecidir.
              </p>

              <h3>Temel İlkelerimiz</h3>
              <ul>
                <li><strong>Doğru Kaynak ve Güvenilir Bilgi:</strong> Eserlerimiz alanında yetkin pedagog, ilahiyatçı ve akademisyenlerin titiz incelemelerinden geçerek hazırlanır.</li>
                <li><strong>Fırsat Eşitliği:</strong> Türkiye'nin 81 ilinde ve cezaevlerinde yer alan okurlar dahil herkesin yarışmaya eşit koşullarda ve ücretsiz erişimi sağlanır.</li>
                <li><strong>Dijital Entegrasyon:</strong> Sesli kitap dinleme, online deneme sınavları ve interaktif okuyucu motoru ile modern teknolojinin imkanları sunulur.</li>
              </ul>

              <blockquote>
                "Kitap okumak, zihni aydınlatan ve kalbi diri tutan en kıymetli yolculuktur."
                <cite>— Ufka Yolculuk Yarışma Kurulu</cite>
              </blockquote>

              <h2>2. Yarışma Düzeyleri ve Kitap Dağılımı</h2>
              <p>
                Aşağıdaki tabloda her yaş grubuna özel hazırlanan 2025 yılı yarışma kitapları ve sayfa detayları yer almaktadır:
              </p>

              <!-- Responsive CMS Tablosu -->
              <div class="cms-table-wrapper">
                <table class="cms-table">
                  <thead>
                    <tr>
                      <th>Kategori</th>
                      <th>Kitap Adı</th>
                      <th>Sayfa Sayısı</th>
                      <th>Sesli Dinleme</th>
                      <th>Sınav Türü</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><span class="badge bg-primary-subtle text-primary fw-bold">İlkokul</span></td>
                      <td><strong>Kuşların Çağrısı</strong></td>
                      <td>160 Sayfa</td>
                      <td><i class="fa-solid fa-check text-success me-1"></i>Mevcut (2s 15dk)</td>
                      <td>Online / Çoktan Seçmeli</td>
                    </tr>
                    <tr>
                      <td><span class="badge bg-success-subtle text-success fw-bold">Ortaokul</span></td>
                      <td><strong>Tevhid Muhafızları</strong></td>
                      <td>185 Sayfa</td>
                      <td><i class="fa-solid fa-check text-success me-1"></i>Mevcut (3s 53dk)</td>
                      <td>Online / Çoktan Seçmeli</td>
                    </tr>
                    <tr>
                      <td><span class="badge bg-warning-subtle text-dark fw-bold">Lise</span></td>
                      <td><strong>Gördüğüme Görmediğime</strong></td>
                      <td>190 Sayfa</td>
                      <td><i class="fa-solid fa-check text-success me-1"></i>Mevcut (3s 10dk)</td>
                      <td>Online / Çoktan Seçmeli</td>
                    </tr>
                    <tr>
                      <td><span class="badge bg-purple-subtle text-primary fw-bold" style="background: #f3e8ff; color: #7e22ce;">Yetişkin</span></td>
                      <td><strong>Nasıl İnanmalı?</strong></td>
                      <td>210 Sayfa</td>
                      <td><i class="fa-solid fa-check text-success me-1"></i>Mevcut (4s 05dk)</td>
                      <td>Online / Çoktan Seçmeli</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <h2>3. Ödüller ve Değerlendirme Süreci</h2>
              <p>
                Merkezi online sınav sonucunda Türkiye geneli ve il bazlı dereceye giren yarışmacılara umre ödülü, dizüstü bilgisayarlar, tabletler, bisikletler ve çeşitli burs destekleri takdim edilmektedir.
              </p>

              <div class="cms-callout success">
                <i class="fa-solid fa-trophy"></i>
                <div>
                  <strong>Ödül Duyurusu:</strong> Türkiye derecesi elde eden katılımcılara toplam 2.500.000 TL değerinde ödül ve eğitim bursu dağıtılacaktır.
                </div>
              </div>

              <!-- Paylaşım & İndirme Butonları -->
              <div class="content-footer-actions">
                <div class="d-flex align-items-center gap-2">
                  <button type="button" class="btn-print-page" onclick="window.print()">
                    <i class="fa-solid fa-print"></i>
                    <span>Sayfayı Yazdır</span>
                  </button>
                  <a href="#" class="btn-download-pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>PDF Olarak İndir</span>
                  </a>
                </div>

                <div class="d-flex align-items-center gap-2 text-muted fs-8">
                  <span>Paylaş:</span>
                  <a href="#" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-whatsapp text-success"></i></a>
                  <a href="#" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-x-twitter text-dark"></i></a>
                  <a href="#" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;"><i class="fa-brands fa-facebook text-primary"></i></a>
                </div>
              </div>

            </div>

          </article>
        </div>

        <!-- Sağ: Kurumsal & Yasal Sayfalar Yan Menüsü -->
        <div class="col-lg-4">
          <aside class="content-sidebar-card">
            <h3 class="sidebar-menu-heading">
              <i class="fa-solid fa-folder-open text-primary"></i>
              <span>Kurumsal & Yasal</span>
            </h3>

            <nav class="content-sidebar-nav">
              <a href="sayfa.html" class="sidebar-nav-link active">
                <span>Hakkımızda</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>Yarışma Şartnamesi (2025)</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>Kullanıcı Sözleşmesi</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>Gizlilik ve Güvenlik Politikası</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>KVKK Aydınlatma Metni</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>Çerez (Cookie) Politikası</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>Sıkça Sorulan Sorular (SSS)</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
              <a href="#" class="sidebar-nav-link">
                <span>İletişim & Destek</span>
                <i class="fa-solid fa-chevron-right fs-9"></i>
              </a>
            </nav>
          </aside>

          <!-- Yardım / Danışma Kartı -->
          <div class="p-4 bg-white rounded-4 border shadow-sm">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                <i class="fa-solid fa-headset"></i>
              </div>
              <div>
                <h4 class="fs-7 fw-bold text-dark mb-0">Yardıma mı ihtiyacınız var?</h4>
                <span class="fs-8 text-muted">Hafta içi 09:00 - 18:00</span>
              </div>
            </div>
            <p class="fs-8 text-muted mb-3">Yarışma kuralları ve portal kullanımıyla ilgili sorularınız için bize ulaşabilirsiniz.</p>
            <a href="mailto:destek@ufkayolculuk.com" class="btn btn-outline-primary btn-sm w-100 fw-bold rounded-pill">
              <i class="fa-solid fa-envelope me-1"></i> destek@ufkayolculuk.com
            </a>
          </div>
        </div>

      </div>

    </div>
  </main>

  <!-- =========================================================================
       Portal Alt Bilgi (Footer)
       ========================================================================= -->
  <footer class="portal-footer py-4 mt-5 border-top bg-white">
    <div class="container-portal">
      <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 text-muted fs-8">
        <div class="d-flex align-items-center gap-2">
          <img src="assets/images/logo.png" alt="Ufka Yolculuk" height="26">
          <span>© 2025 Ufka Yolculuk Bilgi ve Kültür Yarışması. Tüm hakları saklıdır.</span>
        </div>
        <div class="d-flex align-items-center gap-4">
          <a href="home.html" class="text-decoration-none text-muted">Anasayfa</a>
          <a href="kitaplar.html" class="text-decoration-none text-muted">Yarışma Kitapları</a>
          <a href="sayfa.html" class="text-decoration-none text-primary fw-bold">Hakkımızda</a>
          <a href="dashboard.html" class="text-decoration-none text-muted">Dashboard</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS (Yerel) -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
