/**
 * UFKA YOLCULUK - KİTAP OKUMA VE SESLİ DİNLEME PORTALI
 * Pure Vanilla JavaScript (Saf JS, Sıfır 3. Parti Kütüphane)
 */

document.addEventListener('DOMContentLoaded', () => {
  initAudioPlayer();
  initBooksSlider();
  initHeroMobileSlider();
  initSearchAndFilter();
  initActivityChart();
  initModals();
  initHeaderDropdowns();
  initMobileMenu();
});

/* ==========================================================================
   1. Audio Player Module (Gerçek 163MB Orijinal Ses & Kitapla Canlı Senkronizasyon)
   ========================================================================== */
function initAudioPlayer() {
  const playBtn = document.getElementById('playMasterBtn');
  const playIcon = playBtn ? playBtn.querySelector('i') : null;
  const currentTimeEl = document.getElementById('audioCurrentTime');
  const durationEl = document.getElementById('audioDuration');
  const waveBarsContainer = document.getElementById('waveformBars');
  const speedBtn = document.getElementById('audioSpeedBtn');
  const rewindBtn = document.getElementById('audioRewindBtn');
  const forwardBtn = document.getElementById('audioForwardBtn');
  const livePageText = document.getElementById('audioLivePageText');
  const btnOpenInReader = document.getElementById('btnOpenInReader');

  // Kitap Ses Tanımları
  const BOOK_AUDIO_META = {
    'tevhid-muhafizlari': {
      id: 'tevhid-muhafizlari',
      title: 'Tevhid Muhafızları',
      chapter: '1. Bölüm - Boş Damacana (Sayfa 5)',
      img: 'assets/images/books/book-tevhid-muhafizlari.svg',
      audioUrl: 'assets/audio/tevhid-muhafizlari.mp3',
      startTime: 2.313,
      startPage: 5,
      chapters: [
        { title: '1. Bölüm - Boş Damacana (Sayfa 5)', time: 2.313, page: 5 },
        { title: '2. Bölüm - Açlık ve Emniyet (Sayfa 10)', time: 379.95, page: 10 },
        { title: '3. Bölüm - Tevekkül Notu (Sayfa 20)', time: 1228.72, page: 20 },
        { title: '4. Bölüm - Peygamber Sevgisi (Sayfa 35)', time: 2394.5, page: 35 },
        { title: '5. Bölüm - İmanın Tadı (Sayfa 50)', time: 3481.4, page: 50 },
        { title: '6. Bölüm - İmtihan ve Sabır (Sayfa 70)', time: 5047.7, page: 70 },
        { title: '7. Bölüm - Zorlukların Sonu (Sayfa 90)', time: 6856.4, page: 90 }
      ]
    },
    'kuslarin-cagrisi': {
      id: 'kuslarin-cagrisi',
      title: 'Kuşların Çağrısı',
      chapter: 'Bölüm 1 - Başlangıç ve Yolculuk',
      img: 'assets/images/books/book-kuslarin-cagrisi.svg',
      audioUrl: 'assets/audio/tevhid-muhafizlari.mp3',
      startTime: 2.313,
      startPage: 1,
      chapters: [
        { title: '1. Başlangıç ve Yolculuk (Sayfa 1)', time: 2.313, page: 1 },
        { title: '2. Dostluk Bağı (Sayfa 12)', time: 420.0, page: 12 },
        { title: '3. Cesaretin Kaynağı (Sayfa 25)', time: 950.0, page: 25 }
      ]
    },
    'gordugume-gormedigime': {
      id: 'gordugume-gormedigime',
      title: 'Gördüğüme Görmediğime',
      chapter: 'Bölüm 1 - Giriş ve Hakikat',
      img: 'assets/images/books/book-gordugume-gormedigime.svg',
      audioUrl: 'assets/audio/tevhid-muhafizlari.mp3',
      startTime: 2.313,
      startPage: 1,
      chapters: [
        { title: '1. Giriş ve Hakikat (Sayfa 1)', time: 2.313, page: 1 },
        { title: '2. Buzdağının Görünmeyen Yüzü (Sayfa 18)', time: 650.0, page: 18 }
      ]
    },
    'nasil-inanmali': {
      id: 'nasil-inanmali',
      title: 'Nasıl İnanmalı?',
      chapter: 'Bölüm 1 - İnanç ve Akıl Dengesi',
      img: 'assets/images/books/book-nasil-inanmali.svg',
      audioUrl: 'assets/audio/tevhid-muhafizlari.mp3',
      startTime: 2.313,
      startPage: 1,
      chapters: [
        { title: '1. İnanç ve Akıl Dengesi (Sayfa 1)', time: 2.313, page: 1 },
        { title: '2. Varlık ve Yaratılış (Sayfa 22)', time: 820.0, page: 22 }
      ]
    }
  };

  let currentBookId = 'tevhid-muhafizlari';

  // HTML5 Gerçek Ses Nesnesi (Native Audio Instance)
  const audioElement = new Audio();
  audioElement.preload = 'metadata';
  audioElement.src = BOOK_AUDIO_META['tevhid-muhafizlari'].audioUrl;
  let hasRealAudioSource = true;

  // Durum Yönetimi
  let isPlaying = false;
  let currentSeconds = 2.313;
  let totalSeconds = 13991; // 3 saat 53 dk
  let playbackSpeed = 1.0;
  let simTimer = null;

  const speeds = [1.0, 1.25, 1.5, 2.0];
  let speedIndex = 0;

  function formatTime(secs) {
    if (isNaN(secs) || secs < 0) return '00:00';
    const totalM = Math.floor(secs / 60);
    const h = Math.floor(totalM / 60);
    const m = totalM % 60;
    const s = Math.floor(secs % 60);
    if (h > 0) {
      return `${h}:${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
    }
    return `${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
  }

  // Tevhid Muhafızları 185 Sayfa Tam Zaman Damgaları
  const TEVHID_PAGE_TIMESTAMPS = [
    {page:5,time:2.313},{page:6,time:58.25},{page:7,time:143.758},{page:8,time:224.411},{page:9,time:282.838},
    {page:10,time:379.951},{page:11,time:469.797},{page:12,time:545.328},{page:13,time:623.798},{page:14,time:718.36},
    {page:15,time:762.353},{page:16,time:854.092},{page:17,time:944.345},{page:18,time:1045.049},{page:19,time:1138.798},
    {page:20,time:1228.72},{page:21,time:1309.97},{page:22,time:1410.308},{page:23,time:1480.547},{page:24,time:1563.166},
    {page:25,time:1667.703},{page:26,time:1768.75},{page:27,time:1793.121},{page:28,time:1869.869},{page:29,time:1947.018},
    {page:30,time:2038.801},{page:31,time:2111.217},{page:32,time:2170.55},{page:33,time:2290.194},{page:34,time:2335.228},
    {page:35,time:2394.509},{page:36,time:2488.315},{page:37,time:2560.61},{page:38,time:2643.533},{page:39,time:2701.785},
    {page:40,time:2765.455},{page:41,time:2832.533},{page:42,time:2890.124},{page:43,time:2969.984},{page:44,time:3027.094},
    {page:45,time:3117.489},{page:46,time:3207.748},{page:47,time:3251.785},{page:48,time:3289.278},{page:49,time:3383.997},
    {page:50,time:3481.4},{page:51,time:3550.71},{page:52,time:3592.145},{page:53,time:3635.902},{page:54,time:3727.125},
    {page:55,time:3822.227},{page:56,time:3911.892},{page:57,time:4017.057},{page:58,time:4106.425},{page:59,time:4206.863},
    {page:60,time:4306.618},{page:61,time:4374.568},{page:62,time:4460.143},{page:63,time:4502.908},{page:64,time:4567.925},
    {page:65,time:4665.942},{page:66,time:4746.692},{page:67,time:4817.386},{page:68,time:4880.79},{page:69,time:4968.931},
    {page:70,time:5047.765},{page:71,time:5140.322},{page:72,time:5232.04},{page:73,time:5330.101},{page:74,time:5426.006},
    {page:75,time:5507.429},{page:76,time:5594.99},{page:77,time:5671.702},{page:78,time:5768.39},{page:79,time:5867.844},
    {page:80,time:5960.861},{page:81,time:6045.569},{page:82,time:6142.662},{page:83,time:6227.604},{page:84,time:6307.487},
    {page:85,time:6389.294},{page:86,time:6475.566},{page:87,time:6560.452},{page:88,time:6738.353},{page:90,time:6856.466},
    {page:91,time:6939.511},{page:92,time:7003.358},{page:93,time:7108.057},{page:94,time:7188.248},{page:95,time:7298.302},
    {page:96,time:7372.162},{page:97,time:7434.477},{page:98,time:7530.588},{page:99,time:7593.477},{page:100,time:7676.374},
    {page:101,time:7724.127},{page:102,time:7765.123},{page:103,time:7852.93},{page:104,time:7927.771},{page:105,time:8009.505},
    {page:106,time:8091.948},{page:107,time:8184.999},{page:108,time:8269.355},{page:109,time:8331.712},{page:110,time:8460.761},
    {page:111,time:8504.516},{page:112,time:8573.994},{page:113,time:8649.43},{page:114,time:8722.787},{page:115,time:8799.55},
    {page:116,time:8888.359},{page:117,time:8964.128},{page:118,time:9028.882},{page:119,time:9119.749},{page:120,time:9187.57},
    {page:121,time:9275.763},{page:122,time:9360.29},{page:123,time:9378.701},{page:124,time:9429.292},{page:125,time:9521.513},
    {page:126,time:9618.46},{page:127,time:9714.014},{page:128,time:9777.588},{page:129,time:9867.957},{page:130,time:9953.108},
    {page:131,time:10040.656},{page:132,time:10145.753},{page:133,time:10226.082},{page:134,time:10288.311},{page:135,time:10387.571},
    {page:136,time:10470.479},{page:137,time:10541.844},{page:138,time:10580.757},{page:139,time:10609.462},{page:140,time:10655.598},
    {page:141,time:10761.662},{page:142,time:10853.93},{page:143,time:10956.978},{page:144,time:11075.06},{page:145,time:11154.102},
    {page:146,time:11235.142},{page:147,time:11342.984},{page:148,time:11436.995},{page:149,time:11542.435},{page:150,time:11617.963},
    {page:151,time:11710.806},{page:152,time:11783.742},{page:153,time:11802.803},{page:154,time:11840.524},{page:155,time:11937.676},
    {page:156,time:12030.657},{page:157,time:12104.705},{page:158,time:12185.796},{page:159,time:12278.804},{page:160,time:12363.432},
    {page:161,time:12465.741},{page:162,time:12563.94},{page:163,time:12653.801},{page:164,time:12711.057},{page:165,time:12778.63},
    {page:166,time:12841.632},{page:167,time:12903.47},{page:168,time:12959.307},{page:169,time:13060.117},{page:170,time:13139.47},
    {page:171,time:13232.734},{page:172,time:13341.202},{page:173,time:13409.826},{page:174,time:13511.438},{page:175,time:13604.141},
    {page:176,time:13671.969},{page:177,time:13729.754},{page:178,time:13811.317},{page:179,time:13894.394},{page:180,time:13991.009},
    {page:181,time:14096.339},{page:182,time:14174.002},{page:183,time:14195.821},{page:184,time:14198.024},{page:185,time:14215.972}
  ];

  // Sayfayı Ses Süresine Göre Hesaplama ve Senkronize Etme
  function calculateCurrentPage(time) {
    if (currentBookId === 'tevhid-muhafizlari') {
      if (time < TEVHID_PAGE_TIMESTAMPS[0].time) return 5;
      for (let i = TEVHID_PAGE_TIMESTAMPS.length - 1; i >= 0; i--) {
        if (time >= TEVHID_PAGE_TIMESTAMPS[i].time) {
          return TEVHID_PAGE_TIMESTAMPS[i].page;
        }
      }
      return 5;
    }
    return Math.max(1, Math.floor(time / 60) + 1);
  }

  function updateLiveSyncUI() {
    const page = calculateCurrentPage(currentSeconds);
    if (livePageText) {
      livePageText.innerHTML = `Şu an okunan: <strong class="text-dark">Sayfa ${page}</strong>`;
    }
    if (btnOpenInReader) {
      btnOpenInReader.href = `kitap-oku.html?book=${currentBookId}&page=${page}`;
    }
  }

  // 28 Adet Ses Dalgası Çubuğu (Waveform) Oluşturma
  if (waveBarsContainer) {
    waveBarsContainer.innerHTML = '';
    const barCount = 28;
    const baseHeights = [
      30, 55, 25, 70, 90, 45, 80, 95, 40, 65,
      85, 35, 75, 90, 50, 70, 85, 40, 60, 80,
      45, 90, 60, 75, 85, 35, 60, 80
    ];

    for (let i = 0; i < barCount; i++) {
      const bar = document.createElement('div');
      bar.className = 'wave-bar';
      const height = baseHeights[i % baseHeights.length];
      bar.style.height = `${height}%`;
      bar.dataset.index = i;

      bar.addEventListener('click', (e) => {
        e.stopPropagation();
        const clickedIndex = parseInt(bar.dataset.index, 10);
        const percent = clickedIndex / barCount;
        
        if (hasRealAudioSource && audioElement.duration) {
          audioElement.currentTime = percent * audioElement.duration;
        } else {
          currentSeconds = Math.floor(percent * totalSeconds);
          updateUI();
        }
      });

      waveBarsContainer.appendChild(bar);
    }
  }

  function updateWaveform() {
    if (!waveBarsContainer) return;
    const bars = waveBarsContainer.querySelectorAll('.wave-bar');
    const percent = totalSeconds > 0 ? (currentSeconds / totalSeconds) : 0;
    
    bars.forEach((bar, idx) => {
      const barPercent = idx / bars.length;
      if (barPercent <= percent) {
        bar.classList.add('played');
      } else {
        bar.classList.remove('played');
      }

      if (isPlaying) {
        bar.classList.add('playing');
        bar.style.animationDelay = `${(idx % 5) * 0.15}s`;
      } else {
        bar.classList.remove('playing');
      }
    });
  }

  function updateUI() {
    if (currentTimeEl) currentTimeEl.textContent = formatTime(currentSeconds);
    if (durationEl) durationEl.textContent = formatTime(totalSeconds);
    updateWaveform();
    updateLiveSyncUI();
  }

  // HTML5 Ses Olayları
  audioElement.addEventListener('loadedmetadata', () => {
    hasRealAudioSource = true;
    totalSeconds = audioElement.duration || 13991;
    if (audioElement.currentTime < 1) {
      audioElement.currentTime = 2.313;
    }
    currentSeconds = audioElement.currentTime;
    updateUI();
  });

  audioElement.addEventListener('timeupdate', () => {
    currentSeconds = audioElement.currentTime;
    if (audioElement.duration) {
      totalSeconds = audioElement.duration;
    }
    updateUI();
  });

  audioElement.addEventListener('play', () => {
    isPlaying = true;
    if (playIcon) playIcon.className = 'fa-solid fa-pause';
    updateWaveform();
  });

  audioElement.addEventListener('pause', () => {
    isPlaying = false;
    if (playIcon) playIcon.className = 'fa-solid fa-play';
    updateWaveform();
  });

  audioElement.addEventListener('ended', () => {
    isPlaying = false;
    currentSeconds = 2.313;
    if (playIcon) playIcon.className = 'fa-solid fa-play';
    updateUI();
  });

  function togglePlay() {
    if (audioElement.paused) {
      audioElement.play().catch(() => {
        // Autoplay politikasında kullanıcı etkileşimi sonrası oynatılır
      });
    } else {
      audioElement.pause();
    }
  }

  if (playBtn) {
    playBtn.addEventListener('click', togglePlay);
  }

  if (rewindBtn) {
    rewindBtn.addEventListener('click', () => {
      audioElement.currentTime = Math.max(0, audioElement.currentTime - 10);
    });
  }

  if (forwardBtn) {
    forwardBtn.addEventListener('click', () => {
      audioElement.currentTime = Math.min(totalSeconds, audioElement.currentTime + 10);
    });
  }

  if (speedBtn) {
    speedBtn.addEventListener('click', () => {
      speedIndex = (speedIndex + 1) % speeds.length;
      playbackSpeed = speeds[speedIndex];
      speedBtn.innerHTML = `<strong>${playbackSpeed.toFixed(1)}x</strong> Hız`;
      audioElement.playbackRate = playbackSpeed;
    });
  }

  // Global Parça Değiştirme
  window.playTrack = function(bookId, title, chapter, img, audioUrl, startTime, startPage) {
    currentBookId = bookId || 'tevhid-muhafizlari';
    const titleEl = document.getElementById('currentAudioTitle');
    const chapEl = document.getElementById('currentAudioChapter');
    const thumbEl = document.getElementById('currentAudioThumb');

    if (titleEl) titleEl.textContent = title;
    if (chapEl) chapEl.textContent = chapter;
    if (thumbEl) thumbEl.src = img;

    audioElement.src = audioUrl || 'assets/audio/tevhid-muhafizlari.mp3';
    audioElement.load();
    const st = parseFloat(startTime) || 2.313;
    audioElement.currentTime = st;
    currentSeconds = st;
    updateUI();
    audioElement.play().catch(() => {});
  };

  // Carousel Kitap Kartlarındaki "Sesli Dinle" Butonları
  const listenBtns = document.querySelectorAll('.btn-listen-trigger');
  listenBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const bookId = btn.dataset.bookId || 'tevhid-muhafizlari';
      const bookTitle = btn.dataset.bookTitle || 'Tevhid Muhafızları';
      const bookChapter = btn.dataset.bookChapter || '1. Bölüm - Boş Damacana (Sayfa 5)';
      const bookImg = btn.dataset.bookImg || 'assets/images/books/book-tevhid-muhafizlari.svg';
      const audioUrl = btn.dataset.audioSrc || 'assets/audio/tevhid-muhafizlari.mp3';
      const startTime = btn.dataset.startTime || 2.313;
      const startPage = btn.dataset.startPage || 5;

      window.playTrack(bookId, bookTitle, bookChapter, bookImg, audioUrl, startTime, startPage);

      const playerCard = document.getElementById('audioPlayerSection');
      if (playerCard && window.innerWidth < 992) {
        playerCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  });

  // Bölüm Listesi Drawer'ında Bölüme Tıklama
  const chapterRows = document.querySelectorAll('.chapter-item-row');
  const chapterModal = document.getElementById('chapterListModal');
  chapterRows.forEach(row => {
    row.addEventListener('click', (e) => {
      e.stopPropagation();
      chapterRows.forEach(r => r.classList.remove('active'));
      row.classList.add('active');

      const time = parseFloat(row.dataset.startTime) || 2.313;
      const title = row.dataset.title || '1. Bölüm';
      const chapEl = document.getElementById('currentAudioChapter');
      const thumbEl = document.getElementById('currentAudioThumb');
      const titleEl = document.getElementById('currentAudioTitle');

      if (chapEl) chapEl.textContent = title;
      if (titleEl && !titleEl.textContent) titleEl.textContent = 'Tevhid Muhafızları';
      if (thumbEl && (!thumbEl.src || thumbEl.src.includes('undefined') || !thumbEl.getAttribute('src'))) {
        thumbEl.src = 'assets/images/books/book-tevhid-muhafizlari.svg';
      }

      if (!audioElement.src || audioElement.src === '' || audioElement.src.endsWith('/')) {
        audioElement.src = 'assets/audio/tevhid-muhafizlari.mp3';
      }

      audioElement.currentTime = time;
      currentSeconds = time;
      updateUI();
      audioElement.play().catch(() => {});

      if (chapterModal) chapterModal.classList.remove('show');
    });
  });

  updateUI();
}

/* ==========================================================================
   2. Contest Books Slider / Carousel
   ========================================================================== */
function initBooksSlider() {
  const slider = document.getElementById('contestBooksSlider');
  const prevBtn = document.getElementById('prevBookBtn');
  const nextBtn = document.getElementById('nextBookBtn');

  if (!slider) return;

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      slider.scrollBy({ left: -220, behavior: 'smooth' });
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      slider.scrollBy({ left: 220, behavior: 'smooth' });
    });
  }

  // Mouse Drag Support
  let isDown = false;
  let startX;
  let scrollLeft;

  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });

  slider.addEventListener('mouseleave', () => {
    isDown = false;
  });

  slider.addEventListener('mouseup', () => {
    isDown = false;
  });

  slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 1.5;
    slider.scrollLeft = scrollLeft - walk;
  });
}

