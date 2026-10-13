/**
 * Ufka Yolculuk - Online Deneme Sınavları İnteraktif Scriptleri (sinav.js)
 * Canlı Arama, Açılır Bildirim Popover, Canlı Sınav Simülasyonu, Konu Testi Üretici, Takvim & Sonuç Analizi
 */

document.addEventListener('DOMContentLoaded', () => {
  initLiveSearch();
  initNotificationDropdown();
  initCarousels();
  initExamFilters();
  initFavoriteButtons();
  initExamSimulation();
  initTopicSelector();
  initCalendarModal();
  initDetailedResultModal();
  initChartInteractions();
  initMobileSidebarToggle();
});

/* ==========================================================================
   1. Modern Canlı Arama & Öneri Sistemi (Live Search)
   ========================================================================== */
function initLiveSearch() {
  const searchInput = document.getElementById('sinavLiveSearchInput');
  const clearBtn = document.getElementById('sinavSearchClearBtn');
  const dropdown = document.getElementById('sinavSearchResultsDropdown');
  const resultsList = document.getElementById('sinavSearchResultsList');
  const cardCols = document.querySelectorAll('.sinav-card-col');

  if (!searchInput) return;

  const EXAM_DATA = [
    { key: 'genel', title: 'Genel Deneme Sınavı', sub: 'Ufka Yolculuk 2025', count: '120 Soru', time: '150 Dk', badge: 'Genel', color: 'success' },
    { key: 'kuslarin-cagrisi', title: 'Kuşların Çağrısı', sub: 'İlkokul Deneme Sınavı', count: '100 Soru', time: '120 Dk', badge: 'İlkokul', color: 'primary' },
    { key: 'tevhid-muhafizlari', title: 'Tevhid Muhafızları', sub: 'Ortaokul Deneme Sınavı', count: '100 Soru', time: '120 Dk', badge: 'Ortaokul', color: 'info' },
    { key: 'gordugume-gormedigime', title: 'Gördüğüme Görmediğime', sub: 'Lise Deneme Sınavı', count: '100 Soru', time: '120 Dk', badge: 'Lise', color: 'warning' },
    { key: 'nasil-inanmali', title: 'Nasıl İnanmalı?', sub: 'Yetişkin Deneme Sınavı', count: '100 Soru', time: '120 Dk', badge: 'Yetişkin', color: 'teal' },
    { key: 'siyer-ozel', title: 'Hz. Peygamber\'in İzinde', sub: 'Siyer Özel Deneme', count: '80 Soru', time: '90 Dk', badge: 'Siyer', color: 'danger' },
    { key: 'ilim-yolculari', title: 'İlim Yolcuları', sub: 'Haftalık Hızlı Test', count: '50 Soru', time: '60 Dk', badge: 'Haftalık', color: 'indigo' },
    { key: 'guzel-ahlak', title: 'Güzel Ahlak Rehberi', sub: 'Ahlak & Değerler', count: '60 Soru', time: '75 Dk', badge: 'Ahlak', color: 'amber' }
  ];

  function performSearch(query) {
    const q = query.trim().toLowerCase();

    let visibleCount = 0;
    cardCols.forEach(col => {
      const title = (col.querySelector('.sinav-box-title')?.textContent || '').toLowerCase();
      const sub = (col.querySelector('.sinav-box-sub')?.textContent || '').toLowerCase();
      if (!q || title.includes(q) || sub.includes(q)) {
        col.classList.remove('d-none');
        visibleCount++;
      } else {
        col.classList.add('d-none');
      }
    });

    const badge = document.getElementById('examCountBadge');
    if (badge) badge.textContent = `${visibleCount} Sınav`;

    // 2. Temizleme butonunu göster/gizle
    if (clearBtn) {
      clearBtn.style.display = q ? 'block' : 'none';
    }

    // 3. Canlı öneri dropdownunu güncelle
    if (!q) {
      if (dropdown) dropdown.classList.remove('show');
      return;
    }

    const matches = EXAM_DATA.filter(item => 
      item.title.toLowerCase().includes(q) || 
      item.sub.toLowerCase().includes(q) ||
      item.badge.toLowerCase().includes(q)
    );

    if (resultsList) {
      resultsList.innerHTML = '';
      if (matches.length === 0) {
        resultsList.innerHTML = '<div class="p-2 text-center text-muted small">Sonuç bulunamadı</div>';
      } else {
        matches.forEach(item => {
          const itemEl = document.createElement('div');
          itemEl.className = 'sinav-search-result-item';
          itemEl.innerHTML = `
            <div>
              <div class="fw-bold text-dark" style="font-size: 0.78rem;">${item.title}</div>
              <div class="text-muted" style="font-size: 0.68rem;">${item.sub} • ${item.count}</div>
            </div>
            <span class="badge bg-${item.color}-subtle text-${item.color} fw-bold" style="font-size: 0.65rem;">${item.badge}</span>
          `;
          itemEl.addEventListener('click', () => {
            searchInput.value = item.title;
            if (dropdown) dropdown.classList.remove('show');
            // Müstakil sınav salonu sayfasına yönlendir
            window.location.href = `sinav-ekrani.html?sinav=${encodeURIComponent(item.key)}`;
          });
          resultsList.appendChild(itemEl);
        });
      }
    }

    if (dropdown) dropdown.classList.add('show');
  }

  searchInput.addEventListener('input', (e) => performSearch(e.target.value));
  searchInput.addEventListener('focus', () => {
    if (searchInput.value.trim()) performSearch(searchInput.value);
  });

  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      searchInput.value = '';
      performSearch('');
      searchInput.focus();
    });
  }

  // Sayfa dışı tıklamalarda dropdownu kapat
  document.addEventListener('click', (e) => {
    if (!searchInput.contains(e.target) && (!dropdown || !dropdown.contains(e.target))) {
      if (dropdown) dropdown.classList.remove('show');
    }
  });

  // Klavye Kısayolu: Ctrl+K / Cmd+K ile hızlı odaklanma, ESC ile kapatma
  document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      searchInput.focus();
      searchInput.select();
    }
    if (e.key === 'Escape' && dropdown && dropdown.classList.contains('show')) {
      dropdown.classList.remove('show');
    }
  });
}

