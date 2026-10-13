/**
 * UFKA YOLCULUK - YARIŞMA KİTAPLARI & GEÇMİŞ YILLAR ARŞİVİ MOTORU
 * kitaplar.js
 */

// Tüm Kitaplar Veri Seti (2025 Güncel + 2020-2024 Arşiv)
const ALL_BOOKS_DATA = [
  // --- 2025 (13. Ufka Yolculuk - Güncel) ---
  {
    id: 'kuslarin-cagrisi',
    title: 'Kuşların Çağrısı',
    category: 'ilkokul',
    categoryLabel: 'İlkokul Düzeyi',
    year: '2025',
    edition: '13. Ufka Yolculuk',
    isCurrent: true,
    author: 'Ufka Yolculuk Yayınları',
    pages: 160,
    coverImg: 'assets/images/books/book-kuslarin-cagrisi.svg',
    hasAudio: true,
    audioDuration: '2 saat 45 dk',
    summary: 'Ormanın derinliklerinde yaşayan kuşların dostluk, birlik, cesaret ve tevhid inancını anlatan sıcacık bir macera.',
    readerUrl: 'kitap-oku.html?book=kuslarin-cagrisi&page=1'
  },
  {
    id: 'tevhid-muhafizlari',
    title: 'Tevhid Muhafızları',
    category: 'ortaokul',
    categoryLabel: 'Ortaokul Düzeyi',
    year: '2025',
    edition: '13. Ufka Yolculuk',
    isCurrent: true,
    author: 'Ufka Yolculuk Yayınları',
    pages: 185,
    coverImg: 'assets/images/books/book-tevhid-muhafizlari.svg',
    hasAudio: true,
    audioDuration: '3 saat 53 dk',
    summary: 'Boş damacana ile başlayan ve gençlerin inanç, tevekkül ve ahlak değerlerini keşfettiği sürükleyici bir gençlik romanı.',
    readerUrl: 'kitap-oku.html?book=tevhid-muhafizlari&page=5'
  },
  {
    id: 'gordugume-gormedigime',
    title: 'Gördüğüme Görmediğime',
    category: 'lise',
    categoryLabel: 'Lise Düzeyi',
    year: '2025',
    edition: '13. Ufka Yolculuk',
    isCurrent: true,
    author: 'Ufka Yolculuk Yayınları',
    pages: 190,
    coverImg: 'assets/images/books/book-gordugume-gormedigime.svg',
    hasAudio: true,
    audioDuration: '3 saat 30 dk',
    summary: 'Aklın sınırları, görünenin ötesindeki hakikatler ve varoluş üzerine gençlere derin bir ufuk açan düşünce ve inanç yolculuğu.',
    readerUrl: 'kitap-oku.html?book=gordugume-gormedigime&page=1'
  },
  {
    id: 'nasil-inanmali',
    title: 'Nasıl İnanmalı?',
    category: 'yetiskin',
    categoryLabel: 'Yetişkin Düzeyi',
    year: '2025',
    edition: '13. Ufka Yolculuk',
    isCurrent: true,
    author: 'Ufka Yolculuk Yayınları',
    pages: 210,
    coverImg: 'assets/images/books/book-nasil-inanmali.svg',
    hasAudio: true,
    audioDuration: '4 saat 15 dk',
    summary: 'Modern dünyada inanç, akıl ve kalp dengesini kuran, temel itikadi meseleleri anlaşılır dille açıklayan rehber eser.',
    readerUrl: 'kitap-oku.html?book=nasil-inanmali&page=1'
  },

  // --- 2024 (12. Ufka Yolculuk - İbadet / İlmihal / Ahlak) ---
  {
    id: 'maske-dustu-2024',
    title: 'Maske Düştü',
    category: 'ilkokul',
    categoryLabel: 'İlkokul Düzeyi',
    year: '2024',
    edition: '12. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 144,
    coverImg: 'assets/images/books/archive-2024.svg',
    hasAudio: true,
    audioDuration: '2 saat 10 dk',
    summary: 'Dürüstlük, güven ve doğru sözlülüğün çocukların dünyasındaki renkli ve öğretici hikayesi.',
    readerUrl: 'kitap-oku.html?book=kuslarin-cagrisi'
  },
  {
    id: 'zamanin-tozu-2024',
    title: 'Zamanın Tozu',
    category: 'ortaokul',
    categoryLabel: 'Ortaokul Düzeyi',
    year: '2024',
    edition: '12. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 168,
    coverImg: 'assets/images/books/archive-2024.svg',
    hasAudio: true,
    audioDuration: '3 saat 15 dk',
    summary: 'Zamanı doğru kullanma, ibadet bilinci ve sorumluluk üzerine kurgulanmış macera dolu bir roman.',
    readerUrl: 'kitap-oku.html?book=tevhid-muhafizlari'
  },
  {
    id: 'vakit-geldi-2024',
    title: 'Vakit Geldi',
    category: 'lise',
    categoryLabel: 'Lise Düzeyi',
    year: '2024',
    edition: '12. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 192,
    coverImg: 'assets/images/books/archive-2024.svg',
    hasAudio: true,
    audioDuration: '3 saat 40 dk',
    summary: 'Gençlerin hayatı anlamlandırma ve namaz ibadetinin getirdiği huzuru keşfetme serüveni.',
    readerUrl: 'kitap-oku.html?book=gordugume-gormedigime'
  },
  {
    id: 'ilmihal-ibadetler-2024',
    title: 'İlmihal - İbadet Esasları',
    category: 'yetiskin',
    categoryLabel: 'Yetişkin Düzeyi',
    year: '2024',
    edition: '12. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 240,
    coverImg: 'assets/images/books/archive-2024.svg',
    hasAudio: true,
    audioDuration: '5 saat 20 dk',
    summary: 'Günlük hayatımızda ibadetlerin uygulanışı, hikmetleri ve fıkhi esaslarını içeren temel başvuru kitabı.',
    readerUrl: 'kitap-oku.html?book=nasil-inanmali'
  },

  // --- 2023 (11. Ufka Yolculuk - Sağlıklı Yaşam) ---
  {
    id: 'afiyetle-yasam-2023',
    title: 'Afiyetle Yaşam',
    category: 'ilkokul',
    categoryLabel: 'İlkokul Düzeyi',
    year: '2023',
    edition: '11. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 128,
    coverImg: 'assets/images/books/archive-2023.svg',
    hasAudio: true,
    audioDuration: '1 saat 50 dk',
    summary: 'Helal ve sağlıklı beslenme alışkanlıklarını çocuklara neşeyle kazandıran eğlenceli çizimlerle dolu bir eser.',
    readerUrl: 'kitap-oku.html?book=kuslarin-cagrisi'
  },
  {
    id: 'saglik-olsun-2023',
    title: 'Sağlık Olsun',
    category: 'ortaokul',
    categoryLabel: 'Ortaokul Düzeyi',
    year: '2023',
    edition: '11. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 156,
    coverImg: 'assets/images/books/archive-2023.svg',
    hasAudio: true,
    audioDuration: '2 saat 45 dk',
    summary: 'Beden ve ruh sağlığının korunması, zararlı alışkanlıklardan uzak durma bilinci.',
    readerUrl: 'kitap-oku.html?book=tevhid-muhafizlari'
  },
  {
    id: 'iki-cihan-bahtiyarligi-2023',
    title: 'İki Cihan Bahtiyarlığı',
    category: 'lise',
    categoryLabel: 'Lise Düzeyi',
    year: '2023',
    edition: '11. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 180,
    coverImg: 'assets/images/books/archive-2023.svg',
    hasAudio: true,
    audioDuration: '3 saat 10 dk',
    summary: 'Sağlıklı bir gençlik, dengeli yaşam ve manevi huzur üzerine rehberlik eden başucu kitabı.',
    readerUrl: 'kitap-oku.html?book=gordugume-gormedigime'
  },
  {
    id: 'saglikli-dinc-yasam-2023',
    title: 'Sağlıklı ve Dinç Yaşam',
    category: 'yetiskin',
    categoryLabel: 'Yetişkin Düzeyi',
    year: '2023',
    edition: '11. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 220,
    coverImg: 'assets/images/books/archive-2023.svg',
    hasAudio: true,
    audioDuration: '4 saat 30 dk',
    summary: 'Tıbbi ve İslami prensipler ışığında koruyucu sağlık ve dengeli hayat reçetesi.',
    readerUrl: 'kitap-oku.html?book=nasil-inanmali'
  },

  // --- 2022 (10. Ufka Yolculuk - Sağlıklı Düşünmek) ---
  {
    id: 'elma-dersem-cik-2022',
    title: 'Elma Dersem Çık',
    category: 'ilkokul',
    categoryLabel: 'İlkokul Düzeyi',
    year: '2022',
    edition: '10. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 136,
    coverImg: 'assets/images/books/archive-2022.svg',
    hasAudio: true,
    audioDuration: '2 saat 05 dk',
    summary: 'Doğru düşünme, merak etme ve akıl yürütme üzerine çocuklara ilham veren neşeli bir serüven.',
    readerUrl: 'kitap-oku.html?book=kuslarin-cagrisi'
  },
  {
    id: 'eyvah-ceviz-catladi-2022',
    title: 'Eyvah! Ceviz Çatladı',
    category: 'ortaokul',
    categoryLabel: 'Ortaokul Düzeyi',
    year: '2022',
    edition: '10. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 160,
    coverImg: 'assets/images/books/archive-2022.svg',
    hasAudio: true,
    audioDuration: '2 saat 50 dk',
    summary: 'Önyargıları kırma, doğru bilgiye ulaşma ve eleştirel düşünme becerileri kazandıran gençlik hikayesi.',
    readerUrl: 'kitap-oku.html?book=tevhid-muhafizlari'
  },
  {
    id: 'dusun-bir-kez-2022',
    title: 'Düşün Bir Kez',
    category: 'lise',
    categoryLabel: 'Lise Düzeyi',
    year: '2022',
    edition: '10. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 176,
    coverImg: 'assets/images/books/archive-2022.svg',
    hasAudio: true,
    audioDuration: '3 saat 15 dk',
    summary: 'Bilgi kirliliği çağında hakikati arama ve zihni tuzaklardan korunma yolları.',
    readerUrl: 'kitap-oku.html?book=gordugume-gormedigime'
  },
  {
    id: 'elestirel-dusunme-2022',
    title: 'Eleştirel Düşünme & Hakikat',
    category: 'yetiskin',
    categoryLabel: 'Yetişkin Düzeyi',
    year: '2022',
    edition: '10. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 208,
    coverImg: 'assets/images/books/archive-2022.svg',
    hasAudio: true,
    audioDuration: '4 saat 10 dk',
    summary: 'Mantık kuralları, algı yönetimi ve sağlam düşünce metodolojisi üzerine derin bir inceleme.',
    readerUrl: 'kitap-oku.html?book=nasil-inanmali'
  },

  // --- 2021 (9. Ufka Yolculuk - Edepli Olmak) ---
  {
    id: 'edep-diyari-2021',
    title: 'Edep Diyarı',
    category: 'ilkokul',
    categoryLabel: 'İlkokul Düzeyi',
    year: '2021',
    edition: '9. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 120,
    coverImg: 'assets/images/books/archive-2021.svg',
    hasAudio: true,
    audioDuration: '1 saat 45 dk',
    summary: 'Büyüklere saygı, küçüklere sevgi ve güzel ahlakın çocuk masallarıyla harmanlanmış hali.',
    readerUrl: 'kitap-oku.html?book=kuslarin-cagrisi'
  },
  {
    id: 'edep-mektebi-2021',
    title: 'Edep Mektebi',
    category: 'ortaokul',
    categoryLabel: 'Ortaokul Düzeyi',
    year: '2021',
    edition: '9. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 144,
    coverImg: 'assets/images/books/archive-2021.svg',
    hasAudio: true,
    audioDuration: '2 saat 30 dk',
    summary: 'Okulda, sokakta ve ailede nezaket, haya ve güzel davranış rehberi.',
    readerUrl: 'kitap-oku.html?book=tevhid-muhafizlari'
  },

  // --- 2020 (8. Ufka Yolculuk - Adap) ---
  {
    id: 'edebin-basi-adap-2020',
    title: 'Edebin Başı Adap',
    category: 'ilkokul',
    categoryLabel: 'İlkokul Düzeyi',
    year: '2020',
    edition: '8. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 112,
    coverImg: 'assets/images/books/archive-2020.svg',
    hasAudio: true,
    audioDuration: '1 saat 30 dk',
    summary: 'Yemek, uyku, selamlaşma ve günlük hayat adabı üzerine eğlenceli ve öğretici hikayeler.',
    readerUrl: 'kitap-oku.html?book=kuslarin-cagrisi'
  },
  {
    id: 'gorgu-ve-nezaket-2020',
    title: 'Görgü ve Nezaket',
    category: 'ortaokul',
    categoryLabel: 'Ortaokul Düzeyi',
    year: '2020',
    edition: '8. Ufka Yolculuk',
    isCurrent: false,
    author: 'Ufka Yolculuk Yayınları',
    pages: 136,
    coverImg: 'assets/images/books/archive-2020.svg',
    hasAudio: true,
    audioDuration: '2 saat 15 dk',
    summary: 'Toplumsal yaşamda saygı, empati, konuşma ve dinleme adabı.',
    readerUrl: 'kitap-oku.html?book=tevhid-muhafizlari'
  }
];