/* ==========================================================================
   3. Search and Filter Functionality
   ========================================================================== */
const HOME_SEARCH_BOOKS = [
  { id: 'kuslarin-cagrisi', title: 'Kuşların Çağrısı', category: 'ilkokul', categoryLabel: 'İlkokul Düzeyi', year: '2025', url: 'kitap-oku.html?book=kuslarin-cagrisi&page=1', author: 'Ufka Yolculuk Yayınları' },
  { id: 'tevhid-muhafizlari', title: 'Tevhid Muhafızları', category: 'ortaokul', categoryLabel: 'Ortaokul Düzeyi', year: '2025', url: 'kitap-oku.html?book=tevhid-muhafizlari&page=5', author: 'Ufka Yolculuk Yayınları' },
  { id: 'gordugume-gormedigime', title: 'Gördüğüme Görmediğime', category: 'lise', categoryLabel: 'Lise Düzeyi', year: '2025', url: 'kitap-oku.html?book=gordugume-gormedigime&page=1', author: 'Ufka Yolculuk Yayınları' },
  { id: 'nasil-inanmali', title: 'Nasıl İnanmalı?', category: 'yetiskin', categoryLabel: 'Yetişkin Düzeyi', year: '2025', url: 'kitap-oku.html?book=nasil-inanmali&page=1', author: 'Ufka Yolculuk Yayınları' },
  { id: 'maske-dustu-2024', title: 'Maske Düştü', category: 'ilkokul', categoryLabel: 'İlkokul (2024)', year: '2024', url: 'kitaplar.html?search=Maske+D%C3%BC%C5%9Ft%C3%BC', author: 'Ufka Yolculuk Yayınları' },
  { id: 'zamanin-tozu-2024', title: 'Zamanın Tozu', category: 'ortaokul', categoryLabel: 'Ortaokul (2024)', year: '2024', url: 'kitaplar.html?search=Zaman%C4%B1n+Tozu', author: 'Ufka Yolculuk Yayınları' },
  { id: 'vakit-geldi-2024', title: 'Vakit Geldi', category: 'lise', categoryLabel: 'Lise (2024)', year: '2024', url: 'kitaplar.html?search=Vakit+Geldi', author: 'Ufka Yolculuk Yayınları' },
  { id: 'ilmihal-ibadetler-2024', title: 'İlmihal - İbadet Esasları', category: 'yetiskin', categoryLabel: 'Yetişkin (2024)', year: '2024', url: 'kitaplar.html?search=%C4%B0lmihal', author: 'Ufka Yolculuk Yayınları' },
  { id: 'afiyetle-yasam-2023', title: 'Afiyetle Yaşam', category: 'ilkokul', categoryLabel: 'İlkokul (2023)', year: '2023', url: 'kitaplar.html?search=Afiyetle+Ya%C5%9Fam', author: 'Ufka Yolculuk Yayınları' },
  { id: 'gorev-tamam-2023', title: 'Görev Tamam', category: 'ortaokul', categoryLabel: 'Ortaokul (2023)', year: '2023', url: 'kitaplar.html?search=G%C3%B6rev+Tamam', author: 'Ufka Yolculuk Yayınları' },
  { id: 'saglikli-insan-2023', title: 'Sağlıklı İnsan Sağlıklı Gelecek', category: 'lise', categoryLabel: 'Lise (2023)', year: '2023', url: 'kitaplar.html?search=Sa%C4%9Fl%C4%B1kl%C4%B1+%C4%B0nsan', author: 'Ufka Yolculuk Yayınları' },
  { id: 'bir-kucuk-odul-2022', title: 'Bir Küçük Ödül', category: 'ilkokul', categoryLabel: 'İlkokul (2022)', year: '2022', url: 'kitaplar.html?search=Bir+K%C3%BC%C3%A7%C3%BCk+%C3%96d%C3%BCl', author: 'Ufka Yolculuk Yayınları' }
];