/* ==========================================================================
   2. Bildirimler Açılır Popover Menüsü Etkileşimi
   ========================================================================== */
function initNotificationDropdown() {
  const notifBadge = document.getElementById('sinavNotifCountBadge');
  const notifPill = document.getElementById('notifUnreadPillBadge');
  const markAllBtn = document.getElementById('btnMarkAllNotifsRead');
  const notifRows = document.querySelectorAll('.notif-item-row');
  const btnViewCalendarFromNotif = document.getElementById('btnViewCalendarFromNotif');

  function updateUnreadCount() {
    const unreadItems = document.querySelectorAll('.notif-item-row.unread');
    const count = unreadItems.length;

    if (notifBadge) {
      notifBadge.textContent = count;
      notifBadge.style.display = count > 0 ? 'flex' : 'none';
    }
    if (notifPill) {
      notifPill.textContent = count > 0 ? `${count} Yeni` : '0 Yeni';
    }
  }

  if (markAllBtn) {
    markAllBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      notifRows.forEach(row => {
        row.classList.remove('unread');
        const dot = row.querySelector('.notif-unread-dot');
        if (dot) dot.style.display = 'none';
      });
      updateUnreadCount();
      showToast('Bildirimler Okundu', 'Tüm bildirimler okundu olarak işaretlendi.');
    });
  }

  notifRows.forEach(row => {
    row.addEventListener('click', () => {
      if (row.classList.contains('unread')) {
        row.classList.remove('unread');
        const dot = row.querySelector('.notif-unread-dot');
        if (dot) dot.style.display = 'none';
        updateUnreadCount();
      }
    });
  });

  if (btnViewCalendarFromNotif) {
    btnViewCalendarFromNotif.addEventListener('click', (e) => {
      e.preventDefault();
      const calModalEl = document.getElementById('calendarModal');
      if (calModalEl) {
        const calModal = bootstrap.Modal.getOrCreateInstance(calModalEl);
        calModal.show();
      }
    });
  }
}

