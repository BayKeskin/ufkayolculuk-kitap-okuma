/**
 * UFKA YOLCULUK - KİTAP OKUYUCU VE DİNAMİK CANLI OKUMA MOTORU
 * reader.js (Canlı REST API Entegrasyonlu, Mock Verisiz, Çift Sayfalı Motor)
 */

document.addEventListener('DOMContentLoaded', () => {
  window.UfkaReader = new BookReaderEngine();
  window.UfkaReader.init();
});

class BookReaderEngine {
  constructor() {
    this.books = {};
    this.pageCache = new Map();
    this.audioSyncData = new Map();
    this.pageTimestamps = {};
    this.isLoadingSync = false;

    // 1. Canlı API kitap kütüphanesini oluştur
    this.buildBooksLibrary();

    // 2. window.ACTIVE_BOOK sayfalarını önbelleğe ekle (Canlı API verisi)
    if (window.ACTIVE_BOOK && Array.isArray(window.ACTIVE_BOOK.pages)) {
      const aId = parseInt(window.ACTIVE_BOOK.id, 10);
      window.ACTIVE_BOOK.pages.forEach(p => {
        const pNo = parseInt(p.page_no, 10);
        if (!isNaN(pNo)) {
          this.pageCache.set(`${aId}_${pNo}`, {
            image: p.image || `https://ufkayolculuk.com/uploads/2025-09/pdf_page_${aId}_${pNo}.jpg`,
            body: p.body_html || p.body || '',
            pageNo: pNo
          });
        }
      });
    }

    // 3. Varsayılan aktif kitap ve başlangıç sayfası
    this.currentBookKey = window.ACTIVE_BOOK ? String(window.ACTIVE_BOOK.id) : '11';
    this.currentBook = this.books[this.currentBookKey] || Object.values(this.books)[0] || {
      id: '11',
      apiId: 11,
      title: 'Tevhid Muhafızları',
      startPage: 5,
      totalPages: 185,
      audioSrc: '',
      coverImg: 'assets/images/books/book-tevhid-muhafizlari.svg',
      chapters: []
    };

    const minPage = this.currentBook.startPage || 1;
    this.currentPage = (window.TARGET_PAGE !== undefined && window.TARGET_PAGE !== null && !isNaN(window.TARGET_PAGE) && window.TARGET_PAGE >= 1)
      ? parseInt(window.TARGET_PAGE, 10)
      : minPage;

    this.isSliding = false;
    this.viewMode = 'visual'; // 'visual' veya 'text'
    this.theme = localStorage.getItem('ufka_reader_theme') || 'light';
    this.autoPageTurn = true;
    this.isZoomed = false;
    this.isFullscreen = false;

    // Ses Oynatıcı
    this.audio = new Audio();
    this.audio.preload = 'auto';
    this.isPlaying = false;
    this.playbackSpeeds = [1.0, 1.25, 1.5, 1.75, 2.0];
    this.speedIndex = 0;
  }

  getBaseUrl() {
    if (window.BASE_URL) return window.BASE_URL;
    const path = window.location.pathname;
    if (path.includes('/kitap-okuma/')) return '/kitap-okuma/';
    return '/';
  }

  /**
   * Kitap kütüphanesini dinamik window.ALL_BOOKS_LIST ve window.ACTIVE_BOOK ile inşa eder
   */
  buildBooksLibrary() {
    this.books = {};
    const list = (window.ALL_BOOKS_LIST && Array.isArray(window.ALL_BOOKS_LIST) && window.ALL_BOOKS_LIST.length > 0)
      ? window.ALL_BOOKS_LIST
      : (window.ACTIVE_BOOK ? [window.ACTIVE_BOOK] : []);

    list.forEach(b => {
      const bId = String(b.id);
      const bStart = b.start_page ? parseInt(b.start_page, 10) : 1;
      const bTotal = b.total_pages ? parseInt(b.total_pages, 10) : (Array.isArray(b.pages) ? b.pages.length : 185);
      const bSound = b.sound_file || '';
      const bCover = b.cover_image || b.image || 'assets/images/books/book-tevhid-muhafizlari.svg';
      const bLevel = b.level || 'Tüm Düzeyler';

      let badgeColor = '#f59e0b';
      if (b.category_slug === 'ilkokul' || bId === '8') badgeColor = '#10b981';
      else if (b.category_slug === 'ortaokul' || bId === '11') badgeColor = '#f59e0b';
      else if (b.category_slug === 'lise' || bId === '12') badgeColor = '#6366f1';
      else if (b.category_slug === 'yetiskin' || bId === '13') badgeColor = '#8b5cf6';

      const chapters = (Array.isArray(b.chapters) && b.chapters.length > 0) ? b.chapters : [
        { title: `Bölüm 1 - ${b.name || b.title}`, page: bStart, time: 0 }
      ];

      const item = {
        id: bId,
        apiId: parseInt(b.id, 10),
        title: b.name || b.title,
        level: bLevel,
        badgeColor: badgeColor,
        startPage: bStart,
        totalPages: bTotal,
        audioSrc: bSound,
        coverImg: bCover,
        author: b.author || 'Ufka Yolculuk Yayınları',
        chapters: chapters
      };

      this.books[bId] = item;
      if (b.slug) this.books[b.slug] = item;
    });

    // Slug eşlemeleri
    const slugMap = {
      'kuslarin-cagrisi': '8',
      'tevhid-muhafizlari': '11',
      'gordugume-gormedigime': '12',
      'nasil-inanmali': '13'
    };
    Object.keys(slugMap).forEach(slug => {
      const id = slugMap[slug];
      if (this.books[id] && !this.books[slug]) {
        this.books[slug] = this.books[id];
      }
    });
  }