function initSearchAndFilter() {
  const searchInput = document.getElementById('mainSearchInput');
  const categorySelect = document.getElementById('categorySelect');
  const yearSelect = document.getElementById('yearSelect');
  const searchBtn = document.getElementById('searchBtn');
  const dropdown = document.getElementById('homeSearchDropdown');
  const bookCards = document.querySelectorAll('.book-card-item');

  // Başlangıçta tüm yarışma kartlarının opaklığını net (1) yap
  bookCards.forEach(card => {
    card.style.opacity = '1';
  });

  // Arama navigasyonu fonksiyonu
  function executeSearch() {
    const query = (searchInput ? searchInput.value : '').trim();
    const selectedCat = categorySelect ? categorySelect.value : 'all';
    const selectedYear = yearSelect ? yearSelect.value : 'all';

    const params = new URLSearchParams();
    if (query) params.set('search', query);
    if (selectedCat && selectedCat !== 'all') params.set('category', selectedCat);
    if (selectedYear && selectedYear !== 'all') params.set('year', selectedYear);

    const queryString = params.toString();
    window.location.href = `kitaplar.html${queryString ? '?' + queryString : ''}`;
  }

  // Canlı arama öneri menüsünü güncelle (Yarışma kitapları kartlarını ASLA silikleştirmeden)
  function handleSearchInput() {
    const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
    const selectedCat = categorySelect ? categorySelect.value : 'all';
    const selectedYear = yearSelect ? yearSelect.value : 'all';

    if (!dropdown) return;

    if (!query) {
      dropdown.classList.remove('show');
      dropdown.innerHTML = '';
      return;
    }

    const matches = HOME_SEARCH_BOOKS.filter(book => {
      const matchQuery = book.title.toLowerCase().includes(query) ||
                         book.categoryLabel.toLowerCase().includes(query) ||
                         book.author.toLowerCase().includes(query);
      const matchCat = selectedCat === 'all' || book.category === selectedCat;
      const matchYear = selectedYear === 'all' || book.year === selectedYear;
      return matchQuery && matchCat && matchYear;
    });

    if (matches.length > 0) {
      let html = matches.slice(0, 5).map(b => `
        <a href="${b.url}" class="home-search-item">
          <div>
            <div class="home-search-item-title">${b.title}</div>
            <div class="home-search-item-sub">${b.categoryLabel} · ${b.year}</div>
          </div>
          <i class="fa-solid fa-chevron-right text-muted small"></i>
        </a>
      `).join('');

      html += `
        <div class="p-2 border-top bg-light text-center">
          <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none fw-bold p-0" id="btnGoSearchAll">
            Tüm sonuçları kütüphanede gör ("${query}") <i class="fa-solid fa-arrow-right ms-1 small"></i>
          </button>
        </div>
      `;

      dropdown.innerHTML = html;
      dropdown.classList.add('show');

      const btnAll = dropdown.querySelector('#btnGoSearchAll');
      if (btnAll) {
        btnAll.addEventListener('click', executeSearch);
      }
    } else {
      dropdown.innerHTML = `
        <div class="p-3 text-center text-muted small">
          <div>"${query}" ile eşleşen kitap bulunamadı.</div>
          <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none fw-bold mt-1 p-0" id="btnGoSearchNotFound">
            Kütüphane arşivinde ara <i class="fa-solid fa-arrow-right ms-1"></i>
          </button>
        </div>
      `;
      dropdown.classList.add('show');

      const btnNotFound = dropdown.querySelector('#btnGoSearchNotFound');
      if (btnNotFound) {
        btnNotFound.addEventListener('click', executeSearch);
      }
    }
  }

  // Kategori seçildiğinde kartları filtrele (Opaklık değiştirmeden, temiz göster/gizle)
  function handleCategoryFilter() {
    const selectedCat = categorySelect ? categorySelect.value : 'all';

    bookCards.forEach(card => {
      card.style.opacity = '1';
      if (selectedCat === 'all' || card.dataset.category === selectedCat) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });

    if (searchInput && searchInput.value.trim()) {
      handleSearchInput();
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', handleSearchInput);
    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        executeSearch();
      } else if (e.key === 'Escape' && dropdown) {
        dropdown.classList.remove('show');
      }
    });
  }

  if (categorySelect) {
    categorySelect.addEventListener('change', handleCategoryFilter);
  }

  if (yearSelect) {
    yearSelect.addEventListener('change', () => {
      if (searchInput && searchInput.value.trim()) {
        handleSearchInput();
      }
    });
  }

  if (searchBtn) {
    searchBtn.addEventListener('click', executeSearch);
  }

  // Dışarı tıklandığında arama öneri menüsünü kapat
  document.addEventListener('click', (e) => {
    if (dropdown && !e.target.closest('.search-input-wrap')) {
      dropdown.classList.remove('show');
    }
  });
}

