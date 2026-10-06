/**
 * UFKA YOLCULUK - ÜYE İSTATİSTİKLERİ & DASHBOARD MOTORU
 * dashboard.js
 */

document.addEventListener('DOMContentLoaded', () => {
  initDashboard();
});

function initDashboard() {
  initPopoverDropdowns();
  initStatsFilterTabs();
  initBadgeInteractions();
  initGoalEditModal();
}

/**
 * Üst Bar Popover Menüleri
 */
function initPopoverDropdowns() {
  const notifBtn = document.getElementById('notificationBtn');
  const notifMenu = document.getElementById('notifDropdownMenu');
  const userBtn = document.getElementById('userNavDropdownBtn');
  const userMenu = document.getElementById('userProfileDropdownMenu');

  if (notifBtn && notifMenu) {
    notifBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = notifMenu.classList.contains('show');
      closeAllPopovers();
      if (!isOpen) notifMenu.classList.add('show');
    });
  }

  if (userBtn && userMenu) {
    userBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = userMenu.classList.contains('show');
      closeAllPopovers();
      if (!isOpen) userMenu.classList.add('show');
    });
  }

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.portal-popover-menu') && !e.target.closest('.nav-dropdown-wrapper')) {
      closeAllPopovers();
    }
  });

  function closeAllPopovers() {
    if (notifMenu) notifMenu.classList.remove('show');
    if (userMenu) userMenu.classList.remove('show');
  }

  // Bildirimleri okundu yap
  const markReadBtn = document.getElementById('markAllNotifsRead');
  const notifBadge = document.getElementById('notifCountBadge');
  const notifPill = document.getElementById('notifUnreadPill');
  if (markReadBtn) {
    markReadBtn.addEventListener('click', () => {
      document.querySelectorAll('.notif-item-row.unread').forEach(r => r.classList.remove('unread'));
      document.querySelectorAll('.notif-unread-dot').forEach(d => d.style.display = 'none');
      if (notifBadge) notifBadge.style.display = 'none';
      if (notifPill) notifPill.textContent = '0 Yeni';
    });
  }
}

/**
 * İstatistik Filtreleri (Bu Hafta / Bu Ay / Tüm Zamanlar)
 */