  /**
   * Başlatıcı
   */
  async init() {
    this.parseUrlParams();
    this.applyTheme(this.theme);
    this.setupDOMElements();
    this.initAudioPlayer();
    this.setupEventListeners();
    this.renderChaptersDrawer();
    this.renderThumbnailsGrid();

    // Sayfa ve ses zaman damgalarını canlı API'den yükle
    await this.loadBookPagesAndSync(this.currentBook.apiId);

    // İlk çift/tek sayfa spread renderı
    await this.renderSpread(this.currentPage, 'init');
    this.updateUI();
    this.preloadAdjacentPages();

    // Eğer başlangıç sayfası 1'den farklıysa sesi o sayfanın zamanına ayarla
    if (this.currentPage > 1) {
      const pTime = this.getPageAudioStartTime(this.currentPage);
      if (pTime !== null && pTime > 0) {
        this.audio.currentTime = pTime;
      }
    }

    if (this.autoAudio) {
      setTimeout(() => {
        if (this.btnPlayMaster && !this.isPlaying) {
          this.btnPlayMaster.click();
        }
      }, 500);
    }
  }

  parseUrlParams() {
    const params = new URLSearchParams(window.location.search);
    let bookParam = params.get('book_id') || params.get('book') || params.get('id');
    const pageParam = parseInt(params.get('page') || params.get('start_page'), 10);
    this.autoAudio = params.get('audio') === '1' || params.get('play') === '1' || (window.AUTO_AUDIO === true);

    const slugMap = {
      'kuslarin-cagrisi': '8',
      'ilkokul': '8',
      'tevhid-muhafizlari': '11',
      'ortaokul': '11',
      'gordugume-gormedigime': '12',
      'lise': '12',
      'nasil-inanmali': '13',
      'yetiskin': '13'
    };

    if (bookParam && slugMap[bookParam]) {
      bookParam = slugMap[bookParam];
    }

    if (bookParam && this.books[bookParam]) {
      this.currentBookKey = bookParam;
      this.currentBook = this.books[bookParam];
    } else if (window.ACTIVE_BOOK && this.books[String(window.ACTIVE_BOOK.id)]) {
      this.currentBookKey = String(window.ACTIVE_BOOK.id);
      this.currentBook = this.books[this.currentBookKey];
    }

    const minPage = this.currentBook.startPage || 1;

    if (!isNaN(pageParam) && pageParam >= 1 && pageParam <= this.currentBook.totalPages) {
      this.currentPage = pageParam;
    } else if (window.TARGET_PAGE && !isNaN(window.TARGET_PAGE) && window.TARGET_PAGE >= 1) {
      this.currentPage = parseInt(window.TARGET_PAGE, 10);
    } else {
      this.currentPage = minPage;
    }
  }

  setupDOMElements() {
    this.leftPageFrame = document.getElementById('leftPageFrame');
    this.rightPageFrame = document.getElementById('rightPageFrame');
    this.leftPageScan = document.getElementById('leftPageScan');
    this.rightPageScan = document.getElementById('rightPageScan');
    this.leftPageText = document.getElementById('leftPageText');
    this.rightPageText = document.getElementById('rightPageText');
    this.leftPageNumber = document.getElementById('leftPageNumber');
    this.rightPageNumber = document.getElementById('rightPageNumber');
    this.leftPageChapter = document.getElementById('leftPageChapter');
    this.rightPageChapter = document.getElementById('rightPageChapter');

    this.bookTitleEl = document.getElementById('currentBookTitle');
    this.bookBadgeEl = document.getElementById('currentBookBadge');
    this.bookAuthorEl = document.getElementById('currentBookAuthor');
    this.dockAudioTitle = document.getElementById('dockAudioTitle');
    this.dockAudioCover = document.getElementById('dockAudioCover');

    this.btnPrev = document.getElementById('btnPrev');
    this.btnNext = document.getElementById('btnNext');
    this.edgePrevBtn = document.getElementById('edgePrevBtn');
    this.edgeNextBtn = document.getElementById('edgeNextBtn');
    this.dockPageDisplay = document.getElementById('dockPageDisplay');
    this.quickJumpInput = document.getElementById('quickJumpInput');

    this.sliderTrack = document.getElementById('dockSliderTrack');
    this.sliderFill = document.getElementById('dockSliderFill');
    this.sliderThumb = document.getElementById('dockSliderThumb');
    this.topProgressBar = document.getElementById('readingProgressFill');

    this.btnPlayMaster = document.getElementById('btnPlayMaster');
    this.btnRewind10 = document.getElementById('btnRewind10');
    this.btnForward10 = document.getElementById('btnForward10');
    this.audioProgressBar = document.getElementById('dockAudioProgressBar');
    this.audioProgressFill = document.getElementById('dockAudioProgressFill');
    this.audioCurrentTime = document.getElementById('dockAudioCurrentTime');
    this.audioDuration = document.getElementById('dockAudioDuration');
    this.btnSpeed = document.getElementById('dockSpeedBtn');
    this.autoTurnCheckbox = document.getElementById('autoTurnCheckbox');

    this.drawerToc = document.getElementById('drawerToc');
    this.drawerOverlay = document.getElementById('drawerOverlay');
    this.modalThumbnails = document.getElementById('modalThumbnails');
  }

  initAudioPlayer() {
    this.audio.src = this.currentBook.audioSrc || '';
    this.audio.playbackRate = this.playbackSpeeds[this.speedIndex];

    this.audio.addEventListener('loadedmetadata', () => {
      if (this.audioDuration) {
        this.audioDuration.textContent = this.formatTime(this.audio.duration);
      }
    });

    this.audio.addEventListener('timeupdate', () => {
      this.handleAudioTimeUpdate();
    });

    this.audio.addEventListener('play', () => {
      this.isPlaying = true;
      this.updatePlayButtonUI();
    });

    this.audio.addEventListener('pause', () => {
      this.isPlaying = false;
      this.updatePlayButtonUI();
    });

    this.audio.addEventListener('ended', () => {
      this.isPlaying = false;
      this.updatePlayButtonUI();
    });
  }