/* ==========================================================================
   4. Weekly Activity Spline Chart (Interactive SVG + Tooltips)
   ========================================================================== */
function initActivityChart() {
  const markers = document.querySelectorAll('.chart-dot-marker');
  const tooltip = document.getElementById('chartTooltip');

  const chartData = [
    { day: 'Pazartesi', mins: 180, pages: 22, x: 50, y: 75 },
    { day: 'Salı', mins: 320, pages: 35, x: 100, y: 50 },
    { day: 'Çarşamba', mins: 220, pages: 26, x: 150, y: 68 },
    { day: 'Perşembe', mins: 480, pages: 52, x: 200, y: 25 },
    { day: 'Cuma', mins: 310, pages: 34, x: 250, y: 52 },
    { day: 'Cumartesi', mins: 420, pages: 46, x: 300, y: 35 },
    { day: 'Pazar', mins: 550, pages: 60, x: 350, y: 15 }
  ];

  markers.forEach(marker => {
    marker.addEventListener('mouseenter', (e) => {
      const idx = parseInt(marker.dataset.index, 10);
      const data = chartData[idx];
      if (!data || !tooltip) return;

      tooltip.innerHTML = `<strong>${data.day}</strong>: ${data.mins} dk (${data.pages} sayfa)`;
      tooltip.style.opacity = '1';
      
      const rect = marker.getBoundingClientRect();
      const parentRect = tooltip.parentElement.getBoundingClientRect();
      tooltip.style.left = `${rect.left - parentRect.left + 5}px`;
      tooltip.style.top = `${rect.top - parentRect.top - 10}px`;
    });

    marker.addEventListener('mouseleave', () => {
      if (tooltip) tooltip.style.opacity = '0';
    });
  });
}