/* ==========================================================================
   3. Carousel / Slider Mekanizmaları (Deneme Sınavları & Soru Çöz)
   ========================================================================== */
function initCarousels() {
  // 1. Deneme Sınavları Carousel (4 Görünür Kart)
  setupCarousel({
    trackId: 'examCardsCarousel',
    prevBtnId: 'prevExamCardBtn',
    nextBtnId: 'nextExamCardBtn',
    scrollRatio: 0.85
  });

  // 2. Soru Çöz Carousel (5 Görünür Konu)
  setupCarousel({
    trackId: 'topicsCarousel',
    prevBtnId: 'prevTopicBtn',
    nextBtnId: 'nextTopicBtn',
    scrollRatio: 0.8
  });
}

function setupCarousel({ trackId, prevBtnId, nextBtnId, scrollRatio }) {
  const track = document.getElementById(trackId);
  const prevBtn = document.getElementById(prevBtnId);
  const nextBtn = document.getElementById(nextBtnId);

  if (!track) return;

  function updateButtons() {
    if (!prevBtn || !nextBtn) return;
    const maxScroll = track.scrollWidth - track.clientWidth - 4;
    prevBtn.disabled = track.scrollLeft <= 4;
    nextBtn.disabled = track.scrollLeft >= maxScroll;
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      const step = (track.clientWidth * scrollRatio);
      track.scrollBy({ left: -step, behavior: 'smooth' });
      setTimeout(updateButtons, 350);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      const step = (track.clientWidth * scrollRatio);
      track.scrollBy({ left: step, behavior: 'smooth' });
      setTimeout(updateButtons, 350);
    });
  }

  track.addEventListener('scroll', updateButtons, { passive: true });
  window.addEventListener('resize', updateButtons, { passive: true });
  updateButtons();

  // Mouse Drag ile Kaydırma Desteği
  let isDown = false;
  let startX;
  let scrollLeft;

  track.addEventListener('mousedown', (e) => {
    // Buton veya linke tıklandıysa drag tetikleme
    if (e.target.closest('button') || e.target.closest('a')) return;
    isDown = true;
    startX = e.pageX - track.offsetLeft;
    scrollLeft = track.scrollLeft;
  });

  track.addEventListener('mouseleave', () => {
    isDown = false;
  });

  track.addEventListener('mouseup', () => {
    isDown = false;
  });

  track.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - track.offsetLeft;
    const walk = (x - startX) * 1.5;
    track.scrollLeft = scrollLeft - walk;
    updateButtons();
  });
}

/* ==========================================================================
   4. Sınav Kartları Filtreleme (Kategori & Tür Seçimleri)
   ========================================================================== */
function initExamFilters() {
  const categoryFilter = document.getElementById('categoryFilter');
  const typeFilter = document.getElementById('typeFilter');
  const cardCols = document.querySelectorAll('.sinav-card-col');

  function applyFilters() {
    const selectedCat = categoryFilter ? categoryFilter.value.toLowerCase() : 'all';
    const selectedType = typeFilter ? typeFilter.value.toLowerCase() : 'all';
    let visibleCount = 0;

    cardCols.forEach(col => {
      const cardCat = (col.getAttribute('data-category') || '').toLowerCase();
      const cardType = (col.getAttribute('data-type') || '').toLowerCase();

      let matchCat = (selectedCat === 'all' || cardCat === selectedCat);
      let matchType = (selectedType === 'all' || cardType === selectedType);

      if (matchCat && matchType) {
        col.classList.remove('d-none');
        visibleCount++;
      } else {
        col.classList.add('d-none');
      }
    });

    const badge = document.getElementById('examCountBadge');
    if (badge) {
      badge.textContent = `${visibleCount} Sınav`;
    }
  }

  if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
  if (typeFilter) typeFilter.addEventListener('change', applyFilters);
}

/* ==========================================================================
   4. Favori Yıldız Butonları
   ========================================================================== */
function initFavoriteButtons() {
  const favBtns = document.querySelectorAll('.btn-box-fav');
  favBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      btn.classList.toggle('active');
      const icon = btn.querySelector('i');
      if (btn.classList.contains('active')) {
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
        showToast('Favorilere Eklendi', 'Bu deneme sınavı favorilerinize kaydedildi.');
      } else {
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
      }
    });
  });
}