// Aktif Filtre Durumu
let currentFilters = {
  search: '',
  year: 'all',
  category: 'all',
  viewMode: 'grid' // 'grid' veya 'list'
};

document.addEventListener('DOMContentLoaded', () => {
  initBookListPage();
});

function initBookListPage() {
  parseUrlQueryParams();
  setupFilterControls();
  renderBooks();
  initDetailModal();
  initHeaderPopovers();
}

/**
 * URL Parametrelerini Çözümleme (?year=2024, ?category=ortaokul, ?search=...)
 */
function parseUrlQueryParams() {
  const params = new URLSearchParams(window.location.search);
  const yearParam = params.get('year') || params.get('y');
  const catParam = params.get('category') || params.get('cat');
  const searchParam = params.get('search') || params.get('q');
  const filterParam = params.get('filter');

  if (yearParam) currentFilters.year = yearParam;
  if (filterParam === 'archive') currentFilters.year = 'archive';
  if (catParam) currentFilters.category = catParam;
  if (searchParam) currentFilters.search = searchParam;

  // Arama inputuna değeri yaz
  const searchInput = document.getElementById('booksSearchInput');
  if (searchInput && currentFilters.search) {
    searchInput.value = currentFilters.search;
  }
}

/**
 * Filtre Düğmeleri ve Arama Olay Dinleyicileri
 */