/* ==========================================================================
   5. Modals & Drawers (Uyku Zamanlayıcı, Bölüm Listesi vb.)
   ========================================================================== */
function initModals() {
  // Sleep Timer Modal
  const sleepTimerBtn = document.getElementById('sleepTimerBtn');
  const sleepModal = document.getElementById('sleepTimerModal');
  const closeSleepModal = document.getElementById('closeSleepModal');
  const timerOptions = document.querySelectorAll('.timer-opt-btn');

  if (sleepTimerBtn && sleepModal) {
    sleepTimerBtn.addEventListener('click', () => {
      sleepModal.classList.add('show');
    });
  }

  if (closeSleepModal && sleepModal) {
    closeSleepModal.addEventListener('click', () => {
      sleepModal.classList.remove('show');
    });
  }

  timerOptions.forEach(opt => {
    opt.addEventListener('click', () => {
      timerOptions.forEach(o => o.classList.remove('btn-primary'));
      opt.classList.add('btn-primary');
      const timeVal = opt.dataset.time;
      if (sleepTimerBtn) {
        sleepTimerBtn.innerHTML = `<i class="fa-solid fa-moon text-primary"></i> ${timeVal} dk`;
      }
      setTimeout(() => {
        if (sleepModal) sleepModal.classList.remove('show');
      }, 300);
    });
  });

  // Chapter List Modal
  const chapterListBtn = document.getElementById('chapterListBtn');
  const chapterModal = document.getElementById('chapterListModal');
  const closeChapterModal = document.getElementById('closeChapterModal');

  if (chapterListBtn && chapterModal) {
    chapterListBtn.addEventListener('click', () => {
      chapterModal.classList.add('show');
    });
  }

  if (closeChapterModal && chapterModal) {
    closeChapterModal.addEventListener('click', () => {
      chapterModal.classList.remove('show');
    });
  }

  // Close when clicking outside modal
  window.addEventListener('click', (e) => {
    if (e.target === sleepModal) sleepModal.classList.remove('show');
    if (e.target === chapterModal) chapterModal.classList.remove('show');
  });
}