  handleAudioTimeUpdate() {
    const cur = this.audio.currentTime;
    const dur = this.audio.duration || 1;

    if (this.audioProgressFill) {
      this.audioProgressFill.style.width = `${(cur / dur) * 100}%`;
    }
    if (this.audioCurrentTime) {
      this.audioCurrentTime.textContent = this.formatTime(cur);
    }

    // Aktif cümleleri (.subtitlePart) anlık vurgula
    const activeSubtitles = document.querySelectorAll('.subtitlePart');
    let foundActive = false;

    activeSubtitles.forEach(el => {
      const t1 = parseFloat(el.getAttribute('data-time'));
      const t2 = parseFloat(el.getAttribute('data-time2')) || (t1 + 4.0);

      if (cur >= t1 - 0.15 && cur <= t2 + 0.15) {
        if (!el.classList.contains('active-sentence')) {
          activeSubtitles.forEach(s => s.classList.remove('active-sentence'));
          el.classList.add('active-sentence');
          if (this.viewMode === 'text') {
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          }
        }
        foundActive = true;
      }
    });

    if (!foundActive) {
      activeSubtitles.forEach(s => s.classList.remove('active-sentence'));
    }

    // Ses ilerledikçe sıradaki sayfaya geçme kontrolü
    if (this.autoPageTurn && !this.isSliding && this.isPlaying) {
      this.checkAutoPageTurn(cur);
    }
  }

  checkAutoPageTurn(currentTime) {
    if (!this.autoPageTurn || this.isSliding || !this.pageTimestamps || Object.keys(this.pageTimestamps).length === 0) {
      return;
    }

    const isSinglePage = window.innerWidth <= 1080;
    const curLeft = this.currentPage;
    const curRight = isSinglePage ? curLeft : curLeft + 1;

    // Sesin o an denk geldiği sayfa numarasını bul
    const matchedPage = this.findPageForTime(currentTime);
    if (matchedPage !== null && matchedPage > curRight && matchedPage <= this.currentBook.totalPages) {
      // Ses ekrandaki spread'i geçmiş, sayfayı senkronize çevir (syncAudio = false çünkü ses zaten akıyor)
      this.goToPage(matchedPage, false);
    }
  }

  /**
   * Belirli bir ses saniyesinin hangi sayfaya denk geldiğini hesaplar
   */
  findPageForTime(currentTime) {
    if (!this.pageTimestamps || Object.keys(this.pageTimestamps).length === 0) {
      return null;
    }

    const pages = Object.keys(this.pageTimestamps).map(Number).sort((a, b) => a - b);
    let matched = null;

    for (let i = 0; i < pages.length; i++) {
      const p = pages[i];
      const stamp = this.pageTimestamps[p];
      const start = typeof stamp === 'object' ? stamp.start : stamp;
      let end = typeof stamp === 'object' ? stamp.end : null;

      if (end === null || end === undefined) {
        end = (i < pages.length - 1) ? (typeof this.pageTimestamps[pages[i + 1]] === 'object' ? this.pageTimestamps[pages[i + 1]].start : this.pageTimestamps[pages[i + 1]]) : 999999;
      }

      if (currentTime >= start - 0.15 && currentTime < end) {
        matched = p;
        break;
      }
    }
    return matched;
  }

  /**
   * Kitabın tüm sayfalarını ve ses-zaman damgalarını canlı API'den tek seferde yükler
   */
  async loadBookPagesAndSync(bookApiId) {
    try {
      const url = `${this.getBaseUrl()}api/v1/books/${bookApiId}/pages`;
      const response = await fetch(url, { cache: 'default' });
      if (response.ok) {
        const json = await response.json();
        if (json) {
          if (Array.isArray(json.pages)) {
            json.pages.forEach(p => {
              const pNo = parseInt(p.page_no, 10);
              if (!isNaN(pNo)) {
                this.pageCache.set(`${bookApiId}_${pNo}`, {
                  image: p.image || `https://ufkayolculuk.com/uploads/2025-09/pdf_page_${bookApiId}_${pNo}.jpg`,
                  body: p.body_html || p.body || '',
                  pageNo: pNo
                });
              }
            });
          }
          if (json.page_timestamps && typeof json.page_timestamps === 'object') {
            this.pageTimestamps = json.page_timestamps;
          }
        }
      }
    } catch (e) {
      console.warn('Sayfa ve zaman haritası API isteği başarısız:', e);
    }

    // Eğer pageTimestamps henüz boşsa arka planda audio-sync çek
    if (!this.pageTimestamps || Object.keys(this.pageTimestamps).length === 0) {
      this.fetchAudioSyncInBackground(bookApiId);
    }
  }

  async fetchAudioSyncInBackground(bookApiId) {
    if (this.isLoadingSync) return;
    this.isLoadingSync = true;
    try {
      const url = `${this.getBaseUrl()}api/v1/books/${bookApiId}/audio-sync`;
      const res = await fetch(url);
      if (res.ok) {
        const data = await res.json();
        if (data && data.page_timestamps && typeof data.page_timestamps === 'object') {
          this.pageTimestamps = data.page_timestamps;
        }
      }
    } catch (e) {
      console.warn('Audio-sync arka plan isteği başarısız:', e);
    } finally {
      this.isLoadingSync = false;
    }
  }