function initStatsFilterTabs() {
  const tabs = document.querySelectorAll('.dash-tab-btn');
  const metricPage = document.getElementById('statMetricPage');
  const metricAudio = document.getElementById('statMetricAudio');
  const metricBook = document.getElementById('statMetricBook');
  const metricPoint = document.getElementById('statMetricPoint');
  const chartBluePath = document.getElementById('chartBluePath');
  const chartPurplePath = document.getElementById('chartPurplePath');
  const chartDotsGroup = document.getElementById('chartDotsGroup');

  const filterDatasets = {
    week: {
      pages: '125',
      pagesGrowth: '+18%',
      audio: '245 dk',
      audioGrowth: '+24%',
      books: '2',
      booksGrowth: '+1',
      points: '2.450',
      pointsGrowth: '+350',
      bluePath: 'M 50 120 C 85 120, 85 85, 120 85 C 155 85, 155 105, 190 105 C 225 105, 225 45, 260 45 C 295 45, 295 80, 330 80 C 365 80, 365 55, 400 55 C 435 55, 435 25, 470 25',
      purplePath: 'M 50 135 C 85 135, 85 110, 120 110 C 155 110, 155 90, 190 90 C 225 90, 225 65, 260 65 C 295 65, 295 95, 330 95 C 365 95, 365 75, 400 75 C 435 75, 435 45, 470 45',
      dots: [
        { cx: 50, cy: 120, val: 'Pzt: 12 sf / 20 dk' },
        { cx: 120, cy: 85, val: 'Sal: 25 sf / 35 dk' },
        { cx: 190, cy: 105, val: 'Çar: 18 sf / 45 dk' },
        { cx: 260, cy: 45, val: 'Per: 40 sf / 60 dk' },
        { cx: 330, cy: 80, val: 'Cum: 28 sf / 30 dk' },
        { cx: 400, cy: 55, val: 'Cmt: 36 sf / 50 dk' },
        { cx: 470, cy: 25, val: 'Paz: 52 sf / 85 dk' }
      ]
    },
    month: {
      pages: '480',
      pagesGrowth: '+32%',
      audio: '920 dk',
      audioGrowth: '+45%',
      books: '3',
      booksGrowth: '+2',
      points: '5.120',
      pointsGrowth: '+1.200',
      bluePath: 'M 50 130 C 85 130, 85 100, 120 100 C 155 100, 155 70, 190 70 C 225 70, 225 40, 260 40 C 295 40, 295 30, 330 30 C 365 30, 365 20, 400 20 C 435 20, 435 15, 470 15',
      purplePath: 'M 50 140 C 85 140, 85 115, 120 115 C 155 115, 155 85, 190 85 C 225 85, 225 60, 260 60 C 295 60, 295 50, 330 50 C 365 50, 365 35, 400 35 C 435 35, 435 25, 470 25',
      dots: [
        { cx: 50, cy: 130, val: '1. Hafta: 95 sf' },
        { cx: 120, cy: 100, val: '2. Hafta: 120 sf' },
        { cx: 190, cy: 70, val: '3. Hafta: 155 sf' },
        { cx: 260, cy: 40, val: '4. Hafta: 180 sf' },
        { cx: 330, cy: 30, val: 'Ay Sonu: Zirve' },
        { cx: 400, cy: 20, val: 'Ort: 45 dk/gün' },
        { cx: 470, cy: 15, val: 'Toplam: 480 sf' }
      ]
    },
    all: {
      pages: '1.240',
      pagesGrowth: '+100%',
      audio: '2.850 dk',
      audioGrowth: '+100%',
      books: '8',
      booksGrowth: '+8',
      points: '12.450',
      pointsGrowth: '+12.450',
      bluePath: 'M 50 140 C 85 140, 85 110, 120 110 C 155 110, 155 75, 190 75 C 225 75, 225 45, 260 45 C 295 45, 295 25, 330 25 C 365 25, 365 15, 400 15 C 435 15, 435 10, 470 10',
      purplePath: 'M 50 145 C 85 145, 85 125, 120 125 C 155 125, 155 95, 190 95 C 225 95, 225 65, 260 65 C 295 65, 295 40, 330 40 C 365 40, 365 25, 400 25 C 435 25, 435 18, 470 18',
      dots: [
        { cx: 50, cy: 140, val: 'Eylül: Başlangıç' },
        { cx: 120, cy: 110, val: 'Ekim: 200 sf' },
        { cx: 190, cy: 75, val: 'Kasım: 450 sf' },
        { cx: 260, cy: 45, val: 'Aralık: 780 sf' },
        { cx: 330, cy: 25, val: 'Ocak: 950 sf' },
        { cx: 400, cy: 15, val: 'Şubat: 1.100 sf' },
        { cx: 470, cy: 10, val: 'Mart: 1.240 sf' }
      ]
    }
  };

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const filterKey = tab.getAttribute('data-filter') || 'week';
      const data = filterDatasets[filterKey];

      if (data) {
        if (metricPage) metricPage.textContent = data.pages;
        if (metricAudio) metricAudio.textContent = data.audio;
        if (metricBook) metricBook.textContent = data.books;
        if (metricPoint) metricPoint.textContent = data.points;

        if (chartBluePath) chartBluePath.setAttribute('d', data.bluePath);
        if (chartPurplePath) chartPurplePath.setAttribute('d', data.purplePath);

        if (chartDotsGroup) {
          chartDotsGroup.innerHTML = '';
          data.dots.forEach(d => {
            const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circle.setAttribute('cx', d.cx);
            circle.setAttribute('cy', d.cy);
            circle.setAttribute('class', 'dash-chart-dot');
            circle.setAttribute('data-info', d.val);
            circle.addEventListener('mouseenter', showTooltip);
            circle.addEventListener('mouseleave', hideTooltip);
            chartDotsGroup.appendChild(circle);
          });
        }
      }
    });
  });

  const tooltip = document.getElementById('chartTooltip');

  function showTooltip(e) {
    if (!tooltip) return;
    const info = e.target.getAttribute('data-info');
    if (!info) return;

    tooltip.textContent = info;
    tooltip.style.display = 'block';
    const rect = e.target.getBoundingClientRect();
    const parentRect = document.querySelector('.dash-chart-wrapper').getBoundingClientRect();

    tooltip.style.left = (rect.left - parentRect.left - 20) + 'px';
    tooltip.style.top = (rect.top - parentRect.top - 32) + 'px';
  }

  function hideTooltip() {
    if (tooltip) tooltip.style.display = 'none';
  }
}

