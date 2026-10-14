  <!-- =========================================================================
       Portal Alt Bilgi (Footer)
       ========================================================================= -->
  <footer class="portal-footer py-4 mt-5 border-top bg-white">
    <div class="container-portal">
      <div class="row g-4 align-items-center mb-3">
        <!-- Sol: Logo ve Telif -->
        <div class="col-lg-6 col-md-12 text-center text-lg-start">
          <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 mb-2">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk" height="30">
            <span class="fw-bold text-dark fs-7">Ufka Yolculuk Bilgi ve Kültür Yarışması</span>
          </div>
          <p class="text-muted fs-8 mb-0">
            © 2025 Server Yaşam Vakfı. Tüm hakları saklıdır. Ufka Yolculuk Kitap Okuma ve Sesli Dinleme Portalı.
          </p>
        </div>

        <!-- Sağ: Hızlı Bağlantılar -->
        <div class="col-lg-6 col-md-12">
          <ul class="nav justify-content-center justify-content-lg-end gap-3 fs-8">
            <li class="nav-item">
              <a href="<?= base_url('/') ?>" class="nav-link text-muted p-0">Anasayfa</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('kitaplar') ?>" class="nav-link text-muted p-0">Yarışma Kitapları</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('deneme-sinavlari') ?>" class="nav-link text-muted p-0">Deneme Sınavları</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('siralamalar') ?>" class="nav-link text-muted p-0">Sıralamalar</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('sayfa/hakkimizda') ?>" class="nav-link text-muted p-0">Hakkımızda</a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('sayfa/sss') ?>" class="nav-link text-muted p-0">Sıkça Sorulan Sorular</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