  /**
   * Canlı API üzerinden sayfa verisini getirir (Tamamen Dinamik REST API)
   */
  async getPageData(bookApiId, pageNum) {
    const cacheKey = `${bookApiId}_${pageNum}`;
    if (this.pageCache.has(cacheKey)) {
      return this.pageCache.get(cacheKey);
    }

    // Canlı CodeIgniter REST API'sinden sayfaları çek
    try {
      const url = `${this.getBaseUrl()}api/v1/books/${bookApiId}/pages`;
      const response = await fetch(url, { cache: 'default' });
      if (response.ok) {
        const json = await response.json();
        if (json) {
          if (Array.isArray(json.pages)) {
            json.pages.forEach(p => {
              const pNo = parseInt(p.page_no, 10);
              if (!isNaN(pNo)) {
                this.pageCache.set(`${bookApiId}_${pNo}`, {
                  image: p.image || `https://ufkayolculuk.com/uploads/2025-09/pdf_page_${bookApiId}_${pNo}.jpg`,
                  body: p.body_html || p.body || '',
                  pageNo: pNo
                });
              }
            });
          }
          if (json.page_timestamps && typeof json.page_timestamps === 'object') {
            this.pageTimestamps = json.page_timestamps;
          }
          if (this.pageCache.has(cacheKey)) {
            return this.pageCache.get(cacheKey);
          }
        }
      }
    } catch (e) {
      console.warn(`Sayfa ${pageNum} API isteği başarısız:`, e);
    }

    // Fallback: Doğrudan taranmış sayfa görseli bağlantısı
    const fallback = {
      image: `https://ufkayolculuk.com/uploads/2025-09/pdf_page_${bookApiId}_${pageNum}.jpg`,
      body: '',
      pageNo: pageNum
    };
    this.pageCache.set(cacheKey, fallback);
    return fallback;
  }

  /**
   * Çift sayfa (Sol & Sağ) render motoru
   */
  async renderSpread(leftPageNum, direction = 'next') {
    if (this.isSliding) return;
    this.isSliding = true;

    const minPage = 1;
    const totalPages = this.currentBook.totalPages;
    const leftNum = Math.max(minPage, Math.min(totalPages, leftPageNum));
    const isSinglePage = window.innerWidth <= 1080;
    const rightNum = (!isSinglePage && leftNum + 1 <= totalPages) ? leftNum + 1 : null;

    const [leftData, rightData] = await Promise.all([
      this.getPageData(this.currentBook.apiId, leftNum),
      rightNum ? this.getPageData(this.currentBook.apiId, rightNum) : Promise.resolve(null)
    ]);

    if (direction === 'next' && direction !== 'init') {
      this.leftPageFrame.classList.add('slide-shift-left');
      if (this.rightPageFrame) this.rightPageFrame.classList.add('slide-incoming-right');
    } else if (direction === 'prev') {
      this.leftPageFrame.classList.add('slide-incoming-left');
      if (this.rightPageFrame) this.rightPageFrame.classList.add('slide-shift-right');
    }

    // Sol Sayfa
    this.leftPageNumber.textContent = `Sayfa ${leftNum}`;
    this.leftPageScan.src = leftData.image;
    this.leftPageScan.alt = `Sayfa ${leftNum}`;
    this.leftPageScan.onerror = () => {
      this.leftPageScan.src = this.currentBook.coverImg;
    };
    this.leftPageText.innerHTML = leftData.body || `<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>`;
    this.leftPageChapter.textContent = this.findChapterTitle(leftNum);
    if (this.bookAuthorEl) this.bookAuthorEl.textContent = this.currentBook.author;

    // Sağ Sayfa (Masaüstünde çift sayfa, mobilde/dar ekranda tek sayfa)
    const rightBookTitleEl = document.getElementById('rightPageBookTitle');
    if (rightData && !isSinglePage) {
      this.rightPageNumber.textContent = `Sayfa ${rightNum}`;
      this.rightPageScan.src = rightData.image;
      this.rightPageScan.alt = `Sayfa ${rightNum}`;
      this.rightPageScan.style.display = '';
      this.rightPageScan.onerror = () => {
        this.rightPageScan.src = this.currentBook.coverImg;
      };
      this.rightPageText.innerHTML = rightData.body || `<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>`;
      this.rightPageChapter.textContent = this.findChapterTitle(rightNum);
      if (rightBookTitleEl) rightBookTitleEl.textContent = this.currentBook.title;
      this.rightPageFrame.style.opacity = '1';
    } else {
      if (this.rightPageNumber) this.rightPageNumber.textContent = '';
      if (this.rightPageScan) {
        this.rightPageScan.src = '';
        this.rightPageScan.style.display = 'none';
      }
      if (this.rightPageText) this.rightPageText.innerHTML = isSinglePage ? '' : `<div class="p-5 text-center text-muted"><em>Kitap Sonu</em></div>`;
      if (this.rightPageChapter) this.rightPageChapter.textContent = '';
      if (rightBookTitleEl) rightBookTitleEl.textContent = '';
      if (this.rightPageFrame) this.rightPageFrame.style.opacity = isSinglePage ? '1' : '0.4';
    }

    this.applyViewMode();

    setTimeout(() => {
      this.leftPageFrame.classList.remove('slide-shift-left', 'slide-incoming-left');
      if (this.rightPageFrame) this.rightPageFrame.classList.remove('slide-incoming-right', 'slide-shift-right');
      this.isSliding = false;
    }, 450);

    this.currentPage = leftNum;
    this.updateUI();
    this.preloadAdjacentPages();
    localStorage.setItem(`ufka_last_page_${this.currentBookKey}`, this.currentPage);
  }

  /**
   * Sayfa çevirme: Masaüstünde 2 sayfa, mobilde 1 sayfa
   */
  async turnPage(direction, syncAudio = true) {
    if (this.isSliding) return;
    const minPage = 1;
    const totalPages = this.currentBook.totalPages;
    const isSinglePage = window.innerWidth <= 1080;
    const step = isSinglePage ? 1 : 2;

    if (direction === 'next') {
      if (this.currentPage >= totalPages) return;
      const targetPage = Math.min(totalPages, this.currentPage + step);
      await this.renderSpread(targetPage, 'next');

      if (syncAudio) {
        this.syncAudioToPage(targetPage);
      }
    } else if (direction === 'prev') {
      if (this.currentPage <= minPage) return;
      const targetPage = Math.max(minPage, this.currentPage - step);
      await this.renderSpread(targetPage, 'prev');

      if (syncAudio) {
        this.syncAudioToPage(targetPage);
      }
    }
  }

