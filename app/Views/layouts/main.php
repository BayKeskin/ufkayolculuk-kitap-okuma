<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle ?? $title ?? 'Ufka Yolculuk - Kitap Okuma ve Sesli Dinleme Portalı') ?></title>
  <meta name="description" content="<?= esc($metaDescription ?? 'Ufka Yolculuk Kitap Okuma ve Sesli Dinleme Portalı. Bilgini artır, kendini geliştir, ödüller kazan!') ?>">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS (Yerel) -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">

  <!-- Font Awesome 6 Pro/Free (Yerel - CDN Yok) -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">

  <!-- Ana Stil Dosyası -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=4.0') ?>">

  <!-- Sayfaya Özel Ek Stiller -->
  <?= $this->renderSection('styles') ?>
</head>
<body class="<?= esc($bodyClass ?? '') ?>">

  <!-- Ortak Üst Navbar -->
  <?= $this->include('layouts/navbar') ?>

  <!-- Dinamik Sayfa İçeriği -->
  <?= $this->renderSection('content') ?>

  <!-- Ortak Alt Footer -->
  <?= $this->include('layouts/footer') ?>

  <!-- Ortak Mobil Menü Çekmecesi -->
  <?= $this->include('layouts/mobile_nav') ?>

  <!-- Sayfaya Özel Modallar -->
  <?= $this->renderSection('modals') ?>

  <!-- Ortak JavaScript Kütüphaneleri -->
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/header-search.js?v=4.0') ?>"></script>

  <!-- Sayfaya Özel JavaScript Kodları -->
  <?= $this->renderSection('scripts') ?>
</body>
</html>
