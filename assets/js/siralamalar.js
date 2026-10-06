/**
 * Ufka Yolculuk - Liderlik & Başarı Sıralaması Dinamik Motoru (siralamalar.js)
 */

document.addEventListener('DOMContentLoaded', () => {
  initLeaderboardEngine();
});

const LEADERBOARD_DATA = [
  { rank: 1, name: 'Zeynep Sare Aydın', school: 'Kadıköy Anadolu İHL', city: 'İstanbul / Kadıköy', category: 'ortaokul', book: 'Tevhid Muhafızları', dogru: 100, yanlis: 0, net: '100.00', puan: 100.0, time: '38 Dk', badge: 'Altın Deha', avatar: 'assets/images/user-avatar.png' },
  { rank: 2, name: 'Ömer Faruk Çelik', school: 'Pursaklar Fen Lisesi', city: 'Ankara / Pursaklar', category: 'lise', book: 'Gördüğüme Görmediğime', dogru: 99, yanlis: 1, net: '98.75', puan: 98.8, time: '42 Dk', badge: 'Gümüş Zeka', avatar: 'assets/images/user-avatar.png' },
  { rank: 3, name: 'Elif Berra Yılmaz', school: 'Meram Mehmet Akif Ersoy OO', city: 'Konya / Meram', category: 'ilkokul', book: 'Kuşların Çağrısı', dogru: 98, yanlis: 2, net: '97.50', puan: 97.5, time: '45 Dk', badge: 'Bronz Yıldız', avatar: 'assets/images/user-avatar.png' },
  { rank: 4, name: 'Mustafa Talha Demir', school: 'Nilüfer Anadolu Lisesi', city: 'Bursa / Nilüfer', category: 'lise', book: 'Gördüğüme Görmediğime', dogru: 97, yanlis: 3, net: '96.25', puan: 96.3, time: '48 Dk', badge: 'Kitap Kurdu', avatar: 'assets/images/user-avatar.png' },
  { rank: 5, name: 'Ayşe Hümeyra Koç', school: 'Bornova Şehit Erol OO', city: 'İzmir / Bornova', category: 'ortaokul', book: 'Tevhid Muhafızları', dogru: 96, yanlis: 3, net: '95.25', puan: 95.3, time: '50 Dk', badge: 'Bilgi Ustası', avatar: 'assets/images/user-avatar.png' },
  { rank: 6, name: 'Kerem Ali Şahin', school: 'Kocasinan Atatürk İlkokulu', city: 'Kayseri / Kocasinan', category: 'ilkokul', book: 'Kuşların Çağrısı', dogru: 95, yanlis: 4, net: '94.00', puan: 94.0, time: '49 Dk', badge: 'Bilgi Ustası', avatar: 'assets/images/user-avatar.png' },
  { rank: 7, name: 'Merve Nur Polat', school: 'Marmara Üniversitesi', city: 'İstanbul / Üsküdar', category: 'yetiskin', book: 'Nasıl İnanmalı?', dogru: 95, yanlis: 5, net: '93.75', puan: 93.8, time: '52 Dk', badge: 'Kültür Öncüsü', avatar: 'assets/images/user-avatar.png' },
  { rank: 8, name: 'Yusuf Emre Karaca', school: 'Gaziantep Şahinbey OO', city: 'Gaziantep / Şahinbey', category: 'ortaokul', book: 'Tevhid Muhafızları', dogru: 94, yanlis: 4, net: '93.00', puan: 93.0, time: '54 Dk', badge: 'Bilgi Avcısı', avatar: 'assets/images/user-avatar.png' },
  { rank: 9, name: 'Fatma Zehra Aksoy', school: 'Kepez Mahmut Celalettin OO', city: 'Antalya / Kepez', category: 'ilkokul', book: 'Kuşların Çağrısı', dogru: 94, yanlis: 6, net: '92.50', puan: 92.5, time: '55 Dk', badge: 'Bilgi Avcısı', avatar: 'assets/images/user-avatar.png' },
  { rank: 10, name: 'Mehmet Akif Güler', school: 'Samsun Atakum Fen Lisesi', city: 'Samsun / Atakum', category: 'lise', book: 'Gördüğüme Görmediğime', dogru: 93, yanlis: 5, net: '91.75', puan: 91.8, time: '56 Dk', badge: 'Azimli Okur', avatar: 'assets/images/user-avatar.png' },
  { rank: 142, isCurrentUser: true, name: 'Ahmet Yılmaz (Siz)', school: 'Üsküdar Çamlıca İHL', city: 'İstanbul / Üsküdar', category: 'ortaokul', book: 'Tevhid Muhafızları', dogru: 91, yanlis: 8, net: '89.00', puan: 89.4, time: '58 Dk', badge: 'Gelişim Yıldızı', avatar: 'assets/images/user-avatar.png' }
];