  async goToPage(pageNum, syncAudio = true) {
    const minPage = 1;
    let targetPage = parseInt(pageNum, 10);
    if (isNaN(targetPage) || targetPage < minPage) {
      targetPage = minPage;
    }
    if (targetPage > this.currentBook.totalPages) {
      targetPage = this.currentBook.totalPages;
    }
    if (this.quickJumpInput) {
      this.quickJumpInput.value = targetPage;
    }
    const direction = targetPage >= this.currentPage ? 'next' : 'prev';
    await this.renderSpread(targetPage, direction);

    if (syncAudio) {
      this.syncAudioToPage(targetPage);
    }
  }

  async syncAudioToPage(pageNum, forcePlay = false) {
    const targetTime = this.getPageAudioStartTime(pageNum);

    if (targetTime !== null && targetTime !== undefined && !isNaN(targetTime)) {
      this.audio.currentTime = targetTime;
    }
    if (forcePlay || this.isPlaying) {
      this.audio.play().catch(e => console.log('Oynatma kısıtlaması:', e));
    }
    // DİKKAT: targetTime bulunamazsa asla currentTime = 0 yapılmaz! Mevcut ses korunur!
  }

  /**
   * Sayfanın ses başlangıç zaman damgasını hesaplar (Zaman yoksa asla 0'a sarmaz!)
   */
  getPageAudioStartTime(pageNum) {
    const p = parseInt(pageNum, 10);
    if (isNaN(p) || p < 1) return 0;

    // 1. pageTimestamps haritasında tam eşleşme
    if (this.pageTimestamps && this.pageTimestamps[p]) {
      const stamp = this.pageTimestamps[p];
      const start = typeof stamp === 'object' ? stamp.start : stamp;
      if (start !== null && start !== undefined && !isNaN(start)) {
        return parseFloat(start);
      }
    }

    // 2. Sayfanın HTML body'si cache'de varsa
    const cacheKey = `${this.currentBook.apiId}_${p}`;
    if (this.pageCache.has(cacheKey)) {
      const pData = this.pageCache.get(cacheKey);
      if (pData && pData.body) {
        const ext = this.extractFirstDataTime(pData.body);
        if (ext !== null) return ext;
      }
    }

    // 3. Bölüm bilgisi varsa ve sayfa tam eşleşiyorsa
    const chap = this.findChapterForPage(p);
    if (chap && chap.page === p && chap.time >= 0) {
      return chap.time;
    }

    // 4. Eğer sayfa metinsizse (kapak, illüstrasyon, vb.):
    if (this.pageTimestamps && Object.keys(this.pageTimestamps).length > 0) {
      // a) Önceki sayfalarda ses ara
      for (let prevP = p - 1; prevP >= 1; prevP--) {
        if (this.pageTimestamps[prevP]) {
          const stamp = this.pageTimestamps[prevP];
          const val = typeof stamp === 'object' ? (stamp.end || stamp.start) : stamp;
          if (val !== null && val !== undefined && !isNaN(val)) {
            return parseFloat(val);
          }
        }
      }

      // b) Eğer p henüz ilk sesli sayfadan küçükse (kapak/önsöz), ilk ses zamanını (0) dön
      const audioPages = Object.keys(this.pageTimestamps).map(Number);
      const firstAudioP = Math.min(...audioPages);
      if (p <= firstAudioP) {
        const firstStamp = this.pageTimestamps[firstAudioP];
        const val = typeof firstStamp === 'object' ? firstStamp.start : firstStamp;
        return parseFloat(val || 0);
      }
    }

    return 0;
  }

  extractFirstDataTime(htmlString) {
    if (!htmlString) return null;
    const temp = document.createElement('div');
    temp.innerHTML = htmlString;
    const anchor = temp.querySelector('a[data-time], .subtitlePart[data-time]');
    if (anchor) {
      const t = parseFloat(anchor.getAttribute('data-time'));
      return isNaN(t) ? null : t;
    }
    return null;
  }

  findChapterTitle(pageNum) {
    const chap = this.findChapterForPage(pageNum);
    return chap ? chap.title : this.currentBook.title;
  }

  findChapterForPage(pageNum) {
    const chapters = this.currentBook.chapters || [];
    let currentChap = chapters[0];
    for (let i = 0; i < chapters.length; i++) {
      if (pageNum >= chapters[i].page) {
        currentChap = chapters[i];
      } else {
        break;
      }
    }
    return currentChap;
  }

  updateUI() {
    const total = this.currentBook.totalPages;
    const minPage = this.currentBook.startPage || 1;
    const leftP = this.currentPage;
    const isSinglePage = window.innerWidth <= 1080;
    const rightP = (!isSinglePage && leftP + 1 <= total) ? leftP + 1 : null;

    if (this.bookTitleEl) this.bookTitleEl.textContent = this.currentBook.title;
    if (this.bookBadgeEl) {
      this.bookBadgeEl.textContent = this.currentBook.level;
      this.bookBadgeEl.style.backgroundColor = this.currentBook.badgeColor;
    }
    if (this.bookAuthorEl) this.bookAuthorEl.textContent = this.currentBook.author;
    if (this.dockAudioTitle) this.dockAudioTitle.textContent = `${this.currentBook.title} - Sayfa ${leftP}`;
    if (this.dockAudioCover) this.dockAudioCover.src = this.currentBook.coverImg;

    if (this.dockPageDisplay) {
      if (isSinglePage || rightP === null) {
        this.dockPageDisplay.innerHTML = `<span class="cur-badge">Sayfa ${leftP}</span> / <span>${total}</span>`;
      } else {
        this.dockPageDisplay.innerHTML = `<span class="cur-badge">Sayfa ${leftP} - ${rightP}</span> / <span>${total}</span>`;
      }
    }
    if (this.quickJumpInput) {
      this.quickJumpInput.value = leftP;
      this.quickJumpInput.min = 1;
      this.quickJumpInput.max = total;
    }

    const progressPercent = ((leftP - minPage) / Math.max(1, total - minPage)) * 100;
    if (this.topProgressBar) {
      this.topProgressBar.style.width = `${Math.max(2, progressPercent)}%`;
    }
    if (this.sliderFill) {
      this.sliderFill.style.width = `${Math.max(2, progressPercent)}%`;
    }
    if (this.sliderThumb) {
      this.sliderThumb.style.left = `${Math.max(0, Math.min(100, progressPercent))}%`;
    }

    const isFirst = leftP <= 1;
    const isLast = leftP >= total;

    if (this.btnPrev) this.btnPrev.disabled = isFirst;
    if (this.edgePrevBtn) this.edgePrevBtn.disabled = isFirst;
    if (this.btnNext) this.btnNext.disabled = isLast;
    if (this.edgeNextBtn) this.edgeNextBtn.disabled = isLast;

    const newUrl = `${window.location.pathname}?book=${this.currentBook.id}&page=${leftP}`;
    window.history.replaceState({ page: leftP, book: this.currentBook.id }, '', newUrl);
  }