/* ==========================================================================
   5. Canlı Sınav Simülasyonu Motoru (Exam Runner)
   ========================================================================== */
const SAMPLE_QUESTIONS = {
  'tevhid-muhafizlari': [
    {
      q: 'Tevhid inancının İslam dinindeki temel anlamı aşağıdakilerden hangisidir?',
      options: [
        'A) Allah’ın birliğini, eşi ve benzeri olmadığını kabul etmek',
        'B) Sadece belirli ibadetleri yerine getirmek',
        'C) Geçmiş kavimlerin tarihlerini ezberlemek',
        'D) Yalnızca dünya hayatı için çalışmak',
        'E) İbadetleri insanlara gösteriş için yapmak'
      ],
      correct: 0,
      topic: 'İnanç'
    },
    {
      q: 'Aşağıdakilerden hangisi güzel ahlaklı bir Müslümanın özelliklerinden biridir?',
      options: [
        'A) Emanete hıyanet etmek',
        'B) Sözünde durmak ve dürüst olmak',
        'C) İnsanların arkasından gıybet etmek',
        'D) Haksızlık karşısında sessiz kalmak',
        'E) Kibirli davranmak'
      ],
      correct: 1,
      topic: 'Ahlak'
    },
    {
      q: 'Peygamber Efendimiz (s.a.v.) Medine’ye hicret ettiğinde Müslümanlar arasında kardeşlik ilan ettiği uygulamanın adı nedir?',
      options: [
        'A) Muâhât (Kardeşlik Sözleşmesi)',
        'B) Rıdvan Biatı',
        'C) Hudeybiye Barışı',
        'D) Akabe Biatları',
        'E) Hilfu\'l-Fudûl'
      ],
      correct: 0,
      topic: 'Siyer'
    },
    {
      q: 'İslam’ın şartlarından biri olan namaz ibadeti günde kaç vakit olarak farz kılınmıştır?',
      options: [
        'A) 3 Vakit',
        'B) 4 Vakit',
        'C) 5 Vakit',
        'D) 6 Vakit',
        'E) 7 Vakit'
      ],
      correct: 2,
      topic: 'İbadet'
    },
    {
      q: 'Kur’an-ı Kerim’de adı geçen ilk peygamber aşağıdakilerden hangisidir?',
      options: [
        'A) Hz. İbrahim (a.s.)',
        'B) Hz. Nuh (a.s.)',
        'C) Hz. Musa (a.s.)',
        'D) Hz. Adem (a.s.)',
        'E) Hz. İsa (a.s.)'
      ],
      correct: 3,
      topic: 'Peygamberler'
    }
  ]
};

let currentExamState = {
  book: 'tevhid-muhafizlari',
  title: 'Tevhid Muhafızları Deneme Sınavı',
  currentQuestionIndex: 0,
  userAnswers: {},
  timerSeconds: 900,
  timerInterval: null
};

function initExamSimulation() {
  const launchButtons = document.querySelectorAll('.btn-sinav-katil, #btnQuickStartExam');

  launchButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const bookKey = btn.getAttribute('data-book') || 'genel';
      window.location.href = `sinav-ekrani.html?sinav=${encodeURIComponent(bookKey)}`;
    });
  });

  const btnPrev = document.getElementById('examBtnPrev');
  const btnNext = document.getElementById('examBtnNext');
  const btnFinish = document.getElementById('examBtnFinish');

  if (btnPrev) {
    btnPrev.addEventListener('click', () => {
      if (currentExamState.currentQuestionIndex > 0) {
        currentExamState.currentQuestionIndex--;
        renderCurrentQuestion();
      }
    });
  }

  if (btnNext) {
    btnNext.addEventListener('click', () => {
      const questions = SAMPLE_QUESTIONS[currentExamState.book] || SAMPLE_QUESTIONS['tevhid-muhafizlari'];
      if (currentExamState.currentQuestionIndex < questions.length - 1) {
        currentExamState.currentQuestionIndex++;
        renderCurrentQuestion();
      }
    });
  }

  if (btnFinish) {
    btnFinish.addEventListener('click', () => {
      if (confirm('Sınavı bitirmek ve sonuçlarınızı hesaplamak istediğinize emin misiniz?')) {
        finishExamSession();
      }
    });
  }
}