/* ==========================================================================
   6. Header Dropdowns (Bildirimler ve Kullanıcı Profil Açılır Menüsü)
   ========================================================================== */
function initHeaderDropdowns() {
  const notifBtn = document.getElementById('notificationBtn');
  const notifMenu = document.getElementById('notifDropdownMenu');
  const notifBadge = document.getElementById('notifCountBadge');
  const notifUnreadPill = document.getElementById('notifUnreadPill');
  const markAllReadBtn = document.getElementById('markAllNotifsRead');

  const profileBtn = document.getElementById('userNavDropdownBtn');
  const profileMenu = document.getElementById('userProfileDropdownMenu');

  function closeAllDropdowns() {
    if (notifMenu) notifMenu.classList.remove('show');
    if (profileMenu) profileMenu.classList.remove('show');
    if (notifBtn) notifBtn.setAttribute('aria-expanded', 'false');
    if (profileBtn) profileBtn.setAttribute('aria-expanded', 'false');
  }

  // 1. Notification Dropdown Toggle
  if (notifBtn && notifMenu) {
    notifBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = notifMenu.classList.contains('show');
      closeAllDropdowns();
      if (!isOpen) {
        notifMenu.classList.add('show');
        notifBtn.setAttribute('aria-expanded', 'true');
      }
    });

    notifMenu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  // 2. Mark All Read Button
  if (markAllReadBtn) {
    markAllReadBtn.addEventListener('click', () => {
      const unreadRows = notifMenu ? notifMenu.querySelectorAll('.notif-item-row.unread') : [];
      unreadRows.forEach(row => {
        row.classList.remove('unread');
        const dot = row.querySelector('.notif-unread-dot');
        if (dot) dot.remove();
      });
      if (notifBadge) notifBadge.style.display = 'none';
      if (notifUnreadPill) notifUnreadPill.textContent = '0 Yeni';
    });
  }

  // 3. User Profile Dropdown Toggle
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = profileMenu.classList.contains('show');
      closeAllDropdowns();
      if (!isOpen) {
        profileMenu.classList.add('show');
        profileBtn.setAttribute('aria-expanded', 'true');
      }
    });

    profileMenu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }

  // Close on outside click
  document.addEventListener('click', () => {
    closeAllDropdowns();
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeAllDropdowns();
    }
  });
}

