<?php
$request = service('request');
$uri = service('uri');
$currentPath = trim($uri->getPath(), '/');
?>
  <!-- =========================================================================
       Üst Navigasyon Menüsü (Header / Navbar)
       ========================================================================= -->
  <header class="portal-navbar">
    <div class="container-portal">
      <div class="d-flex align-items-center justify-content-between">
        
        <!-- Sol: Logo -->
        <a href="<?= base_url('/') ?>" class="brand-logo-wrap" title="Ufka Yolculuk Anasayfa">
          <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk Logo" class="brand-logo-img">
        </a>

        <!-- Orta: Ana Menü Linkleri -->
        <nav class="d-none d-lg-block">
          <ul class="nav-menu-list">
            <li class="nav-menu-item">
              <a href="<?= base_url('/') ?>" class="nav-link-custom <?= ($currentPath === '' || $currentPath === 'home') ? 'active' : '' ?>">
                <i class="fa-solid fa-house"></i>
                <span>Anasayfa</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('kitaplar') ?>" class="nav-link-custom <?= (str_starts_with($currentPath, 'kitaplar') && !str_contains($currentPath, 'archive')) ? 'active' : '' ?>">
                <i class="fa-solid fa-book-open"></i>
                <span>Yarışma Kitapları</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('kitaplar?year=archive') ?>" class="nav-link-custom">
                <i class="fa-solid fa-layer-group"></i>
                <span>Geçmiş Yıllar</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('kitap-oku?book=tevhid-muhafizlari&page=5') ?>" class="nav-link-custom <?= (str_starts_with($currentPath, 'kitap-oku') || str_starts_with($currentPath, 'kitapoku')) ? 'active' : '' ?>">
                <i class="fa-solid fa-headphones"></i>
                <span>Sesli Kitap Oku</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('deneme-sinavlari') ?>" class="nav-link-custom <?= str_starts_with($currentPath, 'deneme-sinavlari') ? 'active' : '' ?>">
                <i class="fa-solid fa-laptop-code text-primary"></i>
                <span>Deneme Sınavları</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('siralamalar') ?>" class="nav-link-custom <?= str_starts_with($currentPath, 'siralamalar') ? 'active' : '' ?>">
                <i class="fa-solid fa-trophy text-warning"></i>
                <span>Sıralamalar</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('dashboard') ?>" class="nav-link-custom <?= str_starts_with($currentPath, 'dashboard') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="nav-menu-item">
              <a href="<?= base_url('/') ?>" class="nav-link-custom text-warning">
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
                  <div class="profile-popover-email">ahmet.yilmaz@okuma.tkmdev.com</div>
                  <span class="badge bg-primary-subtle text-primary rounded-pill mt-1" style="font-size: 0.65rem; font-weight: 700; padding: 0.2rem 0.55rem;">Katılımcı (2025)</span>
                </div>
              </div>

              <div class="popover-divider"></div>

              <div class="profile-popover-menu-list">
                <a href="<?= base_url('dashboard') ?>" class="profile-menu-item <?= str_starts_with($currentPath, 'dashboard') ? 'active' : '' ?>">
                  <i class="fa-solid fa-chart-pie menu-icon text-primary"></i>
                  <span>İstatistiklerim & Dashboard</span>
                </a>
                <a href="<?= base_url('dashboard#rozetler') ?>" class="profile-menu-item">
                  <i class="fa-solid fa-trophy menu-icon text-warning"></i>
                  <span>Puanlarım & Rozetlerim</span>
                  <span class="badge bg-warning-subtle text-dark ms-auto" style="font-size: 0.68rem; font-weight: 700;">2.450 P</span>
                </a>
                <a href="<?= base_url('kitaplar') ?>" class="profile-menu-item <?= str_starts_with($currentPath, 'kitaplar') ? 'active' : '' ?>">
                  <i class="fa-solid fa-bookmark menu-icon text-primary"></i>
                  <span>Yarışma Kitapları</span>
                </a>
                <a href="<?= base_url('siralamalar') ?>" class="profile-menu-item <?= str_starts_with($currentPath, 'siralamalar') ? 'active' : '' ?>">
                  <i class="fa-solid fa-trophy menu-icon text-warning"></i>
                  <span>Başarı Sıralamaları</span>
                </a>
                <a href="<?= base_url('/') ?>" class="profile-menu-item">
                  <i class="fa-solid fa-layer-group menu-icon text-info"></i>
                  <span>Tüm Sayfalar (Sunum)</span>
                </a>
              </div>

              <div class="popover-divider"></div>

              <a href="<?= base_url('auth/logout') ?>" class="profile-menu-item logout-item text-danger">
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