function startExamSession(bookKey, examTitle) {
  currentExamState.book = bookKey;
  currentExamState.title = examTitle;
  currentExamState.currentQuestionIndex = 0;
  currentExamState.userAnswers = {};
  currentExamState.timerSeconds = 900;

  const titleEl = document.getElementById('examRunnerTitle');
  if (titleEl) titleEl.textContent = examTitle;

  const questionView = document.getElementById('examQuestionView');
  const resultView = document.getElementById('examResultView');
  if (questionView) questionView.classList.remove('d-none');
  if (resultView) resultView.classList.add('d-none');

  clearInterval(currentExamState.timerInterval);
  updateTimerDisplay();
  currentExamState.timerInterval = setInterval(() => {
    currentExamState.timerSeconds--;
    updateTimerDisplay();
    if (currentExamState.timerSeconds <= 0) {
      clearInterval(currentExamState.timerInterval);
      alert('Süreniz doldu! Sınavınız otomatik olarak sonlandırılıyor.');
      finishExamSession();
    }
  }, 1000);

  renderQuestionPalette();
  renderCurrentQuestion();
}

function updateTimerDisplay() {
  const timerEl = document.getElementById('examRunnerTimer');
  if (!timerEl) return;
  const mins = Math.floor(currentExamState.timerSeconds / 60);
  const secs = currentExamState.timerSeconds % 60;
  timerEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
}

function renderQuestionPalette() {
  const paletteWrap = document.getElementById('examQuestionPalette');
  if (!paletteWrap) return;
  paletteWrap.innerHTML = '';

  const questions = SAMPLE_QUESTIONS[currentExamState.book] || SAMPLE_QUESTIONS['tevhid-muhafizlari'];
  questions.forEach((_, idx) => {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = `btn-palette-num ${idx === currentExamState.currentQuestionIndex ? 'current' : ''}`;
    btn.textContent = idx + 1;
    btn.addEventListener('click', () => {
      currentExamState.currentQuestionIndex = idx;
      renderCurrentQuestion();
    });
    paletteWrap.appendChild(btn);
  });
}

function renderCurrentQuestion() {
  const questions = SAMPLE_QUESTIONS[currentExamState.book] || SAMPLE_QUESTIONS['tevhid-muhafizlari'];
  const qData = questions[currentExamState.currentQuestionIndex];
  if (!qData) return;

  const countEl = document.getElementById('examQuestionNumber');
  const topicEl = document.getElementById('examQuestionTopic');
  if (countEl) countEl.textContent = `Soru ${currentExamState.currentQuestionIndex + 1} / ${questions.length}`;
  if (topicEl) topicEl.textContent = qData.topic;

  const textEl = document.getElementById('examQuestionText');
  if (textEl) textEl.textContent = qData.q;

  const optWrap = document.getElementById('examOptionsWrap');
  if (optWrap) {
    optWrap.innerHTML = '';
    const selectedOpt = currentExamState.userAnswers[currentExamState.currentQuestionIndex];

    qData.options.forEach((optText, optIdx) => {
      const optLabel = document.createElement('label');
      optLabel.className = `exam-option-item ${selectedOpt === optIdx ? 'selected' : ''}`;
      
      const radio = document.createElement('input');
      radio.type = 'radio';
      radio.name = 'examOptionGroup';
      radio.checked = selectedOpt === optIdx;
      radio.style.display = 'none';

      const circle = document.createElement('span');
      circle.className = 'exam-option-circle';
      circle.textContent = String.fromCharCode(65 + optIdx);

      const textSpan = document.createElement('span');
      textSpan.className = 'exam-option-text';
      textSpan.textContent = optText.substring(3);

      optLabel.appendChild(radio);
      optLabel.appendChild(circle);
      optLabel.appendChild(textSpan);

      optLabel.addEventListener('click', () => {
        currentExamState.userAnswers[currentExamState.currentQuestionIndex] = optIdx;
        renderCurrentQuestion();
        updatePaletteStatus();
      });

      optWrap.appendChild(optLabel);
    });
  }

  const btnPrev = document.getElementById('examBtnPrev');
  const btnNext = document.getElementById('examBtnNext');
  if (btnPrev) btnPrev.disabled = currentExamState.currentQuestionIndex === 0;
  if (btnNext) {
    if (currentExamState.currentQuestionIndex === questions.length - 1) {
      btnNext.classList.add('d-none');
    } else {
      btnNext.classList.remove('d-none');
    }
  }

  updatePaletteStatus();
}