/**
 * Rozet Tıklama ve Detay Modalı
 */
function initBadgeInteractions() {
  const badgeItems = document.querySelectorAll('.dash-badge-item');
  const modalEl = document.getElementById('modalBadgeDetail');
  if (!modalEl) return;

  const modalTitle = document.getElementById('badgeModalTitle');
  const modalDesc = document.getElementById('badgeModalDesc');
  const modalDate = document.getElementById('badgeModalDate');
  const modalPoints = document.getElementById('badgeModalPoints');
  const modalIcon = document.getElementById('badgeModalIcon');

  badgeItems.forEach(item => {
    item.addEventListener('click', () => {
      const name = item.getAttribute('data-badge-name') || 'Rozet';
      const desc = item.getAttribute('data-badge-desc') || 'Ufka Yolculuk başarımı.';
      const date = item.getAttribute('data-badge-date') || 'Kazanıldı';
      const points = item.getAttribute('data-badge-points') || '+50 Puan';
      const isLocked = item.classList.contains('locked');
      const iconClass = item.querySelector('i') ? item.querySelector('i').className : 'fa-solid fa-trophy';

      if (modalTitle) modalTitle.textContent = name;
      if (modalDesc) modalDesc.textContent = desc;
      if (modalDate) {
        modalDate.innerHTML = isLocked 
          ? '<i class="fa-solid fa-lock me-1 text-muted"></i>Henüz Kazanılmadı' 
          : `<i class="fa-regular fa-calendar-check me-1 text-primary"></i>Kazanılma: ${date}`;
      }
      if (modalPoints) {
        modalPoints.textContent = points;
        modalPoints.className = isLocked ? 'badge bg-secondary text-white fs-7 fw-bold px-3 py-2 rounded-pill' : 'badge bg-warning text-dark fs-7 fw-bold px-3 py-2 rounded-pill shadow-xs';
      }
      if (modalIcon) {
        modalIcon.innerHTML = '<i class="' + iconClass + '"></i>';
        modalIcon.className = isLocked ? 'dash-badge-icon-box locked mx-auto' : 'dash-badge-icon-box gold mx-auto';
      }

      if (window.bootstrap) {
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
      }
    });
  });
}

/**
 * Hedef Düzenleme Etkileşimi
 */
function initGoalEditModal() {
  const btnEditGoal = document.getElementById('btnEditGoal');
  const modalEl = document.getElementById('modalEditGoal');
  const inputGoal = document.getElementById('inputGoalMinutes');
  const btnSaveGoal = document.getElementById('btnSaveGoal');
  const goalNums = document.getElementById('dashGoalNums');
  const goalFill = document.getElementById('dashGoalFill');
  const goalInfo = document.getElementById('dashGoalInfo');

  if (btnEditGoal && modalEl) {
    btnEditGoal.addEventListener('click', () => {
      if (window.bootstrap) {
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
      }
    });
  }

  if (btnSaveGoal && inputGoal) {
    btnSaveGoal.addEventListener('click', () => {
      const targetMin = parseInt(inputGoal.value, 10);
      if (!isNaN(targetMin) && targetMin >= 10) {
        const currentMin = 300;
        const percent = Math.min(100, Math.round((currentMin / targetMin) * 100));

        if (goalNums) {
          goalNums.innerHTML = currentMin + ' <span>/ ' + targetMin + ' dk</span>';
        }
        if (goalFill) {
          goalFill.style.width = percent + '%';
        }
        if (goalInfo) {
          goalInfo.textContent = 'Harika! Hedefinin %' + percent + "'ine ulaştın.";
        }

        if (window.bootstrap) {
          const bsModal = bootstrap.Modal.getInstance(modalEl);
          if (bsModal) bsModal.hide();
        }
      }
    });
  }
}