  async preloadAdjacentPages() {
    const cur = this.currentPage;
    const total = this.currentBook.totalPages;
    const preloadList = [cur + 1, cur + 2, cur + 3, cur + 4, cur - 1, cur - 2];

    for (const p of preloadList) {
      if (p >= 1 && p <= total) {
        this.getPageData(this.currentBook.apiId, p).catch(() => {});
      }
    }
  }

  async applyViewMode() {
    const isText = this.viewMode === 'text';

    if (isText) {
      this.leftPageScan.classList.add('d-none');
      this.leftPageText.classList.remove('d-none');
      if (this.rightPageScan) this.rightPageScan.classList.add('d-none');
      if (this.rightPageText) this.rightPageText.classList.remove('d-none');

      // Metin moduna geçildiğinde sol ve sağ sayfanın zengin metinlerini canlı yükle
      this.ensurePageTextLoaded(this.currentPage, this.leftPageText);
      const isSinglePage = window.innerWidth <= 1080;
      if (!isSinglePage && this.currentPage + 1 <= this.currentBook.totalPages) {
        this.ensurePageTextLoaded(this.currentPage + 1, this.rightPageText);
      }
    } else {
      this.leftPageScan.classList.remove('d-none');
      this.leftPageText.classList.add('d-none');
      if (this.rightPageScan && this.rightPageNumber && this.rightPageNumber.textContent !== '') {
        this.rightPageScan.classList.remove('d-none');
      }
      if (this.rightPageText) this.rightPageText.classList.add('d-none');
    }

    const btnToggle = document.getElementById('btnToggleViewMode');
    if (btnToggle) {
      btnToggle.innerHTML = isText 
        ? '<i class="fa-solid fa-image"></i> <span>Görsel Mod</span>' 
        : '<i class="fa-solid fa-align-left"></i> <span>Metin Modu</span>';
    }
  }

  /**
   * Sayfanın zengin metnini canlı REST API'den yükleyip sayfaya enjekte eder
   */
  async ensurePageTextLoaded(pageNum, targetElement) {
    if (!pageNum || !targetElement) return;
    const cacheKey = `${this.currentBook.apiId}_${pageNum}`;
    let pData = this.pageCache.get(cacheKey);

    // Eğer cache'de metin doluysa bas
    if (pData && pData.body && pData.body.trim().length > 0) {
      targetElement.innerHTML = pData.body;
      return;
    }

    // Cache'de metin yoksa API'den çek
    try {
      const url = `${this.getBaseUrl()}api/v1/books/${this.currentBook.apiId}/page-text/${pageNum}`;
      const res = await fetch(url);
      if (res.ok) {
        const json = await res.json();
        if (json && json.body_html && json.body_html.trim().length > 0) {
          if (!pData) {
            pData = {
              image: `https://ufkayolculuk.com/uploads/2025-09/pdf_page_${this.currentBook.apiId}_${pageNum}.jpg`,
              pageNo: pageNum
            };
          }
          pData.body = json.body_html;
          this.pageCache.set(cacheKey, pData);
          targetElement.innerHTML = json.body_html;
          return;
        }
      }
    } catch (e) {
      console.warn(`Sayfa ${pageNum} metni yüklenemedi:`, e);
    }

    // Eğer sayfada metin yoksa (resim/illüstrasyon)
    if (!targetElement.innerHTML || targetElement.innerHTML.trim() === '' || targetElement.innerHTML.includes('fa-circle-notch')) {
      targetElement.innerHTML = `<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>`;
    }
  }

  applyTheme(themeName) {
    this.theme = themeName;
    document.body.setAttribute('data-theme', themeName);
    localStorage.setItem('ufka_reader_theme', themeName);
  }

  updatePlayButtonUI() {
    if (!this.btnPlayMaster) return;
    const icon = this.btnPlayMaster.querySelector('i');
    if (this.isPlaying) {
      this.btnPlayMaster.classList.add('playing');
      if (icon) icon.className = 'fa-solid fa-pause';
    } else {
      this.btnPlayMaster.classList.remove('playing');
      if (icon) icon.className = 'fa-solid fa-play';
    }
  }