function updatePaletteStatus() {
  const paletteBtns = document.querySelectorAll('.btn-palette-num');
  paletteBtns.forEach((btn, idx) => {
    btn.classList.remove('current', 'answered');
    if (idx === currentExamState.currentQuestionIndex) {
      btn.classList.add('current');
    }
    if (currentExamState.userAnswers[idx] !== undefined) {
      btn.classList.add('answered');
    }
  });
}

function finishExamSession() {
  clearInterval(currentExamState.timerInterval);

  const questions = SAMPLE_QUESTIONS[currentExamState.book] || SAMPLE_QUESTIONS['tevhid-muhafizlari'];
  let dogru = 0;
  let yanlis = 0;
  let bos = 0;

  questions.forEach((q, idx) => {
    const ans = currentExamState.userAnswers[idx];
    if (ans === undefined) {
      bos++;
    } else if (ans === q.correct) {
      dogru++;
    } else {
      yanlis++;
    }
  });

  const net = (dogru - (yanlis * 0.25)).toFixed(2);
  const puan = ((net / questions.length) * 100).toFixed(1);
  const basari = Math.round((dogru / questions.length) * 100);

  const questionView = document.getElementById('examQuestionView');
  const resultView = document.getElementById('examResultView');
  if (questionView) questionView.classList.add('d-none');
  if (resultView) resultView.classList.remove('d-none');

  document.getElementById('resDogru').textContent = dogru;
  document.getElementById('resYanlis').textContent = yanlis;
  document.getElementById('resBos').textContent = bos;
  document.getElementById('resNet').textContent = net;
  document.getElementById('resPuan').textContent = puan;
  document.getElementById('resBasari').textContent = `%${basari}`;
}

/* ==========================================================================
   6. Konu Seç, Sınav Çöz Modalı
   ========================================================================== */
function initTopicSelector() {
  const topicPills = document.querySelectorAll('.sinav-topic-capsule, #btnQuickTopicExam, #btnQuickQuestion, #btnQuickQuestionNav');
  const modalEl = document.getElementById('topicTestModal');

  topicPills.forEach(pill => {
    pill.addEventListener('click', (e) => {
      e.preventDefault();
      const topicName = pill.getAttribute('data-topic') || 'İnanç ve Değerler';
      const topicTitleEl = document.getElementById('topicModalTitle');
      if (topicTitleEl) topicTitleEl.textContent = topicName;
      if (modalEl) {
        const topicModal = bootstrap.Modal.getOrCreateInstance(modalEl);
        topicModal.show();
      }
    });
  });

  const btnStartTopicTest = document.getElementById('btnStartTopicTest');
  if (btnStartTopicTest) {
    btnStartTopicTest.addEventListener('click', () => {
      const topicTitleEl = document.getElementById('topicModalTitle');
      const topicName = topicTitleEl ? topicTitleEl.textContent : 'İnanç ve Değerler';
      window.location.href = `sinav-ekrani.html?topic=${encodeURIComponent(topicName)}`;
    });
  }
}

/* ==========================================================================
   7. Deneme Takvimi Modalı
   ========================================================================== */
function initCalendarModal() {
  const btnCalendar = document.getElementById('btnViewCalendar');
  const modalEl = document.getElementById('calendarModal');

  if (btnCalendar && modalEl) {
    btnCalendar.addEventListener('click', (e) => {
      e.preventDefault();
      const calendarModal = bootstrap.Modal.getOrCreateInstance(modalEl);
      calendarModal.show();
    });
  }
}

