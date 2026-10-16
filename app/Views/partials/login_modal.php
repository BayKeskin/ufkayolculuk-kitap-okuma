<!-- =========================================================================
     YARIŞMACI GİRİŞ MODALI (Login Modal)
     ========================================================================= -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden">
      <!-- Modal Üst Banner -->
      <div class="p-4 text-white text-center position-relative" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Kapat"></button>
        <div class="mx-auto mb-3 shadow d-flex align-items-center justify-content-center" style="width: 58px; height: 58px; background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.4); border-radius: 50%; font-size: 1.6rem;">
          <i class="fa-solid fa-user-lock"></i>
        </div>
        <h4 class="modal-title fw-bold mb-1" id="loginModalLabel">Yarışmacı Girişi</h4>
        <p class="mb-0 text-white-50 fs-7">Ufka Yolculuk Kitap Okuma & Sınav Portalı</p>
      </div>

      <!-- Modal Gövdesi -->
      <div class="modal-body p-4 bg-white">
        <!-- Bildirim Kutusu -->
        <div id="loginAlertBox" class="alert d-none mb-3 py-2 px-3 fs-7" role="alert"></div>

        <form id="portalLoginForm" novalidate>
          <!-- Telefon Numarası -->
          <div class="mb-3">
            <label for="loginPhone" class="form-label fw-bold text-dark small mb-1">
              Telefon Numarası <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0">
                <i class="fa-solid fa-phone"></i>
              </span>
              <input type="tel" name="phone" id="loginPhone" class="form-control border-start-0" placeholder="05XXXXXXXXX veya 5XXXXXXXXX" required autocomplete="tel">
            </div>
            <div class="form-text fs-8 text-muted">Yarışmaya kayıt olurken belirttiğiniz cep telefonu.</div>
          </div>

          <!-- Doğum Tarihi -->
          <div class="mb-3">
            <label for="loginBirthDate" class="form-label fw-bold text-dark small mb-1">
              Doğum Tarihi <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0">
                <i class="fa-solid fa-calendar-days"></i>
              </span>
              <input type="date" name="birthdate" id="loginBirthDate" class="form-control border-start-0" required>
            </div>
            <div class="form-text fs-8 text-muted">Güvenlik doğrulaması için doğum tarihinizi seçiniz.</div>
          </div>

          <!-- Bilgilendirme Kartı -->
          <div class="p-2.5 rounded-3 mb-4 bg-light border d-flex align-items-center gap-2 fs-8 text-muted">
            <i class="fa-solid fa-shield-halved text-primary fs-6"></i>
            <span>Giriş bilgileriniz Ufka Yolculuk merkezi veri tabanı üzerinden canlı olarak doğrulanmaktadır.</span>
          </div>

          <!-- Butonlar -->
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm py-2.5 d-flex align-items-center justify-content-center gap-2" id="btnLoginSubmit">
              <span class="spinner-border spinner-border-sm d-none" id="loginSpinner" role="status" aria-hidden="true"></span>
              <span id="loginBtnText">Giriş Yap</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>

      <!-- Modal Alt Bilgi -->
      <div class="modal-footer bg-light border-top p-3 justify-content-center text-center">
        <span class="fs-8 text-muted">Henüz yarışmaya kayıt olmadınız mı?</span>
        <a href="https://ufkayolculuk.com/kayit" target="_blank" class="fs-8 text-primary fw-bold text-decoration-none ms-1">
          Kayıt Ol <i class="fa-solid fa-arrow-up-right-from-square ms-0.5"></i>
        </a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById('portalLoginForm');
  const alertBox = document.getElementById('loginAlertBox');
  const btnSubmit = document.getElementById('btnLoginSubmit');
  const spinner = document.getElementById('loginSpinner');
  const btnText = document.getElementById('loginBtnText');
  const loginModalEl = document.getElementById('loginModal');

  // URL'de auth_required parametresi varsa otomatik login modalını aç
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('auth_required') || urlParams.has('login')) {
    if (loginModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      const modalInstance = new bootstrap.Modal(loginModalEl);
      modalInstance.show();
      showAlert('Lütfen devam etmek veya korumalı sayfayı görüntülemek için giriş yapınız.', 'warning');
    }
  }

  function showAlert(msg, type = 'danger') {
    if (!alertBox) return;
    alertBox.className = `alert alert-${type} mb-3 py-2 px-3 fs-7`;
    alertBox.innerHTML = `<i class="fa-solid fa-circle-info me-2"></i>${msg}`;
    alertBox.classList.remove('d-none');
  }

  if (loginForm) {
    loginForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      const phoneInput = document.getElementById('loginPhone');
      const birthDateInput = document.getElementById('loginBirthDate');

      const phone = phoneInput ? phoneInput.value.trim() : '';
      const birthdate = birthDateInput ? birthDateInput.value.trim() : '';

      if (!phone || !birthdate) {
        showAlert('Lütfen telefon numaranızı ve doğum tarihinizi eksiksiz doldurunuz.', 'danger');
        return;
      }

      // Loading state
      if (btnSubmit) btnSubmit.disabled = true;
      if (spinner) spinner.classList.remove('d-none');
      if (btnText) btnText.textContent = 'Doğrulanıyor...';
      if (alertBox) alertBox.classList.add('d-none');

      try {
        const baseUrl = window.BASE_URL || '<?= rtrim(base_url(), '/') . '/' ?>';
        const response = await fetch(`${baseUrl}auth/login`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({ phone, birthdate })
        });

        const data = await response.json();

        if (response.ok && data.success) {
          showAlert(data.message || 'Giriş başarılı! Yönlendiriliyorsunuz...', 'success');
          setTimeout(() => {
            if (data.redirect && data.redirect !== window.location.href) {
              window.location.href = data.redirect;
            } else {
              window.location.reload();
            }
          }, 800);
        } else {
          showAlert(data.message || 'Giriş bilgileri doğrulanamadı.', 'danger');
          if (btnSubmit) btnSubmit.disabled = false;
          if (spinner) spinner.classList.add('d-none');
          if (btnText) btnText.textContent = 'Giriş Yap';
        }
      } catch (err) {
        console.error('Giriş hatası:', err);
        showAlert('Bağlantı sırasında bir hata oluştu. Lütfen tekrar deneyiniz.', 'danger');
        if (btnSubmit) btnSubmit.disabled = false;
        if (spinner) spinner.classList.add('d-none');
        if (btnText) btnText.textContent = 'Giriş Yap';
      }
    });
  }
});
</script>
