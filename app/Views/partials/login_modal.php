<!-- =========================================================================
     GİRİŞ YAP MODALI (C:\wamp64\www\ufkayolculuk İLE BİREBİR AYNI TASARIM)
     ========================================================================= -->
<style>
/* ==========================================================================
   14. GİRİŞ YAP MODAL STİLLERİ (C:\wamp64\www\ufkayolculuk İLE BİREBİR AYNI)
   ========================================================================== */
.custom-login-modal {
  border-radius: 20px;
  border: 1px solid #E5EBF0;
  overflow: hidden;
  background-color: #FFFFFF;
}

.modal-icon-badge {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: #EFF6FF;
  color: #0a174d;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.input-group-custom {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-prefix {
  position: absolute;
  left: 14px;
  color: #94A3B8;
  pointer-events: none;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 5;
}

.form-control-custom {
  padding-left: 44px !important;
  padding-top: 0.65rem;
  padding-bottom: 0.65rem;
  border-radius: 8px;
  border: 1px solid #E5EBF0;
  font-size: 0.925rem;
  color: #0F172A;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  background-color: #FAFBFD;
  width: 100%;
}

.form-control-custom:focus {
  background-color: #FFFFFF;
  border-color: #fcc626;
  box-shadow: 0 0 0 3px rgba(252, 198, 38, 0.25);
  outline: none;
}

.login-info-box {
  background: #EFF6FF;
  border: 1px solid #DBEAFE;
  border-radius: 8px;
  padding: 0.65rem 0.85rem;
  font-size: 0.775rem;
  color: #1E3A8A;
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  line-height: 1.4;
}

.btn-yellow {
  background-color: #fcc626;
  color: #1E293B !important;
  font-weight: 700;
  border-radius: 8px;
  padding: 0.55rem 1.25rem;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  text-decoration: none;
  cursor: pointer;
}

.btn-yellow:hover {
  background-color: #E09415;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(245, 166, 35, 0.3);
}