  formatTime(secs) {
    if (isNaN(secs) || secs < 0) return '00:00';
    const m = Math.floor(secs / 60);
    const s = Math.floor(secs % 60);
    return `${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
  }

  async changeBook(bookKey, startPage = null) {
    if (!this.books[bookKey]) {
      window.location.href = `kitap-oku?book_id=${bookKey}${startPage ? '&start_page=' + startPage : ''}`;
      return;
    }
    this.currentBookKey = bookKey;
    this.currentBook = this.books[bookKey];
    this.currentPage = (startPage && !isNaN(startPage)) ? parseInt(startPage, 10) : (this.currentBook.startPage || 1);

    this.audio.pause();
    this.audio.src = this.currentBook.audioSrc || '';
    if (this.currentBook.audioSrc) {
      this.audio.load();
    }
    this.isPlaying = false;
    this.updatePlayButtonUI();

    document.querySelectorAll('[data-switch-book]').forEach(item => {
      const isAct = item.getAttribute('data-switch-book') == this.currentBook.id || item.getAttribute('data-switch-book') == this.currentBookKey;
      item.classList.toggle('active', isAct);
    });

    this.pageTimestamps = {};
    await this.loadBookPagesAndSync(this.currentBook.apiId);

    this.renderChaptersDrawer();
    this.renderThumbnailsGrid();
    await this.renderSpread(this.currentPage, 'init');

    const pTime = this.getPageAudioStartTime(this.currentPage);
    if (pTime !== null && pTime >= 0) {
      this.audio.currentTime = pTime;
    }

    this.updateUI();
  }

  renderChaptersDrawer() {
    const list = document.getElementById('drawerChaptersList');
    if (!list) return;

    list.innerHTML = '';
    this.currentBook.chapters.forEach((chap) => {
      const a = document.createElement('a');
      a.className = 'chapter-item-link';
      a.href = 'javascript:void(0)';
      a.dataset.page = chap.page;
      a.innerHTML = `
        <span>${chap.title}</span>
        <span class="chap-page">S. ${chap.page}</span>
      `;
      a.addEventListener('click', () => {
        this.goToPage(chap.page);
        this.closeDrawer();
      });
      list.appendChild(a);
    });
  }

  renderThumbnailsGrid() {
    const grid = document.getElementById('thumbnailsGrid');
    if (!grid) return;

    grid.innerHTML = '';
    const minPage = this.currentBook.startPage || 1;
    const total = this.currentBook.totalPages;

    for (let i = minPage; i <= Math.min(total, minPage + 50); i++) {
      const card = document.createElement('div');
      card.className = 'thumb-card-item';
      if (i === this.currentPage) card.classList.add('active');

      const cacheKey = `${this.currentBook.apiId}_${i}`;
      let imgSrc = this.currentBook.coverImg;
      if (this.pageCache.has(cacheKey) && this.pageCache.get(cacheKey).image) {
        imgSrc = this.pageCache.get(cacheKey).image;
      } else {
        imgSrc = `https://ufkayolculuk.com/uploads/2025-09/pdf_page_${this.currentBook.apiId}_${i}.jpg`;
      }

