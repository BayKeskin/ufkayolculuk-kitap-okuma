/**
 * UFKA YOLCULUK - HEADER ARAMA MODÜLÜ (Masaüstü & Mobil)
 * Tüm sayfalarda üst menüdeki arama butonunu (magnifying glass)
 * zengin, anlık canlı arama açılır penceresine (Header Search Popover) bağlar.
 */

(function () {
  'use strict';

  // Kapsamlı Arama Veritabanı
  const HEADER_SEARCH_DATA = [
    // 2025 Yarışma Kitapları
    {
      id: 'kuslarin-cagrisi',
      title: 'Kuşların Çağrısı',
      category: 'ilkokul',
      categoryLabel: 'İlkokul (2025)',
      badgeClass: 'badge-cat-ilkokul',
      type: 'book',
      typeLabel: 'Yarışma Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '13. Ufka Yolculuk İlkokul kategorisi resmi yarışma kitabı.',
      url: 'kitap-oku.html?book=kuslarin-cagrisi&page=1',
      icon: 'fa-solid fa-book-open',
      actionText: 'Kitabı Oku'
    },
    {
      id: 'tevhid-muhafizlari',
      title: 'Tevhid Muhafızları',
      category: 'ortaokul',
      categoryLabel: 'Ortaokul (2025)',
      badgeClass: 'badge-cat-ortaokul',
      type: 'book',
      typeLabel: 'Yarışma Kitabı & Sesli',
      author: 'Ufka Yolculuk Yayınları',
      desc: '13. Ufka Yolculuk Ortaokul kategorisi resmi yarışma kitabı.',
      url: 'kitap-oku.html?book=tevhid-muhafizlari&page=5',
      icon: 'fa-solid fa-headphones',
      actionText: 'Oku & Dinle'
    },
    {
      id: 'gordugume-gormedigime',
      title: 'Gördüğüme Görmediğime',
      category: 'lise',
      categoryLabel: 'Lise (2025)',
      badgeClass: 'badge-cat-lise',
      type: 'book',
      typeLabel: 'Yarışma Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '13. Ufka Yolculuk Lise kategorisi resmi yarışma kitabı.',
      url: 'kitap-oku.html?book=gordugume-gormedigime&page=1',
      icon: 'fa-solid fa-book-open',
      actionText: 'Kitabı Oku'
    },
    {
      id: 'nasil-inanmali',
      title: 'Nasıl İnanmalı?',
      category: 'yetiskin',
      categoryLabel: 'Yetişkin (2025)',
      badgeClass: 'badge-cat-yetiskin',
      type: 'book',
      typeLabel: 'Yarışma Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '13. Ufka Yolculuk Yetişkin kategorisi resmi yarışma kitabı.',
      url: 'kitap-oku.html?book=nasil-inanmali&page=1',
      icon: 'fa-solid fa-book-open',
      actionText: 'Kitabı Oku'
    },

    // Geçmiş Yıllar Arşiv Kitapları
    {
      id: 'maske-dustu-2024',
      title: 'Maske Düştü',
      category: 'ilkokul',
      categoryLabel: 'İlkokul (2024 Arşiv)',
      badgeClass: 'badge-cat-archive',
      type: 'book',
      typeLabel: 'Geçmiş Yıl Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '12. Ufka Yolculuk İlkokul kategorisi kitabı.',
      url: 'kitaplar.html?search=Maske+D%C3%BC%C5%9Ft%C3%BC',
      icon: 'fa-solid fa-box-archive',
      actionText: 'İncele'
    },
    {
      id: 'zamanin-tozu-2024',
      title: 'Zamanın Tozu',
      category: 'ortaokul',
      categoryLabel: 'Ortaokul (2024 Arşiv)',
      badgeClass: 'badge-cat-archive',
      type: 'book',
      typeLabel: 'Geçmiş Yıl Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '12. Ufka Yolculuk Ortaokul kategorisi kitabı.',
      url: 'kitaplar.html?search=Zaman%C4%B1n+Tozu',
      icon: 'fa-solid fa-box-archive',
      actionText: 'İncele'
    },
    {
      id: 'vakit-geldi-2024',
      title: 'Vakit Geldi',
      category: 'lise',
      categoryLabel: 'Lise (2024 Arşiv)',
      badgeClass: 'badge-cat-archive',
      type: 'book',
      typeLabel: 'Geçmiş Yıl Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '12. Ufka Yolculuk Lise kategorisi kitabı.',
      url: 'kitaplar.html?search=Vakit+Geldi',
      icon: 'fa-solid fa-box-archive',
      actionText: 'İncele'
    },
    {
      id: 'ilmihal-2024',
      title: 'İlmihal - İbadet Esasları',
      category: 'yetiskin',
      categoryLabel: 'Yetişkin (2024 Arşiv)',
      badgeClass: 'badge-cat-archive',
      type: 'book',
      typeLabel: 'Geçmiş Yıl Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '12. Ufka Yolculuk Yetişkin kategorisi kitabı.',
      url: 'kitaplar.html?search=%C4%B0lmihal',
      icon: 'fa-solid fa-box-archive',
      actionText: 'İncele'
    },
    {
      id: 'afiyetle-yasam-2023',
      title: 'Afiyetle Yaşam',
      category: 'ilkokul',
      categoryLabel: 'İlkokul (2023 Arşiv)',
      badgeClass: 'badge-cat-archive',
      type: 'book',
      typeLabel: 'Geçmiş Yıl Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '11. Ufka Yolculuk İlkokul kategorisi kitabı.',
      url: 'kitaplar.html?search=Afiyetle+Ya%C5%9Fam',
      icon: 'fa-solid fa-box-archive',
      actionText: 'İncele'
    },
    {
      id: 'gorev-tamam-2023',
      title: 'Görev Tamam',
      category: 'ortaokul',
      categoryLabel: 'Ortaokul (2023 Arşiv)',
      badgeClass: 'badge-cat-archive',
      type: 'book',
      typeLabel: 'Geçmiş Yıl Kitabı',
      author: 'Ufka Yolculuk Yayınları',
      desc: '11. Ufka Yolculuk Ortaokul kategorisi kitabı.',
      url: 'kitaplar.html?search=G%C3%B6rev+Tamam',
      icon: 'fa-solid fa-box-archive',
      actionText: 'İncele'
    },

    // Deneme Sınavları
    {
      id: 'sinav-ilkokul-1',
      title: 'İlkokul 1. Deneme Sınavı',
      category: 'ilkokul',
      categoryLabel: 'İlkokul Düzeyi',
      badgeClass: 'badge-cat-exam',
      type: 'exam',
      typeLabel: 'Online Deneme Sınavı',
      author: '40 Soru • 50 Dakika',
      desc: 'Kuşların Çağrısı kitabı hazırlık deneme sınavı.',
      url: 'deneme-sinavlari.html?level=ilkokul',
      icon: 'fa-solid fa-file-pen',
      actionText: 'Sınava Gir'
    },
    {
      id: 'sinav-ortaokul-1',
      title: 'Ortaokul 1. Deneme Sınavı',
      category: 'ortaokul',
      categoryLabel: 'Ortaokul Düzeyi',
      badgeClass: 'badge-cat-exam',
      type: 'exam',
      typeLabel: 'Online Deneme Sınavı',
      author: '50 Soru • 60 Dakika',
      desc: 'Tevhid Muhafızları kitabı hazırlık deneme sınavı.',
      url: 'deneme-sinavlari.html?level=ortaokul',
      icon: 'fa-solid fa-file-pen',
      actionText: 'Sınava Gir'
    },
    {
      id: 'sinav-lise-1',
      title: 'Lise 1. Deneme Sınavı',
      category: 'lise',
      categoryLabel: 'Lise Düzeyi',
      badgeClass: 'badge-cat-exam',
      type: 'exam',
      typeLabel: 'Online Deneme Sınavı',
      author: '50 Soru • 60 Dakika',
      desc: 'Gördüğüme Görmediğime kitabı hazırlık deneme sınavı.',
      url: 'deneme-sinavlari.html?level=lise',
      icon: 'fa-solid fa-file-pen',
      actionText: 'Sınava Gir'
    },
    {
      id: 'sinav-yetiskin-1',
      title: 'Yetişkin 1. Deneme Sınavı',
      category: 'yetiskin',
      categoryLabel: 'Yetişkin Düzeyi',
      badgeClass: 'badge-cat-exam',
      type: 'exam',
      typeLabel: 'Online Deneme Sınavı',
      author: '50 Soru • 60 Dakika',
      desc: 'Nasıl İnanmalı kitabı hazırlık deneme sınavı.',
      url: 'deneme-sinavlari.html?level=yetiskin',
      icon: 'fa-solid fa-file-pen',
      actionText: 'Sınava Gir'
    },

    // Sıralamalar & Dashboard
    {
      id: 'siralamalar-liderlik',
      title: 'Türkiye Geneli Sıralamalar',
      category: 'genel',
      categoryLabel: 'Liderlik Tablosu',
      badgeClass: 'badge-cat-rank',
      type: 'page',
      typeLabel: 'Sıralamalar',
      author: '248.500+ Yarışmacı',
      desc: 'İl, ilçe ve okul bazlı anlık puan ve derece sıralaması.',
      url: 'siralamalar.html',
      icon: 'fa-solid fa-trophy',
      actionText: 'Görüntüle'
    },
    {
      id: 'dashboard-sayfam',
      title: 'Gelişim Dashboardı & Rozetlerim',
      category: 'genel',
      categoryLabel: 'Kişisel İstatistikler',
      badgeClass: 'badge-cat-rank',
      type: 'page',
      typeLabel: 'Dashboard',
      author: 'Puan, Okuma Serisi, Rozetler',
      desc: 'Okuma geçmişiniz, kazandığınız puanlar ve başarı rozetleriniz.',
      url: 'dashboard.html',
      icon: 'fa-solid fa-chart-pie',
      actionText: 'Git'
    }
  ];

  // Popüler / Hızlı Arama Önerileri
  const POPULAR_QUICK_SEARCH = [
    { text: 'Tevhid Muhafızları', query: 'Tevhid' },
    { text: 'Kuşların Çağrısı', query: 'Kuşların' },
    { text: 'Deneme Sınavları', query: 'Deneme' },
    { text: 'Ortaokul', query: 'Ortaokul' },
    { text: 'Sıralamalar', query: 'Sıralamalar' }
  ];

  function initHeaderSearch() {
    let triggerBtn = document.getElementById('navSearchTrigger');
    if (!triggerBtn) return;

    // Eğer triggerBtn bir <a> ise <button>'a dönüştür
    if (triggerBtn.tagName === 'A') {
      const newBtn = document.createElement('button');
      newBtn.type = 'button';
      newBtn.className = triggerBtn.className;
      newBtn.id = triggerBtn.id;
      newBtn.title = 'Arama Yap (Ctrl+K)';
      newBtn.innerHTML = triggerBtn.innerHTML;
      triggerBtn.parentNode.replaceChild(newBtn, triggerBtn);
      triggerBtn = newBtn;
    }

    // Ebeveyn kapsayıcının nav-dropdown-wrapper olduğundan emin ol
    let wrapper = triggerBtn.closest('.nav-dropdown-wrapper');
    if (!wrapper) {
      wrapper = document.createElement('div');
      wrapper.className = 'nav-dropdown-wrapper';
      wrapper.id = 'navSearchDropdownWrap';
      triggerBtn.parentNode.insertBefore(wrapper, triggerBtn);
      wrapper.appendChild(triggerBtn);
    }

    // Popover elementi yoksa dinamik oluştur
    let popover = document.getElementById('headerSearchPopover');
    if (!popover) {
      popover = document.createElement('div');
      popover.className = 'portal-popover-menu header-search-popover';
      popover.id = 'headerSearchPopover';
      popover.innerHTML = `
        <div class="header-search-box-wrap">
          <i class="fa-solid fa-magnifying-glass search-box-icon"></i>
          <input type="text" class="header-search-field" id="headerSearchInput" 
                 placeholder="Kitap, sınav veya konu ara..." autocomplete="off">
          <button type="button" class="header-search-clear-btn" id="headerSearchClearBtn" title="Temizle" style="display: none;">
            <i class="fa-solid fa-xmark"></i>
          </button>
          <span class="header-search-kbd d-none d-sm-inline-block">ESC</span>
        </div>

        <div class="header-search-quick-tags" id="headerSearchQuickTags">
          <span class="quick-tag-label">Öneriler:</span>
          ${POPULAR_QUICK_SEARCH.map(item => `
            <button type="button" class="btn-quick-tag" data-query="${item.query}">${item.text}</button>
          `).join('')}
        </div>

        <div class="header-search-body" id="headerSearchResults">
          <!-- JS dinamik render eder -->
        </div>

        <div class="header-search-footer">
          <span class="search-footer-hint d-none d-sm-inline-block">
            <kbd>↑</kbd><kbd>↓</kbd> Gezin <kbd>↵</kbd> Seç
          </span>
          <button type="button" class="btn-all-results" id="btnHeaderSearchAll">
            <span>Tüm sonuçları gör</span>
            <i class="fa-solid fa-arrow-right"></i>
          </button>
        </div>
      `;
      wrapper.appendChild(popover);
    }

    const input = document.getElementById('headerSearchInput');
    const clearBtn = document.getElementById('headerSearchClearBtn');
    const resultsContainer = document.getElementById('headerSearchResults');
    const allResultsBtn = document.getElementById('btnHeaderSearchAll');
    const quickTags = popover.querySelectorAll('.btn-quick-tag');

    let activeIndex = -1;

    // Diğer açık popover'ları kapat
    function closeOtherPopovers() {
      const notifMenu = document.getElementById('notifDropdownMenu');
      const profileMenu = document.getElementById('userProfileDropdownMenu');
      const notifBtn = document.getElementById('notificationBtn');
      const profileBtn = document.getElementById('userNavDropdownBtn');

      if (notifMenu) notifMenu.classList.remove('show');
      if (profileMenu) profileMenu.classList.remove('show');
      if (notifBtn) notifBtn.setAttribute('aria-expanded', 'false');
      if (profileBtn) profileBtn.setAttribute('aria-expanded', 'false');
    }

    // Arama Popover'ını Aç
    function openSearch() {
      closeOtherPopovers();
      popover.classList.add('show');
      triggerBtn.setAttribute('aria-expanded', 'true');
      triggerBtn.classList.add('active');
      renderResults(input.value.trim());
      setTimeout(() => {
        if (input) {
          input.focus();
          input.select();
        }
      }, 100);
    }

    // Arama Popover'ını Kapat
    function closeSearch() {
      popover.classList.remove('show');
      triggerBtn.setAttribute('aria-expanded', 'false');
      triggerBtn.classList.remove('active');
      activeIndex = -1;
    }

    // Arama Popover Toggle
    function toggleSearch(e) {
      if (e) {
        e.preventDefault();
        e.stopPropagation();
      }
      if (popover.classList.contains('show')) {
        closeSearch();
      } else {
        openSearch();
      }
    }

    triggerBtn.addEventListener('click', toggleSearch);

    // Dışarı tıklandığında kapat
    document.addEventListener('click', (e) => {
      if (!wrapper.contains(e.target)) {
        closeSearch();
      }
    });

    // Popover içine tıklandığında kapanmasını önle
    popover.addEventListener('click', (e) => {
      e.stopPropagation();
    });

    // Klavye Kısayolu: Ctrl + K veya /
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        openSearch();
      } else if (e.key === 'Escape' && popover.classList.contains('show')) {
        e.preventDefault();
        closeSearch();
      }
    });

    // Hızlı etiketlere tıklandığında aramayı çalıştır
    quickTags.forEach(tag => {
      tag.addEventListener('click', () => {
        const q = tag.dataset.query;
        if (input) {
          input.value = q;
          clearBtn.style.display = 'inline-flex';
          renderResults(q);
          input.focus();
        }
      });
    });

    // Temizle Butonu
    if (clearBtn) {
      clearBtn.addEventListener('click', () => {
        input.value = '';
        clearBtn.style.display = 'none';
        renderResults('');
        input.focus();
      });
    }

    // Tüm Sonuçları Gör Butonu
    if (allResultsBtn) {
      allResultsBtn.addEventListener('click', () => {
        const q = input.value.trim();
        window.location.href = `kitaplar.html${q ? '?search=' + encodeURIComponent(q) : ''}`;
      });
    }

    // Metin Değiştiğinde Canlı Arama
    input.addEventListener('input', () => {
      const q = input.value.trim();
      if (q) {
        clearBtn.style.display = 'inline-flex';
      } else {
        clearBtn.style.display = 'none';
      }
      activeIndex = -1;
      renderResults(q);
    });

    // Ok tuşları ve Enter navigasyonu
    input.addEventListener('keydown', (e) => {
      const items = resultsContainer.querySelectorAll('.search-result-item');
      if (!items.length) {
        if (e.key === 'Enter') {
          const q = input.value.trim();
          window.location.href = `kitaplar.html${q ? '?search=' + encodeURIComponent(q) : ''}`;
        }
        return;
      }

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        activeIndex = (activeIndex + 1) % items.length;
        updateActiveItem(items);
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIndex = (activeIndex - 1 + items.length) % items.length;
        updateActiveItem(items);
      } else if (e.key === 'Enter') {
        e.preventDefault();
        if (activeIndex >= 0 && items[activeIndex]) {
          items[activeIndex].click();
        } else {
          const q = input.value.trim();
          window.location.href = `kitaplar.html${q ? '?search=' + encodeURIComponent(q) : ''}`;
        }
      }
    });

    function updateActiveItem(items) {
      items.forEach((it, idx) => {
        if (idx === activeIndex) {
          it.classList.add('item-active');
          it.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        } else {
          it.classList.remove('item-active');
        }
      });
    }

    // Vurgu (Highlight) Fonksiyonu
    function highlightMatch(text, query) {
      if (!query) return text;
      const cleanQ = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
      const regex = new RegExp(`(${cleanQ})`, 'gi');
      return text.replace(regex, '<mark class="search-highlight">$1</mark>');
    }

    // Sonuçları Çiz
    function renderResults(query) {
      const q = query.toLowerCase().trim();

      if (!q) {
        // Boşken: Hızlı Erişim / Popüler Kitaplar Listesi
        const popularItems = HEADER_SEARCH_DATA.slice(0, 6);
        resultsContainer.innerHTML = `
          <div class="search-section-header">
            <i class="fa-solid fa-fire text-warning me-1"></i>
            <span>Popüler ve Hızlı Erişim</span>
          </div>
          <div class="search-results-list">
            ${popularItems.map(item => renderItemHtml(item, '')).join('')}
          </div>
        `;
        bindItemEvents();
        return;
      }

      // Filtreleme
      const matches = HEADER_SEARCH_DATA.filter(item => {
        return item.title.toLowerCase().includes(q) ||
               item.desc.toLowerCase().includes(q) ||
               item.categoryLabel.toLowerCase().includes(q) ||
               item.author.toLowerCase().includes(q) ||
               item.typeLabel.toLowerCase().includes(q);
      });

      if (matches.length === 0) {
        resultsContainer.innerHTML = `
          <div class="search-empty-state">
            <div class="empty-icon-wrap">
              <i class="fa-regular fa-folder-open"></i>
            </div>
            <div class="empty-title">"${escapeHtml(query)}" için sonuç bulunamadı</div>
            <div class="empty-desc">Farklı bir kelime deneyebilir veya tüm arşivde arayabilirsiniz.</div>
            <a href="kitaplar.html?search=${encodeURIComponent(query)}" class="btn btn-sm btn-primary rounded-pill mt-2">
              Kitaplar Sayfasında Ara
            </a>
          </div>
        `;
        return;
      }

      // Sonuçları Gruplama
      const books = matches.filter(m => m.type === 'book');
      const exams = matches.filter(m => m.type === 'exam');
      const others = matches.filter(m => m.type === 'page');

      let html = '';

      if (books.length > 0) {
        html += `
          <div class="search-section-header">
            <i class="fa-solid fa-book-bookmark text-primary me-1"></i>
            <span>Kitaplar (${books.length})</span>
          </div>
          <div class="search-results-list">
            ${books.map(item => renderItemHtml(item, q)).join('')}
          </div>
        `;
      }

      if (exams.length > 0) {
        html += `
          <div class="search-section-header mt-2">
            <i class="fa-solid fa-file-pen text-success me-1"></i>
            <span>Deneme Sınavları (${exams.length})</span>
          </div>
          <div class="search-results-list">
            ${exams.map(item => renderItemHtml(item, q)).join('')}
          </div>
        `;
      }

      if (others.length > 0) {
        html += `
          <div class="search-section-header mt-2">
            <i class="fa-solid fa-trophy text-warning me-1"></i>
            <span>Sıralamalar & Dashboard (${others.length})</span>
          </div>
          <div class="search-results-list">
            ${others.map(item => renderItemHtml(item, q)).join('')}
          </div>
        `;
      }

      resultsContainer.innerHTML = html;
      bindItemEvents();
    }

    function renderItemHtml(item, query) {
      return `
        <a href="${item.url}" class="search-result-item" data-id="${item.id}">
          <div class="search-item-icon-box ${item.badgeClass}">
            <i class="${item.icon}"></i>
          </div>
          <div class="search-item-info">
            <div class="search-item-title-row">
              <span class="search-item-title">${highlightMatch(item.title, query)}</span>
              <span class="search-item-badge ${item.badgeClass}">${item.categoryLabel}</span>
            </div>
            <div class="search-item-desc">${highlightMatch(item.desc, query)}</div>
          </div>
          <div class="search-item-action">
            <span class="action-label">${item.actionText}</span>
            <i class="fa-solid fa-chevron-right action-arrow"></i>
          </div>
        </a>
      `;
    }

    function bindItemEvents() {
      const items = resultsContainer.querySelectorAll('.search-result-item');
      items.forEach(it => {
        it.addEventListener('mouseenter', () => {
          items.forEach(el => el.classList.remove('item-active'));
          it.classList.add('item-active');
        });
      });
    }

    function escapeHtml(str) {
      return str.replace(/[&<>'"]/g, 
        tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag)
      );
    }
  }

  // Sayfa yüklendiğinde başlat
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeaderSearch);
  } else {
    initHeaderSearch();
  }
})();