function setupFilterControls() {
  const searchInput = document.getElementById('booksSearchInput');
  const clearSearchBtn = document.getElementById('btnClearSearch');
  const yearPills = document.querySelectorAll('.year-filter-pill');
  const catPills = document.querySelectorAll('.cat-filter-pill');
  const gridViewBtn = document.getElementById('btnViewGrid');
  const listViewBtn = document.getElementById('btnViewList');

  // Arama Inputu
  if (searchInput) {
    searchInput.addEventListener('input', (e) => {
      currentFilters.search = e.target.value.trim().toLowerCase();
      if (clearSearchBtn) {
        clearSearchBtn.style.display = currentFilters.search ? 'block' : 'none';
      }
      renderBooks();
    });
  }

  if (clearSearchBtn) {
    clearSearchBtn.addEventListener('click', () => {
      if (searchInput) searchInput.value = '';
      currentFilters.search = '';
      clearSearchBtn.style.display = 'none';
      renderBooks();
    });
  }

  // Yıl Filtreleri
  yearPills.forEach(pill => {
    const y = pill.getAttribute('data-year');
    if (y === currentFilters.year) {
      yearPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
    }

    pill.addEventListener('click', () => {
      yearPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
      currentFilters.year = pill.getAttribute('data-year') || 'all';
      renderBooks();
    });
  });

  // Kategori Filtreleri
  catPills.forEach(pill => {
    const c = pill.getAttribute('data-cat');
    if (c === currentFilters.category) {
      catPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
    }

    pill.addEventListener('click', () => {
      catPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
      currentFilters.category = pill.getAttribute('data-cat') || 'all';
      renderBooks();
    });
  });

  // Görünüm Modu
  if (gridViewBtn && listViewBtn) {
    gridViewBtn.addEventListener('click', () => {
      gridViewBtn.classList.add('active');
      listViewBtn.classList.remove('active');
      currentFilters.viewMode = 'grid';
      renderBooks();
    });

    listViewBtn.addEventListener('click', () => {
      listViewBtn.classList.add('active');
      gridViewBtn.classList.remove('active');
      currentFilters.viewMode = 'list';
      renderBooks();
    });
  }
}