.btn-yellow:disabled {
  opacity: 0.75;
  cursor: not-allowed;
  transform: none;
}
</style>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-login-modal shadow-lg">

      <!-- Modal Başlık -->
      <div class="modal-header border-0 pb-0 pt-4 px-4 align-items-center">
        <div class="d-flex align-items-center gap-2">
          <div class="modal-icon-badge">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-dark mb-0" id="loginModalLabel">Yarışmacı Girişi</h5>
            <small class="text-muted">Ufka Yolculuk Yarışmacı Paneli</small>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>

      <!-- Modal Gövde -->
      <div class="modal-body p-4">
        <!-- Giriş Durum Bildirim Kutusu -->
        <div id="loginAlertBox" class="mb-3 d-none"></div>

        <form id="loginForm" action="<?= base_url('auth/login') ?>" method="POST" novalidate>
          <?= csrf_field() ?>

          <!-- 1. Telefon Numarası -->
          <div class="mb-3">
            <label for="loginPhone" class="form-label fw-bold text-dark small mb-1">
              Telefon Numarası <span class="text-danger">*</span>
            </label>
            <div class="input-group-custom">
              <span class="input-icon-prefix">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
              </span>
              <input type="tel" name="phone" class="form-control form-control-custom" id="loginPhone"
                placeholder="0 (5XX) XXX XX XX" maxlength="17" required autocomplete="tel">
            </div>
            <div class="form-text small text-muted">Kayıt olurken belirttiğiniz cep telefonu numarası.</div>
          </div>

          <!-- 2. Doğum Tarihi -->
          <div class="mb-3">
            <label for="loginBirthDate" class="form-label fw-bold text-dark small mb-1">
              Doğum Tarihi <span class="text-danger">*</span>
            </label>
            <div class="input-group-custom">
              <span class="input-icon-prefix">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2" />
                  <line x1="16" y1="2" x2="16" y2="6" stroke-width="2" stroke-linecap="round" />
                  <line x1="8" y1="2" x2="8" y2="6" stroke-width="2" stroke-linecap="round" />
                  <line x1="3" y1="10" x2="21" y2="10" stroke-width="2" />
                </svg>
              </span>
              <input type="date" name="birthdate" class="form-control form-control-custom" id="loginBirthDate" required>
            </div>
            <div class="form-text small text-muted">Güvenlik doğrulaması için doğum tarihinizi seçiniz.</div>
          </div>

          <!-- Bilgilendirme Kutusu -->
          <div class="login-info-box mb-4">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"
              class="flex-shrink-0 text-primary mt-0.5">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd" />
            </svg>
            <span>Giriş bilgileriniz yarışma veri tabanımız ile güvenli şekilde eşleştirilmektedir.</span>
          </div>

          <!-- Giriş Butonu -->
          <button type="submit" class="btn-yellow w-100 justify-content-center py-2 fs-6 fw-bold" id="btnLoginSubmit">
            <span>Giriş Yap</span>
            <span class="ms-1">→</span>
          </button>
        </form>
      </div>

      <!-- Modal Alt Bilgi -->
      <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center flex-column gap-2 text-center">
        <div class="small text-muted">
          Henüz kayıt olmadınız mı? 
          <a href="https://ufkayolculuk.com/kayit" target="_blank" class="fw-bold text-dark text-decoration-underline">
            Hemen Ücretsiz Kayıt Ol
          </a>
        </div>
        <div class="small text-muted">
          Sorun mu yaşıyorsunuz? <a href="<?= base_url('sayfa/sss') ?>" class="text-primary text-decoration-underline">Destek Al</a>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById('loginForm') || document.getElementById('portalLoginForm');
  const phoneInput = document.getElementById('loginPhone');
  const birthDateInput = document.getElementById('loginBirthDate');
  const alertBox = document.getElementById('loginAlertBox');
  const submitBtn = document.getElementById('btnLoginSubmit');
  const loginModalEl = document.getElementById('loginModal');

  // Telefon Numarası Formatlayıcı (0 (5XX) XXX XX XX)
  if (phoneInput) {
    phoneInput.addEventListener('input', function () {
      let val = this.value.replace(/\D/g, '');
      if (val.startsWith('90')) val = val.substring(2);
      if (val.startsWith('0')) val = val.substring(1);
      val = val.substring(0, 10);

      let formatted = '';
      if (val.length > 0) {
        formatted = '0 (' + val.substring(0, 3);
        if (val.length >= 4) formatted += ') ' + val.substring(3, 6);
        if (val.length >= 7) formatted += ' ' + val.substring(6, 8);
        if (val.length >= 9) formatted += ' ' + val.substring(8, 10);
      }
      this.value = formatted;
    });
  }

  // URL'de auth_required parametresi varsa otomatik login modalını aç
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('auth_required') || urlParams.has('login')) {
    if (loginModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      const modalInstance = bootstrap.Modal.getInstance(loginModalEl) || new bootstrap.Modal(loginModalEl);
      modalInstance.show();
      showAlert('Lütfen devam etmek veya korumalı sayfayı görüntülemek için giriş yapınız.', 'warning');
    }
  }

  function showAlert(msg, type = 'danger') {
    if (!alertBox) return;
    const isSuccess = type === 'success';
    const icon = isSuccess ? '✓' : (type === 'warning' ? 'ℹ' : '⚠');
    alertBox.className = `alert alert-${type} d-flex align-items-center gap-2 py-2 px-3 small mb-3 rounded-3`;
    alertBox.innerHTML = `<span>${icon}</span> <div>${msg}</div>`;
    alertBox.classList.remove('d-none');
  }

  if (loginForm) {
    loginForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      if (alertBox) {
        alertBox.className = 'mb-3 d-none';
        alertBox.innerHTML = '';
      }

      const rawPhone = phoneInput ? phoneInput.value.trim() : '';
      const birthdate = birthDateInput ? birthDateInput.value.trim() : '';
      const phoneDigits = rawPhone.replace(/\D/g, '');

      if (!phoneDigits || !birthdate) {
        showAlert('Lütfen telefon numaranızı ve doğum tarihinizi eksiksiz doldurunuz.', 'danger');
        return;
      }

      const origBtnHtml = submitBtn ? submitBtn.innerHTML : 'Giriş Yap →';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Kontrol Ediliyor...</span> <span class="spinner-border spinner-border-sm ms-1" role="status"></span>';
      }

      try {
        const formData = new FormData(loginForm);
        // Telefon numarasını hem düz hem formatlı yolla
        formData.set('phone', phoneDigits);

        const baseUrl = window.BASE_URL || '<?= rtrim(base_url(), '/') . '/' ?>';
        const targetUrl = loginForm.action || `${baseUrl}auth/login`;

        const response = await fetch(targetUrl, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          },
          body: formData
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
          let errorHtml = data.message || 'Giriş bilgileri doğrulanamadı.';
          if (data.errors) {
            errorHtml += '<ul class="mb-0 mt-1 ps-3">';
            for (const key in data.errors) {
              errorHtml += `<li>${data.errors[key]}</li>`;
            }
            errorHtml += '</ul>';
          }
          showAlert(errorHtml, 'danger');
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = origBtnHtml;
          }
        }
      } catch (err) {
        showAlert('Sunucu ile iletişim kurulurken bir hata oluştu. Lütfen tekrar deneyiniz.', 'danger');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origBtnHtml;
        }
      }
    });
  }
});
</script>
