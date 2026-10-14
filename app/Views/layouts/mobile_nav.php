  <!-- Mobil Menü Çekmecesi (Drawer) -->
  <div class="custom-modal-backdrop" id="mobileNavDrawer">
    <div class="custom-modal-card" style="margin-top: 0; align-self: flex-start; border-radius: 0 0 20px 20px;">
      <div class="modal-header-custom">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk" style="height: 32px;">
        <button type="button" class="modal-close-btn" id="closeMobileNav">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <ul class="nav flex-column gap-2 mt-3">
        <li class="nav-item">
          <a class="nav-link text-primary fw-bold" href="<?= base_url('/') ?>"><i class="fa-solid fa-house me-2"></i> Anasayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('kitaplar') ?>"><i class="fa-solid fa-book-open me-2"></i> Yarışma Kitapları</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('kitaplar?year=archive') ?>"><i class="fa-solid fa-layer-group me-2"></i> Geçmiş Yıllar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('kitap-oku?book=tevhid-muhafizlari&page=5') ?>"><i class="fa-solid fa-headphones me-2"></i> Sesli Kitap Oku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('deneme-sinavlari') ?>"><i class="fa-solid fa-laptop-code me-2 text-primary"></i> Deneme Sınavları</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('siralamalar') ?>"><i class="fa-solid fa-trophy me-2 text-warning"></i> Sıralamalar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('dashboard') ?>"><i class="fa-solid fa-chart-pie me-2"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?= base_url('/') ?>"><i class="fa-solid fa-layer-group me-2"></i> Tüm Sayfalar (Sunum)</a>
        </li>
      </ul>
    </div>
  </div>