function initLeaderboardEngine() {
  const catSelect = document.getElementById('siraCategoryFilter');
  const timeSelect = document.getElementById('siraTimeFilter');
  const citySelect = document.getElementById('siraCityFilter');
  const searchInput = document.getElementById('siraSearchInput');
  const tableBody = document.getElementById('leaderboardTableBody');
  const totalCountBadge = document.getElementById('totalParticipantsCount');

  function renderTable() {
    if (!tableBody) return;

    const cat = catSelect ? catSelect.value.toLowerCase() : 'all';
    const city = citySelect ? citySelect.value.toLowerCase() : 'all';
    const query = searchInput ? searchInput.value.trim().toLowerCase() : '';

    const filtered = LEADERBOARD_DATA.filter(item => {
      const matchCat = (cat === 'all' || item.category === cat);
      const matchCity = (city === 'all' || item.city.toLowerCase().includes(city));
      const matchQuery = (!query || item.name.toLowerCase().includes(query) || item.school.toLowerCase().includes(query) || item.city.toLowerCase().includes(query));
      return matchCat && matchCity && matchQuery;
    });

    if (totalCountBadge) {
      totalCountBadge.textContent = `${filtered.length} Yarışmacı Listelendi`;
    }

    tableBody.innerHTML = '';

    if (filtered.length === 0) {
      tableBody.innerHTML = `
        <tr>
          <td colspan="8" class="text-center py-5 text-muted">
            <i class="fa-solid fa-search fs-3 mb-2 d-block opacity-50"></i>
            Aradığınız kriterlere uygun sonuç bulunamadı.
          </td>
        </tr>
      `;
      return;
    }

    filtered.forEach(item => {
      const isUser = !!item.isCurrentUser;
      const tr = document.createElement('tr');
      if (isUser) tr.className = 'user-row';

      let rankDisplay = `#${item.rank}`;
      let rankClass = 'rank-index-num';
      if (item.rank === 1) { rankDisplay = '<i class="fa-solid fa-trophy text-warning"></i> 1'; rankClass += ' gold'; }
      else if (item.rank === 2) { rankDisplay = '<i class="fa-solid fa-medal text-secondary"></i> 2'; rankClass += ' silver'; }
      else if (item.rank === 3) { rankDisplay = '<i class="fa-solid fa-medal text-amber"></i> 3'; rankClass += ' bronze'; }

      let categoryBadgeColor = 'primary';
      if (item.category === 'ilkokul') categoryBadgeColor = 'purple';
      else if (item.category === 'ortaokul') categoryBadgeColor = 'primary';
      else if (item.category === 'lise') categoryBadgeColor = 'warning';
      else if (item.category === 'yetiskin') categoryBadgeColor = 'teal';

      // İsim baş harfleri hesaplama
      const cleanName = item.name.replace(/\s*\(.*?\)\s*/g, '').trim();
      const nameParts = cleanName.split(/\s+/).filter(Boolean);
      const initials = nameParts.length > 1
        ? (nameParts[0][0] + nameParts[nameParts.length - 1][0]).toUpperCase()
        : cleanName.substring(0, 2).toUpperCase();

      // Renk paleti
      let avatarColor = 'avatar-color-blue';
      if (isUser) avatarColor = 'avatar-color-blue';
      else if (item.rank === 1) avatarColor = 'avatar-color-gold';
      else if (item.rank === 2) avatarColor = 'avatar-color-silver';
      else if (item.rank === 3) avatarColor = 'avatar-color-bronze';
      else {
        const colorList = ['avatar-color-indigo', 'avatar-color-purple', 'avatar-color-emerald', 'avatar-color-rose', 'avatar-color-teal', 'avatar-color-amber'];
        avatarColor = colorList[item.rank % colorList.length];
      }

      tr.innerHTML = `
        <td class="text-center"><span class="${rankClass}">${rankDisplay}</span></td>
        <td>
          <div class="participant-cell">
            <div class="participant-avatar-initials ${avatarColor}" title="${item.name}">
              ${initials}
            </div>
            <div>
              <div class="participant-name">${item.name} ${isUser ? '<span class="badge bg-primary text-white ms-1" style="font-size: 0.65rem;">SİZ</span>' : ''}</div>
              <div class="participant-school">${item.school}</div>
            </div>
          </div>
        </td>
        <td>
          <span class="badge bg-${categoryBadgeColor}-subtle text-${categoryBadgeColor} fw-bold" style="font-size: 0.72rem;">
            ${item.book}
          </span>
        </td>
        <td><span class="text-muted small">${item.city}</span></td>
        <td class="text-center">
          <span class="text-success fw-bold">${item.dogru} D</span> / <span class="text-danger fw-bold">${item.yanlis} Y</span>
        </td>
        <td class="text-center fw-bold text-primary">${item.net}</td>
        <td class="text-center">
          <span class="badge bg-success text-white fw-bold px-2.5 py-1" style="font-size: 0.82rem;">${item.puan}</span>
        </td>
        <td class="text-center">
          <span class="badge bg-light text-muted border fw-semibold" style="font-size: 0.72rem;">${item.badge}</span>
        </td>
      `;

      tableBody.appendChild(tr);
    });
  }

  if (catSelect) catSelect.addEventListener('change', renderTable);
  if (timeSelect) timeSelect.addEventListener('change', renderTable);
  if (citySelect) citySelect.addEventListener('change', renderTable);
  if (searchInput) searchInput.addEventListener('input', renderTable);

  renderTable();
}
