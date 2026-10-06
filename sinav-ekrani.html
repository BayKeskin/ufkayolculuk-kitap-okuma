<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Sınav Salonu - Ufka Yolculuk</title>
  <meta name="description" content="Ufka Yolculuk müstakil online deneme sınavı platformu. Canlı sayaçlı sınav salonu, soru paleti ve detaylı analiz karnesi.">

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.3 CSS (Yerel) -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome 6 Pro/Free (Yerel) -->
  <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">

  <!-- Özel Müstakil Sınav Sistemi Stili -->
  <link rel="stylesheet" href="assets/css/sinav-ekrani.css?v=1.0">
</head>

<body class="sinav-system-body">

  <!-- =======================================================================
       1. ÜST BAŞLIK ÇUBUĞU (Exam Top Bar)
       ======================================================================= -->
  <header class="sinav-system-header d-flex align-items-center justify-content-between">
    <!-- Sol Logo & Sınav Rozeti -->
    <div class="d-flex align-items-center gap-3">
      <a href="deneme-sinavlari.html" class="sinav-system-brand" title="Deneme Sınavları Paneline Dön">
        <img src="assets/images/logo.png" alt="Ufka Yolculuk Logo" class="sinav-system-logo">
        <div class="d-none d-sm-block">
          <div class="sinav-system-brand-text">UFKA YOLCULUK</div>
          <div class="sinav-system-brand-sub">ONLINE SINAV SALONU</div>
        </div>
      </a>

      <div class="vr mx-2 d-none d-md-block opacity-25"></div>

      <div class="sinav-exam-badge-header d-none d-md-inline-flex">
        <i class="fa-solid fa-laptop-code text-primary"></i>
        <span id="headerExamBadgeTitle">Genel Deneme Sınavı</span>
      </div>
    </div>

    <!-- Orta Canlı Kronometre (Sınav başladığında görünür) -->
    <div class="sinav-timer-card d-none" id="headerExamTimer">
      <i class="fa-regular fa-clock"></i>
      <span id="timerTextDisplay">15:00</span>
    </div>

    <!-- Sağ Araçlar (Yazı boyutu, tam ekran, sınavı bitir / çıkış) -->
    <div class="d-flex align-items-center gap-2">
      
      <!-- Aktif Sınav Sırasında Görünür Kontroller -->
      <div class="d-none d-flex align-items-center gap-2" id="headerExamControls">
        <!-- Yazı Boyutu Seçici -->
        <div class="font-resizer-wrap d-none d-sm-inline-flex" title="Soru Yazı Boyutu">
          <button type="button" class="btn-font-size" data-size="sm">A-</button>
          <button type="button" class="btn-font-size active" data-size="md">A</button>
          <button type="button" class="btn-font-size" data-size="lg">A+</button>
        </div>

        <!-- Tam Ekran Butonu -->
        <button type="button" class="btn btn-sm btn-light border rounded-pill px-2" id="btnToggleFullScreen" title="Tam Ekran Modu">
          <i class="fa-solid fa-expand"></i>
        </button>

        <!-- Sınavı Bitir Butonu -->
        <button type="button" class="btn btn-sm btn-danger fw-bold rounded-pill px-3 shadow-sm" id="btnTriggerFinishExam">
          <i class="fa-solid fa-flag-checkered me-1"></i> Sınavı Bitir
        </button>
      </div>

      <!-- Çıkış / Geri Dön -->
      <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill fw-bold px-3" id="btnLeaveExam">
        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Ayrıl
      </button>
    </div>
  </header>

  <!-- =======================================================================
       2. AŞAMA 1: SINAV ÖNCESİ GİRİŞ & BİLGİLENDİRME EKRANI (Pre-Exam Onboarding)
       ======================================================================= -->
  <main class="pre-exam-container" id="screenPreExam">
    <div class="pre-exam-hero-card">
      
      <!-- Üst Başlık & Kitap Tanıtımı -->
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4 mb-4">
        <div>
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill" id="preExamCategoryBadge">Genel Sınav</span>
            <span class="badge bg-light text-muted border fw-semibold">Ufka Yolculuk 12</span>
          </div>
          <h1 class="fw-extrabold text-dark display-6 mb-2" id="preExamTitle">Genel Deneme Sınavı</h1>
          <p class="text-muted fs-6 mb-0" id="preExamSub">Gerçek sınav simülasyonu ile bilgini sına, eksiklerini tamamla.</p>
        </div>

        <div class="d-none d-md-block text-end flex-shrink-0">
          <img src="assets/images/books/book-genel.svg" alt="Kitap Kapağı" class="pre-exam-book-thumb" id="preExamBookImg">
        </div>
      </div>

      <!-- 4 Temel Parametre / Metrik Izgarası -->
      <div class="pre-exam-specs-grid">
        <div class="pre-exam-spec-item">
          <div class="pre-exam-spec-icon blue">
            <i class="fa-solid fa-list-ol"></i>
          </div>
          <div class="pre-exam-spec-val" id="preExamQuestionCount">10 Soru</div>
          <div class="pre-exam-spec-lbl">Soru Sayısı</div>
        </div>

        <div class="pre-exam-spec-item">
          <div class="pre-exam-spec-icon green">
            <i class="fa-regular fa-clock"></i>
          </div>
          <div class="pre-exam-spec-val" id="preExamDuration">15 Dakika</div>
          <div class="pre-exam-spec-lbl">Toplam Süre</div>
        </div>

        <div class="pre-exam-spec-item">
          <div class="pre-exam-spec-icon purple">
            <i class="fa-solid fa-award"></i>
          </div>
          <div class="pre-exam-spec-val" id="preExamPoints">100 Puan</div>
          <div class="pre-exam-spec-lbl">Toplam Puan</div>
        </div>

        <div class="pre-exam-spec-item">
          <div class="pre-exam-spec-icon amber">
            <i class="fa-solid fa-scale-balanced"></i>
          </div>
          <div class="pre-exam-spec-val">4 Yanlış 1 Doğru</div>
          <div class="pre-exam-spec-lbl">Net Puanlama</div>
        </div>
      </div>

      <!-- Sınav Kuralları ve Yönergeleri -->
      <div class="mb-4">
        <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
          <i class="fa-solid fa-shield-halved text-primary"></i>
          Sınav Kuralları ve Önemli Yönergeler
        </h5>
        <ul class="pre-exam-rules-list" id="preExamRulesList">
          <!-- JS ile doldurulur -->
        </ul>
      </div>

      <!-- Aday Bilgisi & Kuralları Okudum Onayı -->
      <div class="pre-exam-agree-card">
        <input class="form-check-input" type="checkbox" id="chkAgreeRules">
        <label class="form-check-label" for="chkAgreeRules">
          Sınav kurallarını, süre ve puanlama esaslarını okudum, anladım ve kabul ediyorum.
        </label>
      </div>

      <!-- Sınavı Başlat Aksiyon Alanı -->
      <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 pt-2">
        <div class="text-muted small">
          <i class="fa-solid fa-user-check text-success me-1"></i> Aday: <strong>Ahmet Yılmaz</strong> (Ufka Yolculuk Yarışmacısı)
        </div>
        <button type="button" class="btn-start-exam-large" id="btnStartExamNow" disabled>
          <span>Sınavı Başlat</span>
          <i class="fa-solid fa-play"></i>
        </button>
      </div>

    </div>
  </main>

  <!-- =======================================================================
       3. AŞAMA 2: GENİŞ & RAHAT ODAK SINAV SALONU (Active Exam Engine)
       ======================================================================= -->
  <main class="exam-layout-main d-none" id="screenExamRunning">
    <div class="row g-4">
      
      <!-- Sol Soru Çözüm Alanı (9 Sütun) -->
      <div class="col-12 col-lg-8 col-xl-9">
        <div class="exam-question-card font-size-md" id="examQuestionCard">
          
          <!-- Soru Üst Çubuğu: Numara, Konu -->
          <div class="exam-question-top-bar">
            <div class="d-flex align-items-center gap-2">
              <span class="exam-q-number-badge" id="qCurrentNumberBadge">Soru 1 / 10</span>
              <span class="exam-q-topic-badge" id="qTopicBadge">İnanç ve İtikat</span>
            </div>
          </div>

          <!-- Soru Metni -->
          <div class="exam-q-text-body" id="qBodyText">
            Soru metni yükleniyor...
          </div>

          <!-- Seçenekler A, B, C, D, E -->
          <div class="exam-choices-list" id="qChoicesList">
            <!-- JS ile dinamik render edilir -->
          </div>

          <!-- Soru Alt Navigasyon Çubuğu -->
          <div class="exam-q-bottom-nav">
            <button type="button" class="btn-clear-choice" id="btnClearChoice">
              <i class="fa-solid fa-eraser me-1"></i> Cevabı Temizle
            </button>

            <div class="d-flex align-items-center gap-2">
              <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold px-4" id="btnPrevQuestion" disabled>
                <i class="fa-solid fa-arrow-left me-1"></i> Önceki
              </button>
              <button type="button" class="btn btn-primary btn-sm rounded-pill fw-bold px-4 shadow-sm" id="btnNextQuestion">
                Sonraki Soru <i class="fa-solid fa-arrow-right ms-1"></i>
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- Sağ Soru Navigasyon Paleti & Durum Kartı (3 Sütun) -->
      <div class="col-12 col-lg-4 col-xl-3">
        <aside class="exam-palette-sidebar-card">
          
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold text-dark mb-0">Soru Navigasyon Paleti</h6>
            <span class="badge bg-light text-muted border">Hızlı Geçiş</span>
          </div>

          <!-- 2'li Canlı Durum Özeti (Cevaplandı & Boş) -->
          <div class="palette-status-duo">
            <div class="palette-status-item">
              <div class="palette-status-count green" id="paletteAnsweredCount">0</div>
              <div class="palette-status-label">Cevaplandı</div>
            </div>
            <div class="palette-status-item">
              <div class="palette-status-count gray" id="paletteEmptyCount">10</div>
              <div class="palette-status-label">Boş</div>
            </div>
          </div>

          <!-- Soru Numaraları Matrisi (1 .. N) -->
          <div class="palette-grid-matrix" id="paletteMatrix">
            <!-- JS ile üretilir -->
          </div>

          <!-- Renk Lejantı -->
          <div class="palette-legend-list">
            <div><span class="palette-legend-dot green"></span>Cevaplandı</div>
            <div><span class="palette-legend-dot gray"></span>Boş</div>
          </div>

        </aside>
      </div>

    </div>
  </main>

  <!-- =======================================================================
       4. AŞAMA 3: DETAYLI İSTATİSTİK, KARNE & ÇÖZÜM RAPORU (Post-Exam Report)
       ======================================================================= -->
  <main class="report-screen-container d-none" id="screenPostExamReport">
    
    <!-- Üst Başarı & Puan Trofe Kartı -->
    <div class="report-hero-trophy-card">
      <div class="row align-items-center g-4">
        <div class="col-md-7 d-flex align-items-center gap-4">
          <div class="report-trophy-icon-wrap flex-shrink-0">
            <i class="fa-solid fa-trophy"></i>
          </div>
          <div>
            <span class="badge bg-white text-primary fw-bold mb-2 px-3 py-1 rounded-pill">Sınav Tamamlandı</span>
            <h2 class="fw-extrabold mb-1" id="reportExamTitle">Genel Deneme Sınavı</h2>
            <p class="mb-0 opacity-90 fs-7" id="reportFeedbackMessage">Tebrikler! Sınavınızı başarıyla tamamladınız.</p>
          </div>
        </div>

        <div class="col-md-5">
          <div class="d-flex align-items-center justify-content-around gap-2">
            <div class="report-score-stat-box flex-fill">
              <div class="report-score-stat-num" id="reportTotalScore">0.0</div>
              <div class="report-score-stat-lbl">Toplam Puan</div>
            </div>
            <div class="report-score-stat-box flex-fill">
              <div class="report-score-stat-num" id="reportNetScore">0.00</div>
              <div class="report-score-stat-lbl">Hesaplanan Net</div>
            </div>
            <div class="report-score-stat-box flex-fill">
              <div class="report-score-stat-num" id="reportSuccessRate">%0</div>
              <div class="report-score-stat-lbl">Başarı Oranı</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 4 Detaylı Metrik Kutusu -->
    <div class="report-metrics-grid">
      <div class="report-metric-box correct">
        <div class="report-metric-num green" id="reportCorrectCount">0</div>
        <div class="report-metric-lbl"><i class="fa-solid fa-circle-check text-success me-1"></i> Doğru Cevap</div>
      </div>
      <div class="report-metric-box wrong">
        <div class="report-metric-num red" id="reportWrongCount">0</div>
        <div class="report-metric-lbl"><i class="fa-solid fa-circle-xmark text-danger me-1"></i> Yanlış Cevap</div>
      </div>
      <div class="report-metric-box empty">
        <div class="report-metric-num gray" id="reportEmptyCount">0</div>
        <div class="report-metric-lbl"><i class="fa-regular fa-circle text-muted me-1"></i> Boş Bırakılan</div>
      </div>
      <div class="report-metric-box time">
        <div class="report-metric-num blue" id="reportTimeSpent" style="font-size: 1.35rem;">0 Dk 0 Sn</div>
        <div class="report-metric-lbl"><i class="fa-regular fa-clock text-primary me-1"></i> Harcanan Süre</div>
      </div>
    </div>

    <!-- Konu Bazlı Başarı Analizi Kartı -->
    <div class="report-section-card">
      <h3 class="report-section-title">
        <i class="fa-solid fa-chart-simple text-primary"></i>
        Konu Bazlı Başarı Karnesi & Gelişim Tavsiyeleri
      </h3>
      <div class="topic-analysis-row" id="reportTopicBarsWrap">
        <!-- JS ile konu ilerleme çubukları render edilir -->
      </div>
    </div>

    <!-- Soru Çözümleri & Cevap Anahtarı İnceleme Alanı -->
    <div class="report-section-card">
      <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 mb-3">
        <h3 class="report-section-title mb-0">
          <i class="fa-solid fa-file-circle-check text-success"></i>
          Soru Çözümleri & Detaylı Cevap Anahtarı
        </h3>
        <span class="badge bg-light text-muted border">Tüm Sorular Çözümleriyle Birlikte</span>
      </div>

      <div class="solution-review-list" id="solutionReviewList">
        <!-- JS ile soru çözüm kartları render edilir -->
      </div>
    </div>

    <!-- Alt Aksiyon Butonları -->
    <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 py-4">
      <button type="button" class="btn btn-primary fw-bold px-4 py-2 rounded-pill shadow-sm" id="btnRestartExam">
        <i class="fa-solid fa-rotate-left me-2"></i> Sınavı Tekrar Çöz
      </button>
      <a href="deneme-sinavlari.html" class="btn btn-outline-primary fw-bold px-4 py-2 rounded-pill">
        <i class="fa-solid fa-laptop-code me-2"></i> Diğer Deneme Sınavları
      </a>
      <a href="dashboard.html" class="btn btn-light border fw-bold px-4 py-2 rounded-pill">
        <i class="fa-solid fa-chart-pie me-2 text-primary"></i> Dashboard'da İncele
      </a>
    </div>

  </main>

  <!-- =======================================================================
       5. SINAVI BİTİR ONAY MODALI (Finish Confirmation Modal)
       ======================================================================= -->
  <div class="modal fade" id="finishConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header bg-light border-bottom p-3">
          <h5 class="modal-title fw-bold fs-6 text-dark">
            <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> Sınavı Bitirmek İstiyor musunuz?
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <p class="text-muted mb-3" style="font-size: 0.9rem;">
            Sınavınızı bitirmek üzeresiniz. Yanıtlarınız sisteme kaydedilecek ve detaylı karne raporunuz oluşturulacaktır.
          </p>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="p-2.5 bg-success-subtle rounded-3">
                <div class="fw-extrabold text-success fs-4" id="modalStatAnswered">0</div>
                <div class="text-success small fw-bold">Cevaplanan Soru</div>
              </div>
            </div>
            <div class="col-6">
              <div class="p-2.5 bg-light border rounded-3">
                <div class="fw-extrabold text-muted fs-4" id="modalStatEmpty">0</div>
                <div class="small text-muted fw-bold">Boş Bırakılan</div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light border-top p-3 d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary btn-sm fw-bold px-3 rounded-pill" data-bs-dismiss="modal">
            Sorulara Devam Et
          </button>
          <button type="button" class="btn btn-danger btn-sm fw-bold px-4 rounded-pill shadow-sm" id="btnModalConfirmFinish">
            <i class="fa-solid fa-check me-1"></i> Evet, Sınavı Bitir
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- =======================================================================
       6. SINAVDAN AYRIL ONAY MODALI (Leave Confirmation Modal)
       ======================================================================= -->
  <div class="modal fade" id="leaveConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 border-0 shadow-lg">
        <div class="modal-header bg-light border-bottom p-3">
          <h5 class="modal-title fw-bold fs-6 text-dark">
            <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i> Sınavdan Ayrılmak İstiyor musunuz?
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body p-4 text-center">
          <div class="mb-3">
            <div class="bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; font-size: 1.5rem;">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
          </div>
          <h6 class="fw-bold text-dark mb-2">Devam eden bir sınavınız bulunmaktadır.</h6>
          <p class="text-muted small mb-0">
            Sınavdan şimdi ayrılırsanız süreniz durdurulacak ve tamamlanmamış cevaplarınız değerlendirmeye alınmayacaktır. Ayrılmak istediğinize emin misiniz?
          </p>
        </div>
        <div class="modal-footer bg-light border-top p-3 d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary btn-sm fw-bold px-3 rounded-pill" data-bs-dismiss="modal">
            Sınava Devam Et
          </button>
          <button type="button" class="btn btn-danger btn-sm fw-bold px-4 rounded-pill shadow-sm" id="btnModalConfirmLeave">
            <i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Evet, Sınavdan Ayrıl
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (Yerel) -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!-- Özel Sınav Sistemi Scripti -->
  <script src="assets/js/sinav-ekrani.js?v=1.0"></script>

</body>
</html>