/**
 * Kitapları Filtreleyip DOM'a Basma
 */
function renderBooks() {
  const gridContainer = document.getElementById('booksGridContainer');
  const listContainer = document.getElementById('booksListContainer');
  const emptyState = document.getElementById('booksEmptyState');
  const countBadge = document.getElementById('resultsCountNum');

  if (!gridContainer || !listContainer) return;

  const filtered = ALL_BOOKS_DATA.filter(book => {
    // 1. Arama Metni Filtresi
    if (currentFilters.search) {
      const q = currentFilters.search;
      const matchTitle = book.title.toLowerCase().includes(q);
      const matchAuthor = book.author.toLowerCase().includes(q);
      const matchSummary = book.summary.toLowerCase().includes(q);
      const matchYear = book.year.includes(q);
      if (!matchTitle && !matchAuthor && !matchSummary && !matchYear) return false;
    }

    // 2. Yıl Filtresi
    if (currentFilters.year !== 'all') {
      if (currentFilters.year === 'archive') {
        if (book.isCurrent) return false;
      } else if (book.year !== currentFilters.year) {
        return false;
      }
    }

    // 3. Kategori Filtresi
    if (currentFilters.category !== 'all' && book.category !== currentFilters.category) {
      return false;
    }

    return true;
  });

  // Sonuç Sayacı
  if (countBadge) {
    countBadge.textContent = filtered.length;
  }

  // Boş Sonuç Kontrolü
  if (filtered.length === 0) {
    gridContainer.style.display = 'none';
    listContainer.style.display = 'none';
    if (emptyState) emptyState.style.display = 'block';
    return;
  }

  if (emptyState) emptyState.style.display = 'none';

  // Grid Modu
  if (currentFilters.viewMode === 'grid') {
    listContainer.style.display = 'none';
    gridContainer.style.display = 'grid';
    gridContainer.innerHTML = filtered.map(b => createGridBookCard(b)).join('');
  } else {
    gridContainer.style.display = 'none';
    listContainer.style.display = 'flex';
    listContainer.innerHTML = filtered.map(b => createListBookCard(b)).join('');
  }

  attachDetailModalEvents();
}