      card.innerHTML = `
        <img src="${imgSrc}" 
             alt="Sayfa ${i}" 
             loading="lazy" 
             onerror="this.src='${this.currentBook.coverImg}'">
        <span>Sayfa ${i}</span>
      `;
      card.addEventListener('click', () => {
        this.goToPage(i);
        const modalEl = document.getElementById('modalThumbnails');
        if (modalEl && window.bootstrap) {
          const m = bootstrap.Modal.getInstance(modalEl);
          if (m) m.hide();
        }
      });
      grid.appendChild(card);
    }
  }

  setupEventListeners() {
    if (this.btnNext) this.btnNext.addEventListener('click', () => this.turnPage('next'));
    if (this.btnPrev) this.btnPrev.addEventListener('click', () => this.turnPage('prev'));
    if (this.edgeNextBtn) this.edgeNextBtn.addEventListener('click', () => this.turnPage('next'));
    if (this.edgePrevBtn) this.edgePrevBtn.addEventListener('click', () => this.turnPage('prev'));

    if (this.btnPlayMaster) {
      this.btnPlayMaster.addEventListener('click', () => {
        if (this.isPlaying) {
          this.audio.pause();
        } else {
          if (this.audio.currentTime === 0) {
            this.syncAudioToPage(this.currentPage, true);
          } else {
            this.audio.play().catch(e => console.log('Oynatma hatası:', e));
          }
        }
      });
    }

    if (this.btnRewind10) {
      this.btnRewind10.addEventListener('click', () => {
        this.audio.currentTime = Math.max(0, this.audio.currentTime - 10);
      });
    }

    if (this.btnForward10) {
      this.btnForward10.addEventListener('click', () => {
        this.audio.currentTime = Math.min(this.audio.duration || 9999, this.audio.currentTime + 10);
      });
    }

    if (this.btnSpeed) {
      this.btnSpeed.addEventListener('click', () => {
        this.speedIndex = (this.speedIndex + 1) % this.playbackSpeeds.length;
        const speed = this.playbackSpeeds[this.speedIndex];
        this.audio.playbackRate = speed;
        this.btnSpeed.textContent = `${speed}x`;
      });
    }

    if (this.autoTurnCheckbox) {
      this.autoTurnCheckbox.addEventListener('change', (e) => {
        this.autoPageTurn = e.target.checked;
      });
    }

    if (this.audioProgressBar) {
      this.audioProgressBar.addEventListener('click', (e) => {
        const rect = this.audioProgressBar.getBoundingClientRect();
        const percent = (e.clientX - rect.left) / rect.width;
        if (this.audio.duration) {
          this.audio.currentTime = percent * this.audio.duration;
        }
      });
    }

    if (this.sliderTrack) {
      this.sliderTrack.addEventListener('click', (e) => {
        const rect = this.sliderTrack.getBoundingClientRect();
        const percent = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
        const minP = this.currentBook.startPage || 1;
        const targetPage = Math.max(minP, Math.round(minP + percent * (this.currentBook.totalPages - minP)));
        this.goToPage(targetPage);
      });
    }

    if (this.quickJumpInput) {
      const enforceMinMax = () => {
        const minP = this.currentBook.startPage || 1;
        const maxP = this.currentBook.totalPages;
        let val = parseInt(this.quickJumpInput.value, 10);
        if (isNaN(val) || val < minP) {
          val = minP;
          this.quickJumpInput.value = minP;
        } else if (val > maxP) {
          val = maxP;
          this.quickJumpInput.value = maxP;
        }
        return val;
      };

      this.quickJumpInput.addEventListener('change', () => {
        const val = enforceMinMax();
        this.goToPage(val);
      });

      this.quickJumpInput.addEventListener('blur', () => {
        enforceMinMax();
      });

      this.quickJumpInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          const val = enforceMinMax();
          this.goToPage(val);
        }
      });
    }

    // Metin modunda cümleye tıklandığında sesi o saniyeye atlat
    document.addEventListener('click', (e) => {
      const sub = e.target.closest('.subtitlePart');
      if (sub) {
        e.preventDefault();
        const t = parseFloat(sub.getAttribute('data-time'));
        if (!isNaN(t)) {
          this.audio.currentTime = t;
          this.audio.play().catch(() => {});
        }
      }
    });

    const btnToggleViewMode = document.getElementById('btnToggleViewMode');
    if (btnToggleViewMode) {
      btnToggleViewMode.addEventListener('click', () => {
        this.viewMode = this.viewMode === 'visual' ? 'text' : 'visual';
        this.applyViewMode();
      });
    }

    document.querySelectorAll('[data-theme-select]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const t = btn.getAttribute('data-theme-select');
        this.applyTheme(t);
      });
    });

    const btnOpenToc = document.getElementById('btnOpenToc');
    const btnCloseToc = document.getElementById('btnCloseDrawer');
    if (btnOpenToc) btnOpenToc.addEventListener('click', () => this.openDrawer());
    if (btnCloseToc) btnCloseToc.addEventListener('click', () => this.closeDrawer());
    if (this.drawerOverlay) this.drawerOverlay.addEventListener('click', () => this.closeDrawer());

    document.querySelectorAll('[data-switch-book]').forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const bookKey = link.getAttribute('data-switch-book');
        const href = link.getAttribute('href') || '';
        let startP = null;
        if (href.includes('start_page=')) {
          startP = (new URLSearchParams(href.split('?')[1])).get('start_page');
        }
        this.changeBook(bookKey, startP ? parseInt(startP, 10) : null);
      });
    });

    window.addEventListener('resize', () => {
      this.updateUI();
    });

    window.addEventListener('popstate', (e) => {
      if (e.state && e.state.page) {
        if (e.state.book && String(e.state.book) !== String(this.currentBook.id)) {
          this.changeBook(String(e.state.book), e.state.page);
        } else {
          this.goToPage(e.state.page, false);
        }
      }
    });

    const btnFullscreen = document.getElementById('btnFullscreen');
    if (btnFullscreen) {
      btnFullscreen.addEventListener('click', () => this.toggleFullscreen());
    }

    const syncFullscreenState = () => {
      const isFull = !!(document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement);
      document.body.classList.toggle('fullscreen-active', isFull);
      this.isFullscreen = isFull;
      if (btnFullscreen) {
        const icon = btnFullscreen.querySelector('i');
        if (icon) icon.className = isFull ? 'fa-solid fa-compress' : 'fa-solid fa-expand';
      }
    };

    document.addEventListener('fullscreenchange', syncFullscreenState);
    document.addEventListener('webkitfullscreenchange', syncFullscreenState);
    document.addEventListener('mozfullscreenchange', syncFullscreenState);
    document.addEventListener('MSFullscreenChange', syncFullscreenState);

    const btnZoom = document.getElementById('btnZoom');
    if (btnZoom) {
      btnZoom.addEventListener('click', () => this.toggleZoom());
    }

    document.addEventListener('keydown', (e) => {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

      switch (e.key) {
        case 'Escape':
          if (document.body.classList.contains('fullscreen-active')) {
            document.body.classList.remove('fullscreen-active');
            this.isFullscreen = false;
            if (document.fullscreenElement && document.exitFullscreen) {
              document.exitFullscreen().catch(() => {});
            }
          }
          break;
        case 'ArrowRight':
          e.preventDefault();
          this.turnPage('next');
          break;
        case 'ArrowLeft':
          e.preventDefault();
          this.turnPage('prev');
          break;
        case ' ':
          e.preventDefault();
          if (this.btnPlayMaster) this.btnPlayMaster.click();
          break;
        case 'f':
        case 'F':
          this.toggleFullscreen();
          break;
        case 't':
        case 'T':
          if (btnToggleViewMode) btnToggleViewMode.click();
          break;
      }
    });

    const stage = document.querySelector('.reader-main-stage');
    if (stage) {
      stage.addEventListener('touchstart', (e) => {
        this.touchStartX = e.touches[0].clientX;
        this.touchStartY = e.touches[0].clientY;
      }, { passive: true });

      stage.addEventListener('touchend', (e) => {
        const deltaX = e.changedTouches[0].clientX - this.touchStartX;
        const deltaY = e.changedTouches[0].clientY - this.touchStartY;

        if (Math.abs(deltaX) > 50 && Math.abs(deltaX) > Math.abs(deltaY)) {
          if (deltaX < 0) {
            this.turnPage('next');
          } else {
            this.turnPage('prev');
          }
        }
      }, { passive: true });
    }
  }

  openDrawer() {
    if (this.drawerToc) this.drawerToc.classList.add('open');
    if (this.drawerOverlay) this.drawerOverlay.classList.add('open');
  }

  closeDrawer() {
    if (this.drawerToc) this.drawerToc.classList.remove('open');
    if (this.drawerOverlay) this.drawerOverlay.classList.remove('open');
  }

  toggleFullscreen() {
    const isFull = !!(document.fullscreenElement || document.webkitFullscreenElement);
    if (!isFull) {
      const docEl = document.documentElement;
      if (docEl.requestFullscreen) {
        docEl.requestFullscreen().catch(() => {});
      } else if (docEl.webkitRequestFullscreen) {
        docEl.webkitRequestFullscreen();
      }
      document.body.classList.add('fullscreen-active');
      this.isFullscreen = true;
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen().catch(() => {});
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
      document.body.classList.remove('fullscreen-active');
      this.isFullscreen = false;
    }
  }

  toggleZoom() {
    this.isZoomed = !this.isZoomed;
    document.body.classList.toggle('zoom-mode', this.isZoomed);
  }
}