/* ==========================================================================
   8. Sol Menü & Modallar Bağlantı Yöneticisi
   ========================================================================== */
function initDetailedResultModal() {
  const btnDetail = document.getElementById('btnViewDetailedResult');
  const btnSidebarResults = document.getElementById('btnSidebarResultsNav');
  const modalResults = document.getElementById('detailedResultModal');

  [btnDetail, btnSidebarResults].forEach(btn => {
    if (btn && modalResults) {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const instance = bootstrap.Modal.getOrCreateInstance(modalResults);
        instance.show();
      });
    }
  });

  // Yanlışlarım Modalı
  const btnWrong = document.getElementById('btnSidebarWrongNav');
  const modalWrong = document.getElementById('wrongQuestionsModal');
  if (btnWrong && modalWrong) {
    btnWrong.addEventListener('click', (e) => {
      e.preventDefault();
      const instance = bootstrap.Modal.getOrCreateInstance(modalWrong);
      instance.show();
    });
  }

  // Favorilerim Modalı
  const btnFavorites = document.getElementById('btnSidebarFavoritesNav');
  const modalFavorites = document.getElementById('favoritesModal');
  if (btnFavorites && modalFavorites) {
    btnFavorites.addEventListener('click', (e) => {
      e.preventDefault();
      const instance = bootstrap.Modal.getOrCreateInstance(modalFavorites);
      instance.show();
    });
  }

  // Konu Analizim Modalı
  const btnTopicAnalysis = document.getElementById('btnSidebarTopicAnalysisNav');
  const modalTopicAnalysis = document.getElementById('topicAnalysisModal');
  if (btnTopicAnalysis && modalTopicAnalysis) {
    btnTopicAnalysis.addEventListener('click', (e) => {
      e.preventDefault();
      const instance = bootstrap.Modal.getOrCreateInstance(modalTopicAnalysis);
      instance.show();
    });
  }

  // Raporlarım Modalı
  const btnReports = document.getElementById('btnSidebarReportsNav');
  const modalReports = document.getElementById('reportsModal');
  if (btnReports && modalReports) {
    btnReports.addEventListener('click', (e) => {
      e.preventDefault();
      const instance = bootstrap.Modal.getOrCreateInstance(modalReports);
      instance.show();
    });
  }
}

/* ==========================================================================
   9. Grafik Noktaları Tooltip Etkileşimi
   ========================================================================== */
function initChartInteractions() {
  const dots = document.querySelectorAll('.sinav-chart-dot-point');
  dots.forEach(dot => {
    dot.addEventListener('mouseenter', () => {
      const val = dot.getAttribute('data-val') || '85';
      const day = dot.getAttribute('data-day') || 'Gün';
      dot.setAttribute('title', `${day}: ${val} Puan`);
    });
  });
}

/* ==========================================================================
   10. Mobil Kenar Çubuğu (Bootstrap Offcanvas Entegrasyonu)
   ========================================================================== */
function initMobileSidebarToggle() {
  const sidebar = document.getElementById('sinavLeftSidebar');
  const navLinks = sidebar ? sidebar.querySelectorAll('.sinav-nav-link') : [];

  // Mobilde menü bağlantısına tıklandığında offcanvas'ı otomatik kapat
  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 992 && sidebar) {
        const offcanvas = bootstrap.Offcanvas.getInstance(sidebar);
        if (offcanvas) offcanvas.hide();
      }
    });
  });
}

function showToast(title, msg) {
  const toastContainer = document.getElementById('sinavToastContainer');
  if (!toastContainer) return;

  const toast = document.createElement('div');
  toast.className = 'sinav-custom-toast';
  toast.innerHTML = `
    <div class="text-success"><i class="fa-solid fa-circle-check fs-5"></i></div>
    <div>
      <div class="fw-bold small text-dark">${title}</div>
      <div class="text-muted" style="font-size: 0.72rem;">${msg}</div>
    </div>
  `;
  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-10px)';
    setTimeout(() => toast.remove(), 300);
  }, 2500);
}