/**
 * Grid Kartı HTML Şablonu
 */
function createGridBookCard(book) {
  const yearBadgeClass = book.isCurrent ? 'book-badge-year current' : 'book-badge-year';
  const yearText = book.isCurrent ? '2025 • Güncel' : book.year;

  return `
    <div class="book-card-3d" data-book-id="${book.id}">
      <div class="book-card-cover-stage">
        <span class="${yearBadgeClass}">${yearText}</span>
        ${book.hasAudio ? '<span class="book-badge-audio" title="Sesli Dinleme Mevcut"><i class="fa-solid fa-headphones"></i></span>' : ''}
        <img src="${book.coverImg}" alt="${book.title}" loading="lazy" onerror="this.src='assets/images/books/book-kuslarin-cagrisi.svg'">
      </div>

      <div class="book-card-info">
        <span class="book-level-pill ${book.category}">${book.categoryLabel}</span>
        <h3 class="book-card-title">${book.title}</h3>
        <div class="book-card-author">${book.author}</div>
        <div class="book-card-meta-row">
          <span><i class="fa-solid fa-book-open me-1"></i>${book.pages} Sayfa</span>
          ${book.hasAudio ? `<span><i class="fa-regular fa-clock me-1"></i>${book.audioDuration}</span>` : ''}
        </div>
      </div>

      <div class="book-card-buttons">
        <a href="${book.readerUrl}" class="btn-book-read-primary" title="Kitabı Oku">
          <i class="fa-solid fa-book-open"></i> <span>Kitabı Oku</span>
        </a>
        <a href="${book.readerUrl}" class="btn-book-audio-circle" title="Sesli Dinle">
          <i class="fa-solid fa-headphones"></i>
        </a>
        <button type="button" class="btn-book-detail-circle btn-open-detail" data-id="${book.id}" title="Özet ve Detaylar">
          <i class="fa-solid fa-circle-info"></i>
        </button>
      </div>
    </div>
  `;
}

/**
 * Liste Kartı HTML Şablonu
 */
