<?php
$pageTitle = !empty($page['title']) ? esc($page['title']) : 'Kurumsal Bilgi';
$pageDesc  = !empty($page['description']) ? esc($page['description']) : 'Ufka Yolculuk kurumsal ve genel içerik sayfası.';
$pageCat   = !empty($page['category_title']) ? esc($page['category_title']) : 'Kurumsal & Genel Bilgi';
$pageTime  = !empty($page['publish_time']) ? esc($page['publish_time']) : date('d.m.Y');
$readTime  = !empty($page['read_time_minutes']) ? (int)$page['read_time_minutes'] : 4;
$bodyHtml  = !empty($page['formatted_body']) ? $page['formatted_body'] : (!empty($page['body']) ? $page['body'] : '');

$userLoggedIn = !empty($currentUser);
$userName     = $userLoggedIn ? esc($currentUser['name'] ?? 'Yarışmacı') : 'Giriş Yap';
$userInitials = 'AY';
if ($userLoggedIn && !empty($currentUser['name'])) {
    $parts = explode(' ', trim($currentUser['name']));
    $userInitials = mb_strtoupper(mb_substr($parts[0], 0, 1) . (count($parts) > 1 ? mb_substr(end($parts), 0, 1) : ''));
}
$userScore = $currentUser['general_score'] ?? '85.5';
$userCat   = $currentUser['category_title'] ?? 'Katılımcı (2025)';
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
  <link rel="stylesheet" href="<?= base_url('assets/css/content.css?v=1.1') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="py-3">
    <div class="container-portal">
      
      <!-- 1. Breadcrumb Yol Haritası -->
      <nav class="content-breadcrumb-nav" aria-label="Breadcrumb">
        <ul class="content-breadcrumb">
          <li><a href="<?= base_url('home.html') ?>"><i class="fa-solid fa-house me-1"></i> Anasayfa</a></li>
          <li class="breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
          <li><a href="<?= base_url('sayfa') ?>">Kurumsal</a></li>
          <li class="breadcrumb-separator"><i class="fa-solid fa-chevron-right"></i></li>
          <li class="active-crumb"><?= $pageTitle ?></li>
        </ul>
      </nav>

      <!-- 2. Sayfa Başlık Hero Bannerı -->
      <section class="content-hero-card">
        <div class="content-hero-category">
          <i class="fa-solid fa-layer-group"></i>
          <span><?= $pageCat ?></span>
        </div>
        <h1 class="content-hero-title"><?= $pageTitle ?></h1>
        <?php if (!empty($pageDesc)): ?>
          <p class="content-hero-subtitle"><?= $pageDesc ?></p>
        <?php endif; ?>

        <div class="content-meta-bar">
          <div class="content-meta-item">
            <i class="fa-regular fa-calendar-check"></i>
            <span>Son Güncelleme / Yayın: <strong><?= $pageTime ?></strong></span>
          </div>
          <div class="content-meta-item">
            <i class="fa-regular fa-clock"></i>
            <span>Tahmini Okuma: <strong><?= $readTime ?> Dakika</strong></span>
          </div>
          <div class="content-meta-item">
            <i class="fa-solid fa-shield-halved text-success"></i>
            <span>Ufka Yolculuk Resmi İçeriği</span>
          </div>
        </div>
      </section>

      <!-- 3. İki Sütunlu Sayfa Düzeni (Sol: CMS İçerik Alanı, Sağ: Kurumsal Yan Menü) -->
      <div class="row g-4">
        
        <!-- Sol: Admin Panelden Gelecek Zengin İçerik Alanı (.cms-content) -->
        <div class="col-lg-8">
          <article class="content-main-card">
            
            <div class="cms-content">
              
              <?php if (!empty($isFaqPage)): ?>
                <!-- Sıkça Sorulan Sorular (SSS) Arama ve Accordion Görünümü -->
                <div class="faq-search-wrapper mb-4">
                  <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                    <span class="input-group-text bg-white border-0 ps-3 text-primary"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" id="faqSearchInput" class="form-control border-0 py-2" placeholder="Sorularda arama yapın... (örn: ödüller, başvuru, sınav tarihi)">
                    <button class="btn btn-primary px-4 fw-bold" type="button" id="faqClearBtn" style="display:none;">Temizle</button>
                  </div>
                </div>

                <div class="accordion accordion-custom" id="faqAccordion">
                  <?php if (!empty($faqs)): ?>
                    <?php foreach ($faqs as $idx => $faq): ?>
                      <?php 
                        $faqTitle = esc($faq['title'] ?? 'Soru');
                        $faqBody = !empty($faq['formatted_body']) ? $faq['formatted_body'] : (!empty($faq['body']) ? $faq['body'] : '<p>' . esc($faq['description'] ?? '') . '</p>');
                        $faqSearchText = esc(mb_strtolower($faqTitle . ' ' . strip_tags($faqBody)));
                      ?>
                      <div class="accordion-item faq-item border rounded-3 mb-2 overflow-hidden shadow-2xs" data-keywords="<?= $faqSearchText ?>">
                        <h2 class="accordion-header" id="heading-<?= $idx ?>">
                          <button class="accordion-button <?= $idx === 0 ? '' : 'collapsed' ?> fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $idx ?>" aria-expanded="<?= $idx === 0 ? 'true' : 'false' ?>" aria-controls="collapse-<?= $idx ?>">
                            <i class="fa-solid fa-circle-question text-primary me-2"></i>
                            <?= $faqTitle ?>
                          </button>
                        </h2>
                        <div id="collapse-<?= $idx ?>" class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>" aria-labelledby="heading-<?= $idx ?>" data-bs-parent="#faqAccordion">
                          <div class="accordion-body cms-content py-3 text-secondary">
                            <?= $faqBody ?>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="alert alert-info">Kayıtlı soru bulunamadı.</div>
                  <?php endif; ?>
                </div>

              <?php elseif (!empty($bodyHtml)): ?>
                <!-- API'den Gelen Zengin İçerik Gövdesi -->
                <?= $bodyHtml ?>

              <?php else: ?>
                <!-- İçerik Bulunamadı Durumu -->
                <div class="text-center py-5">
                  <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle mb-3" style="width: 72px; height: 72px; font-size: 2rem;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                  </div>
                  <h3 class="fw-bold text-dark">İçerik Hazırlanıyor</h3>
                  <p class="text-muted max-w-md mx-auto mb-4">
                    Talep ettiğiniz "<strong><?= esc($activeSlug ?? 'Sayfa') ?></strong>" içerik detayına şu anda ulaşılamıyor veya henüz yayınlanmadı.
                  </p>
                  <a href="<?= base_url('sayfa/hakkimizda') ?>" class="btn btn-primary rounded-pill px-4 fw-bold">
                    <i class="fa-solid fa-arrow-left me-1"></i> Hakkımızda Sayfasına Dön
                  </a>
                </div>
              <?php endif; ?>

              <!-- Paylaşım & İndirme Butonları -->
              <div class="content-footer-actions mt-4 pt-3 border-top">
                <div class="d-flex align-items-center gap-2">
                  <button type="button" class="btn-print-page" onclick="window.print()">
                    <i class="fa-solid fa-print"></i>
                    <span>Sayfayı Yazdır</span>
                  </button>
                  <a href="javascript:void(0)" onclick="window.print()" class="btn-download-pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>PDF Olarak Kaydet</span>
                  </a>
                </div>

                <div class="d-flex align-items-center gap-2 text-muted fs-8">
                  <span>Paylaş:</span>
                  <a href="https://api.whatsapp.com/send?text=<?= urlencode($pageTitle . ' - ' . current_url()) ?>" target="_blank" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="WhatsApp ile Paylaş"><i class="fa-brands fa-whatsapp text-success"></i></a>
                  <a href="https://twitter.com/intent/tweet?text=<?= urlencode($pageTitle) ?>&url=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="X (Twitter) ile Paylaş"><i class="fa-brands fa-x-twitter text-dark"></i></a>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Facebook ile Paylaş"><i class="fa-brands fa-facebook text-primary"></i></a>
                  <button type="button" class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" onclick="navigator.clipboard.writeText(window.location.href); alert('Sayfa bağlantısı kopyalandı!');" title="Bağlantıyı Kopyala"><i class="fa-solid fa-link text-secondary"></i></button>
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
              <?php if (!empty($corporatePages)): ?>
                <?php foreach ($corporatePages as $key => $corp): ?>
                  <?php 
                    $corpSlug = $corp['slug'] ?? $key;
                    $isActive = ($activeSlug === $corpSlug || $activeSlug === $key);
                  ?>
                  <a href="<?= base_url('sayfa/' . $corpSlug) ?>" class="sidebar-nav-link <?= $isActive ? 'active' : '' ?>">
                    <div class="d-flex align-items-center gap-2">
                      <i class="<?= esc($corp['icon'] ?? 'fa-solid fa-file-lines') ?> text-primary"></i>
                      <span><?= esc($corp['title'] ?? '') ?></span>
                    </div>
                    <?php if (!empty($corp['badge'])): ?>
                      <span class="badge <?= $isActive ? 'bg-primary text-white' : 'bg-light text-muted' ?> rounded-pill fs-9"><?= esc($corp['badge']) ?></span>
                    <?php else: ?>
                      <i class="fa-solid fa-chevron-right fs-9"></i>
                    <?php endif; ?>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </nav>
          </aside>

          <!-- Son Duyurular Widgetı -->
          <?php if (!empty($recentAnnouncements)): ?>
            <div class="p-4 bg-white rounded-4 border shadow-sm mb-4">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="fs-7 fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                  <i class="fa-solid fa-bullhorn text-warning"></i> Son Duyurular
                </h4>
                <span class="badge bg-warning-subtle text-dark fs-9">Güncel</span>
              </div>
              <div class="d-flex flex-column gap-2">
                <?php foreach ($recentAnnouncements as $ann): ?>
                  <a href="<?= base_url('sayfa/' . ($ann['slug'] ?? '')) ?>" class="p-2 rounded-3 text-decoration-none border-bottom border-light hover-bg-light transition-all d-block">
                    <div class="fs-8 fw-bold text-dark text-truncate mb-1"><?= esc($ann['title'] ?? '') ?></div>
                    <div class="d-flex align-items-center justify-content-between fs-9 text-muted">
                      <span><i class="fa-regular fa-clock me-1"></i><?= esc($ann['publish_time'] ?? 'Yeni') ?></span>
                      <i class="fa-solid fa-chevron-right fs-10 text-primary"></i>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const faqInput = document.getElementById('faqSearchInput');
      const faqClearBtn = document.getElementById('faqClearBtn');
      const faqItems = document.querySelectorAll('.faq-item');

      if (faqInput) {
        faqInput.addEventListener('input', function () {
          const val = this.value.trim().toLowerCase();
          faqClearBtn.style.display = val.length > 0 ? 'inline-block' : 'none';

          faqItems.forEach(item => {
            const keywords = item.getAttribute('data-keywords') || '';
            if (!val || keywords.includes(val)) {
              item.style.display = '';
            } else {
              item.style.display = 'none';
            }
          });
        });

        faqClearBtn.addEventListener('click', function () {
          faqInput.value = '';
          faqInput.dispatchEvent(new Event('input'));
        });
      }
    });
  </script>
<?= $this->endSection() ?>