/* ==========================================================================
   7. Mobile Menu Toggle
   ========================================================================== */
function initMobileMenu() {
  const mobileToggle = document.getElementById('mobileMenuToggle');
  const mobileDrawer = document.getElementById('mobileNavDrawer');
  const closeMobileNav = document.getElementById('closeMobileNav');

  if (mobileToggle && mobileDrawer) {
    mobileToggle.addEventListener('click', () => {
      mobileDrawer.classList.add('show');
    });
  }

  if (closeMobileNav && mobileDrawer) {
    closeMobileNav.addEventListener('click', () => {
      mobileDrawer.classList.remove('show');
    });
  }
}

/* ==========================================================================
   8. Hero Section Mobile 3D Single Book Slider
   ========================================================================== */
function initHeroMobileSlider() {
  const booksRow = document.getElementById('heroBooksRow');
  const prevBtn = document.getElementById('heroPrevBookBtn');
  const nextBtn = document.getElementById('heroNextBookBtn');
  const dotsContainer = document.getElementById('heroSliderDots');

  if (!booksRow) return;

  const books = booksRow.querySelectorAll('.hero-3d-book');
  const dots = dotsContainer ? dotsContainer.querySelectorAll('.hero-dot') : [];
  let currentIndex = 0;
  const totalBooks = books.length;

  function showSlide(index) {
    if (totalBooks === 0) return;
    
    // Normalize index
    currentIndex = (index + totalBooks) % totalBooks;

    books.forEach((book, idx) => {
      if (idx === currentIndex) {
        book.classList.add('active-mobile-slide');
      } else {
        book.classList.remove('active-mobile-slide');
      }
    });

    dots.forEach((dot, idx) => {
      if (idx === currentIndex) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.preventDefault();
      showSlide(currentIndex - 1);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.preventDefault();
      showSlide(currentIndex + 1);
    });
  }

  dots.forEach((dot) => {
    dot.addEventListener('click', () => {
      const idx = parseInt(dot.dataset.index, 10);
      showSlide(idx);
    });
  });

  // Touch Swipe Support on Mobile Hero Area
  let touchStartX = 0;
  let touchEndX = 0;

  booksRow.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  booksRow.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }, { passive: true });

  function handleSwipe() {
    const swipeThreshold = 40;
    if (touchEndX < touchStartX - swipeThreshold) {
      // Swiped Left -> Next Book
      showSlide(currentIndex + 1);
    }
    if (touchEndX > touchStartX + swipeThreshold) {
      // Swiped Right -> Prev Book
      showSlide(currentIndex - 1);
    }
  }

  // Initial display
  showSlide(0);
}