function createListBookCard(book) {
  const yearBadge = book.isCurrent ? '<span class="badge bg-warning text-dark me-2 fw-bold">2025 Güncel</span>' : `<span class="badge bg-secondary me-2">${book.year} Arşiv</span>`;

  return `
    <div class="book-card-list-item" data-book-id="${book.id}">
      <div class="book-list-thumb-wrap">
        <img src="${book.coverImg}" alt="${book.title}" loading="lazy">
      </div>

      <div class="book-list-main-info">
        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
          ${yearBadge}
          <span class="book-level-pill ${book.category}">${book.categoryLabel}</span>
        </div>
        <h3 class="fs-6 fw-bold mb-1 text-dark">${book.title}</h3>
        <p class="text-muted fs-7 mb-2" style="max-width: 600px;">${book.summary}</p>
        <div class="d-flex align-items-center gap-3 fs-8 text-muted fw-semibold">
          <span><i class="fa-solid fa-book-open me-1"></i>${book.pages} Sayfa</span>
          <span><i class="fa-regular fa-clock me-1"></i>${book.audioDuration}</span>
          <span><i class="fa-solid fa-layer-group me-1"></i>${book.edition}</span>
        </div>
      </div>

      <div class="book-list-actions">
        <a href="${book.readerUrl}" class="btn btn-primary btn-sm px-3 fw-bold rounded-pill">
          <i class="fa-solid fa-book-open me-1"></i> Oku & Dinle
        </a>
        <button type="button" class="btn btn-light btn-sm rounded-pill btn-open-detail" data-id="${book.id}" title="Detay">
          <i class="fa-solid fa-circle-info"></i>
        </button>
      </div>
    </div>
  `;
}

/**
 * Kitap Detay Modalı Olayları
 */
function initDetailModal() {
  // Modal DOM Elementleri
  window.detailModalEl = document.getElementById('modalBookDetail');
}

function attachDetailModalEvents() {
  document.querySelectorAll('.btn-open-detail').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const id = btn.getAttribute('data-id');
      const book = ALL_BOOKS_DATA.find(b => b.id === id);
      if (!book) return;

      const titleEl = document.getElementById('modalDetailTitle');
      const imgEl = document.getElementById('modalDetailImg');
      const levelEl = document.getElementById('modalDetailLevel');
      const yearEl = document.getElementById('modalDetailYear');
      const pagesEl = document.getElementById('modalDetailPages');
      const audioEl = document.getElementById('modalDetailAudio');
      const summaryEl = document.getElementById('modalDetailSummary');
      const btnRead = document.getElementById('modalDetailBtnRead');

      if (titleEl) titleEl.textContent = book.title;
      if (imgEl) imgEl.src = book.coverImg;
      if (levelEl) {
        levelEl.textContent = book.categoryLabel;
        levelEl.className = 'badge rounded-pill ' + (book.category === 'ilkokul' ? 'bg-success' : book.category === 'ortaokul' ? 'bg-warning text-dark' : 'bg-primary');
      }
      if (yearEl) yearEl.textContent = `${book.year} (${book.edition})`;
      if (pagesEl) pagesEl.textContent = `${book.pages} Sayfa`;
      if (audioEl) audioEl.textContent = book.audioDuration;
      if (summaryEl) summaryEl.textContent = book.summary;
      if (btnRead) btnRead.href = book.readerUrl;

      if (window.detailModalEl && window.bootstrap) {
        const bsModal = bootstrap.Modal.getOrCreateInstance(window.detailModalEl);
        bsModal.show();
      }
    });
  });
}

/**
 * Üst Menü Popover Açılır Kutu Mantığı
 */
function initHeaderPopovers() {
  const notifBtn = document.getElementById('notificationBtn');
  const notifMenu = document.getElementById('notifDropdownMenu');
  const userBtn = document.getElementById('userNavDropdownBtn');
  const userMenu = document.getElementById('userProfileDropdownMenu');

  if (notifBtn && notifMenu) {
    notifBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = notifMenu.classList.contains('show');
      if (userMenu) userMenu.classList.remove('show');
      if (!isOpen) notifMenu.classList.add('show');
      else notifMenu.classList.remove('show');
    });
  }

  if (userBtn && userMenu) {
    userBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = userMenu.classList.contains('show');
      if (notifMenu) notifMenu.classList.remove('show');
      if (!isOpen) userMenu.classList.add('show');
      else userMenu.classList.remove('show');
    });
  }

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.portal-popover-menu') && !e.target.closest('.nav-dropdown-wrapper')) {
      if (notifMenu) notifMenu.classList.remove('show');
      if (userMenu) userMenu.classList.remove('show');
    }
  });
}
