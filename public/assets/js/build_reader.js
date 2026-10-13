const fs = require('fs');
const path = require('path');

const tevhidCache = fs.readFileSync(path.join(__dirname, 'tevhid_cache.json'), 'utf8');

const code = `/**
 * UFKA YOLCULUK - KİTAP OKUYUCU VE SENKRONİZE SESLİ DİNLENME MOTORU
 * reader.js (Tam Sayfa Önbelleği & 163MB Orijinal Ses Senkronu)
 */

// Tevhid Muhafızları 185 Sayfalık Tam Cümle ve Zaman Damgası Önbelleği
const SEED_CACHE = ${tevhidCache};

document.addEventListener('DOMContentLoaded', () => {
  window.UfkaReader = new BookReaderEngine();
  window.UfkaReader.init();
});

class BookReaderEngine {
  constructor() {
    // Kitap Tanımları
    this.books = {
      'tevhid-muhafizlari': {
        id: 'tevhid-muhafizlari',
        apiId: 11,
        title: 'Tevhid Muhafızları',
        level: 'Ortaokul Düzeyi',
        badgeColor: '#f59e0b',
        startPage: 5,
        totalPages: 185,
        audioSrc: 'assets/audio/tevhid-muhafizlari.mp3?v=163mb_official',
        coverImg: 'assets/images/books/book-tevhid-muhafizlari.svg',
        author: 'Ufka Yolculuk Yayınları',
        chapters: [
          { title: '1. Bölüm - Boş Damacana', page: 5, time: 2.313 },
          { title: 'Sayfa 10 - Açlık ve Emniyet', page: 10, time: 379.95 },
          { title: 'Sayfa 20 - Tevekkül Notu', page: 20, time: 1228.72 },
          { title: 'Sayfa 35 - Peygamber Sevgisi', page: 35, time: 2394.5 },
          { title: 'Sayfa 50 - İmanın Tadı', page: 50, time: 3481.4 },
          { title: 'Sayfa 70 - İmtihan ve Sabır', page: 70, time: 5047.7 },
          { title: 'Sayfa 90 - Zorlukların Sonu', page: 90, time: 6856.4 },
          { title: 'Sayfa 110 - Mahalle Maçı', page: 110, time: 8460.7 },
          { title: 'Sayfa 130 - Şükür ve Sevinç', page: 130, time: 9953.1 },
          { title: 'Sayfa 150 - Keskin Bakışlar', page: 150, time: 11617.9 },
          { title: 'Sayfa 180 - Büyük Heyecan', page: 180, time: 13991.0 }
        ]
      },
      'kuslarin-cagrisi': {
        id: 'kuslarin-cagrisi',
        apiId: 10,
        title: 'Kuşların Çağrısı',
        level: 'İlkokul Düzeyi',
        badgeColor: '#10b981',
        startPage: 1,
        totalPages: 160,
        audioSrc: 'assets/audio/kuslarin-cagrisi-bolum3.mp3?v=2.0',
        coverImg: 'assets/images/books/book-kuslarin-cagrisi.svg',
        author: 'Ufka Yolculuk Yayınları',
        chapters: [
          { title: 'Bölüm 1 - Ormanın Fısıltısı', page: 1, time: 10 },
          { title: 'Bölüm 2 - Kanat Sesleri', page: 22, time: 640 },
          { title: 'Bölüm 3 - Cesaretin Kaynağı', page: 45, time: 1200 },
          { title: 'Bölüm 4 - Gökyüzü Yolcuları', page: 80, time: 1950 },
          { title: 'Bölüm 5 - Dostluğun Gücü', page: 120, time: 2600 }
        ]
      },
      'gordugume-gormedigime': {
        id: 'gordugume-gormedigime',
        apiId: 12,
        title: 'Gördüğüme Görmediğime',
        level: 'Lise Düzeyi',
        badgeColor: '#6366f1',
        startPage: 1,
        totalPages: 190,
        audioSrc: 'assets/audio/gordugume-gormedigime.mp3?v=2.0',
        coverImg: 'assets/images/books/book-gordugume-gormedigime.svg',
        author: 'Ufka Yolculuk Yayınları',
        chapters: [
          { title: 'Bölüm 1 - Aklın Sınırları', page: 1, time: 15 },
          { title: 'Bölüm 2 - Buzdağının Görünmeyen Yüzü', page: 28, time: 720 },
          { title: 'Bölüm 3 - Varlık ve Hakikat', page: 60, time: 1540 },
          { title: 'Bölüm 4 - Şüphenin Ötesi', page: 105, time: 2450 },
          { title: 'Bölüm 5 - Huzurlu Arayış', page: 150, time: 3300 }
        ]
      },
      'nasil-inanmali': {
        id: 'nasil-inanmali',
        apiId: 13,
        title: 'Nasıl İnanmalı?',
        level: 'Yetişkin Düzeyi',
        badgeColor: '#8b5cf6',
        startPage: 1,
        totalPages: 210,
        audioSrc: 'assets/audio/nasil-inanmali.mp3?v=2.0',
        coverImg: 'assets/images/books/book-nasil-inanmali.svg',
        author: 'Ufka Yolculuk Yayınları',
        chapters: [
          { title: 'Bölüm 1 - İnanç ve Akıl Dengesi', page: 1, time: 20 },
          { title: 'Bölüm 2 - Deliller ve İkna', page: 35, time: 820 },
          { title: 'Bölüm 3 - Kalbin Tasdiki', page: 75, time: 1780 },
          { title: 'Bölüm 4 - Modern Çağda İnanç', page: 120, time: 2750 },
          { title: 'Bölüm 5 - Tevhidin Zirvesi', page: 170, time: 3800 }
        ]
      }
    };

    // Aktif Durum
    this.currentBookKey = 'tevhid-muhafizlari';
    this.currentBook = this.books[this.currentBookKey];
    this.currentPage = 5; // Kitap 5. sayfadan başlar
    this.isSliding = false;
    this.viewMode = 'visual'; // 'visual' veya 'text'
    this.theme = localStorage.getItem('ufka_reader_theme') || 'light';
    this.autoPageTurn = true;
    this.isZoomed = false;
    this.isFullscreen = false;

    // Önbellek Başlatma (Pre-seeded 185 sayfa)
    this.pageCache = new Map();
    Object.keys(SEED_CACHE).forEach(p => {
      this.pageCache.set(\`11_\${p}\`, SEED_CACHE[p]);
    });

    // Ses Oynatıcı Nesnesi
    this.audio = new Audio();
    this.audio.preload = 'auto';
    this.isPlaying = false;
    this.playbackSpeeds = [0.75, 1.0, 1.25, 1.5, 2.0];
    this.speedIndex = 1;

    this.touchStartX = 0;
    this.touchStartY = 0;
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
    
    // 5. Sayfayı Yükle
    await this.renderSpread(this.currentPage, 'init');
    this.updateUI();
    this.preloadAdjacentPages();
  }

  parseUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const bookParam = params.get('book') || params.get('id');
    const pageParam = parseInt(params.get('page'), 10);

    if (bookParam && this.books[bookParam]) {
      this.currentBookKey = bookParam;
    }

    this.currentBook = this.books[this.currentBookKey];
    const minPage = this.currentBook.startPage || 1;

    if (!isNaN(pageParam) && pageParam >= minPage && pageParam <= this.currentBook.totalPages) {
      this.currentPage = pageParam;
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
    this.audio.src = this.currentBook.audioSrc;
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
      this.audioProgressFill.style.width = \`\${(cur / dur) * 100}%\`;
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

  async checkAutoPageTurn(currentTime) {
    const rightPageNum = this.currentPage + 1;
    if (rightPageNum > this.currentBook.totalPages) return;

    const rightPageData = await this.getPageData(this.currentBook.apiId, rightPageNum);
    if (!rightPageData || !rightPageData.body) return;

    const rightFirstTime = this.extractFirstDataTime(rightPageData.body);
    // Ses sağ sayfaya geçtiyse sağ sayfayı sol tarafa kaydır
    if (rightFirstTime !== null && currentTime >= rightFirstTime + 0.2) {
      this.turnPage('next', false);
    }
  }

  async getPageData(bookApiId, pageNum) {
    const cacheKey = \`\${bookApiId}_\${pageNum}\`;
    if (this.pageCache.has(cacheKey)) {
      return this.pageCache.get(cacheKey);
    }

    try {
      const response = await fetch(\`https://ufkayolculuk.com/project_ufkayolculuk/getPage/\${bookApiId}/\${pageNum}\`, {
        cache: 'no-store'
      });
      if (response.ok) {
        const data = await response.json();
        const result = {
          image: data.image ? \`https://ufkayolculuk.com/\${data.image}\` : \`https://ufkayolculuk.com/uploads/2025-09/pdf_page_\${bookApiId}_\${pageNum}.jpg\`,
          body: data.body || '',
          pageNo: pageNum
        };
        this.pageCache.set(cacheKey, result);
        return result;
      }
    } catch (e) {
      console.warn(\`Sayfa \${pageNum} yüklenemedi:\`, e);
    }

    const fallback = {
      image: \`https://ufkayolculuk.com/uploads/2025-09/pdf_page_\${bookApiId}_\${pageNum}.jpg\`,
      body: '',
      pageNo: pageNum
    };
    this.pageCache.set(cacheKey, fallback);
    return fallback;
  }

  async renderSpread(leftPageNum, direction = 'next') {
    if (this.isSliding) return;
    this.isSliding = true;

    const minPage = this.currentBook.startPage || 1;
    const leftNum = Math.max(minPage, leftPageNum);
    const rightNum = leftNum + 1 <= this.currentBook.totalPages ? leftNum + 1 : null;

    const [leftData, rightData] = await Promise.all([
      this.getPageData(this.currentBook.apiId, leftNum),
      rightNum ? this.getPageData(this.currentBook.apiId, rightNum) : Promise.resolve(null)
    ]);

    if (direction === 'next' && direction !== 'init') {
      this.leftPageFrame.classList.add('slide-shift-left');
      this.rightPageFrame.classList.add('slide-incoming-right');
    } else if (direction === 'prev') {
      this.leftPageFrame.classList.add('slide-incoming-left');
      this.rightPageFrame.classList.add('slide-shift-right');
    }

    // Sol Sayfa
    this.leftPageNumber.textContent = leftNum;
    this.leftPageScan.src = leftData.image;
    this.leftPageScan.alt = \`Sayfa \${leftNum}\`;
    this.leftPageText.innerHTML = leftData.body || \`<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>\`;
    this.leftPageChapter.textContent = this.findChapterTitle(leftNum);

    // Sağ Sayfa
    if (rightData) {
      this.rightPageNumber.textContent = rightNum;
      this.rightPageScan.src = rightData.image;
      this.rightPageScan.alt = \`Sayfa \${rightNum}\`;
      this.rightPageText.innerHTML = rightData.body || \`<div class="p-4 text-center text-muted"><em>Bu sayfa görsel içerik içermektedir.</em></div>\`;
      this.rightPageChapter.textContent = this.findChapterTitle(rightNum);
      this.rightPageFrame.style.opacity = '1';
    } else {
      this.rightPageNumber.textContent = '';
      this.rightPageScan.src = '';
      this.rightPageText.innerHTML = \`<div class="p-5 text-center text-muted"><em>Kitap Sonu</em></div>\`;
      this.rightPageChapter.textContent = '';
      this.rightPageFrame.style.opacity = '0.4';
    }

    this.applyViewMode();

    setTimeout(() => {
      this.leftPageFrame.classList.remove('slide-shift-left', 'slide-incoming-left');
      this.rightPageFrame.classList.remove('slide-incoming-right', 'slide-shift-right');
      this.isSliding = false;
    }, 450);

    this.currentPage = leftNum;
    this.updateUI();
    this.preloadAdjacentPages();
    localStorage.setItem(\`ufka_last_page_\${this.currentBookKey}\`, this.currentPage);
  }

  async turnPage(direction, syncAudio = true) {
    if (this.isSliding) return;
    const minPage = this.currentBook.startPage || 1;

    if (direction === 'next') {
      if (this.currentPage + 1 > this.currentBook.totalPages) return;
      const targetPage = this.currentPage + 1;
      await this.renderSpread(targetPage, 'next');

      if (syncAudio) {
        this.syncAudioToPage(targetPage);
      }
    } else if (direction === 'prev') {
      if (this.currentPage <= minPage) return;
      const targetPage = this.currentPage - 1;
      await this.renderSpread(targetPage, 'prev');

      if (syncAudio) {
        this.syncAudioToPage(targetPage);
      }
    }
  }

  async goToPage(pageNum, syncAudio = true) {
    const minPage = this.currentBook.startPage || 1;
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

  async syncAudioToPage(pageNum) {
    const pageData = await this.getPageData(this.currentBook.apiId, pageNum);
    let targetTime = null;

    if (pageData && pageData.body) {
      targetTime = this.extractFirstDataTime(pageData.body);
    }

    if (targetTime === null) {
      const chap = this.findChapterForPage(pageNum);
      if (chap) targetTime = chap.time;
    }

    if (targetTime !== null && targetTime !== undefined) {
      this.audio.currentTime = targetTime;
      this.audio.play().catch(e => console.log('Oynatma engellendi:', e));
    }
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
    const rightP = Math.min(leftP + 1, total);

    if (this.bookTitleEl) this.bookTitleEl.textContent = this.currentBook.title;
    if (this.bookBadgeEl) {
      this.bookBadgeEl.textContent = this.currentBook.level;
      this.bookBadgeEl.style.backgroundColor = this.currentBook.badgeColor;
    }
    if (this.bookAuthorEl) this.bookAuthorEl.textContent = this.currentBook.author;
    if (this.dockAudioTitle) this.dockAudioTitle.textContent = \`\${this.currentBook.title} - Sayfa \${leftP}\`;
    if (this.dockAudioCover) this.dockAudioCover.src = this.currentBook.coverImg;

    if (this.dockPageDisplay) {
      this.dockPageDisplay.innerHTML = \`<span class="cur-badge">Sayfa \${leftP}\${rightP > leftP ? ' - ' + rightP : ''}</span> / <span>\${total}</span>\`;
    }
    if (this.quickJumpInput) {
      this.quickJumpInput.value = leftP;
      this.quickJumpInput.min = minPage;
      this.quickJumpInput.max = total;
    }

    const progressPercent = ((leftP - minPage) / (total - minPage)) * 100;
    if (this.topProgressBar) {
      this.topProgressBar.style.width = \`\${Math.max(2, progressPercent)}%\`;
    }
    if (this.sliderFill) {
      this.sliderFill.style.width = \`\${Math.max(2, progressPercent)}%\`;
    }
    if (this.sliderThumb) {
      this.sliderThumb.style.left = \`\${Math.max(0, Math.min(100, progressPercent))}%\`;
    }

    const isFirst = leftP <= minPage;
    const isLast = leftP >= total;

    if (this.btnPrev) this.btnPrev.disabled = isFirst;
    if (this.edgePrevBtn) this.edgePrevBtn.disabled = isFirst;
    if (this.btnNext) this.btnNext.disabled = isLast;
    if (this.edgeNextBtn) this.edgeNextBtn.disabled = isLast;

    const newUrl = \`\${window.location.pathname}?book=\${this.currentBookKey}&page=\${leftP}\`;
    window.history.replaceState({ page: leftP, book: this.currentBookKey }, '', newUrl);

    this.updateActiveChapterInDrawer();
  }

  async preloadAdjacentPages() {
    const cur = this.currentPage;
    const total = this.currentBook.totalPages;
    const preloadList = [cur + 1, cur + 2, cur + 3, cur + 4, cur - 1, cur - 2];

    for (const p of preloadList) {
      if (p >= 5 && p <= total) {
        this.getPageData(this.currentBook.apiId, p).catch(() => {});
      }
    }
  }

  applyViewMode() {
    const isText = this.viewMode === 'text';

    if (isText) {
      this.leftPageScan.classList.add('d-none');
      this.leftPageText.classList.remove('d-none');
      this.rightPageScan.classList.add('d-none');
      this.rightPageText.classList.remove('d-none');
    } else {
      this.leftPageScan.classList.remove('d-none');
      this.leftPageText.classList.add('d-none');
      this.rightPageScan.classList.remove('d-none');
      this.rightPageText.classList.add('d-none');
    }

    const btnToggle = document.getElementById('btnToggleViewMode');
    if (btnToggle) {
      btnToggle.innerHTML = isText 
        ? '<i class="fa-solid fa-image"></i> <span>Görsel Mod</span>' 
        : '<i class="fa-solid fa-align-left"></i> <span>Metin Modu</span>';
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
    return \`\${m < 10 ? '0' : ''}\${m}:\${s < 10 ? '0' : ''}\${s}\`;
  }

  async changeBook(bookKey) {
    if (!this.books[bookKey]) return;
    this.currentBookKey = bookKey;
    this.currentBook = this.books[bookKey];
    this.currentPage = this.currentBook.startPage || 1;

    this.audio.pause();
    this.audio.src = this.currentBook.audioSrc;
    this.audio.load();
    this.isPlaying = false;
    this.updatePlayButtonUI();

    this.renderChaptersDrawer();
    this.renderThumbnailsGrid();
    await this.renderSpread(this.currentPage, 'init');
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
      a.innerHTML = \`
        <span>\${chap.title}</span>
        <span class="chap-page">S. \${chap.page}</span>
      \`;
      a.addEventListener('click', () => {
        this.goToPage(chap.page);
        this.closeDrawer();
      });
      list.appendChild(a);
    });
  }

  updateActiveChapterInDrawer() {
    const curChap = this.findChapterForPage(this.currentPage);
    const links = document.querySelectorAll('.chapter-item-link');
    links.forEach(l => {
      const p = parseInt(l.dataset.page, 10);
      if (curChap && p === curChap.page) {
        l.classList.add('active');
      } else {
        l.classList.remove('active');
      }
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
      card.innerHTML = \`
        <img src="https://ufkayolculuk.com/uploads/2025-09/pdf_page_\${this.currentBook.apiId}_\${i}.jpg" 
             alt="Sayfa \${i}" 
             loading="lazy" 
             onerror="this.src='\${this.currentBook.coverImg}'">
        <span>Sayfa \${i}</span>
      \`;
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
          // Sayfaya senkronla ve oynat
          if (this.audio.currentTime === 0) {
            this.syncAudioToPage(this.currentPage);
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
        this.btnSpeed.textContent = \`\${speed}x\`;
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
        this.changeBook(bookKey);
      });
    });

    const btnFullscreen = document.getElementById('btnFullscreen');
    if (btnFullscreen) {
      btnFullscreen.addEventListener('click', () => this.toggleFullscreen());
    }

    const btnZoom = document.getElementById('btnZoom');
    if (btnZoom) {
      btnZoom.addEventListener('click', () => this.toggleZoom());
    }

    document.addEventListener('keydown', (e) => {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

      switch (e.key) {
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
    if (!document.fullscreenElement) {
      document.documentElement.requestFullscreen().catch(() => {});
      document.body.classList.add('fullscreen-active');
      this.isFullscreen = true;
    } else {
      if (document.exitFullscreen) document.exitFullscreen();
      document.body.classList.remove('fullscreen-active');
      this.isFullscreen = false;
    }
  }

  toggleZoom() {
    this.isZoomed = !this.isZoomed;
    document.body.classList.toggle('zoom-mode', this.isZoomed);
  }
}
`;

fs.writeFileSync(path.join(__dirname, 'reader.js'), code, 'utf8');
console.log('reader.js updated successfully with all 185 cached pages and official 163MB audio sync!');
