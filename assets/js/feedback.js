/* =========================================================
   FEEDBACK FORMULIER – multi-step + AJAX submit
========================================================= */
(function () {
  'use strict';

  var form = document.getElementById('feedbackForm');
  if (!form) return;

  var card        = document.getElementById('feedbackCard');
  var progress    = document.getElementById('feedbackProgress');
  var errorBanner = document.getElementById('feedbackError');
  var submitBtn   = document.getElementById('feedbackSubmit');
  var consentBox  = document.getElementById('fbConsent');

  var steps     = form.querySelectorAll('.feedback-step');
  var progSteps = progress ? progress.querySelectorAll('.feedback-progress__step') : [];
  var totalSteps = 4;
  var currentStep = 1;

  /* --------- STEP NAVIGATION --------- */
  function showStep(n) {
    steps.forEach(function (s) { s.classList.remove('is-active'); });
    var step = form.querySelector('.feedback-step[data-step="' + n + '"]');
    if (step) step.classList.add('is-active');

    updateProgress(n);

    // scroll naar bovenkant van formulier
    if (card && typeof card.scrollIntoView === 'function') {
      card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function updateProgress(n) {
    progSteps.forEach(function (s, i) {
      s.classList.remove('is-current', 'is-active');
      if (i < n - 1)        s.classList.add('is-active');
      else if (i === n - 1) s.classList.add('is-current');
    });
  }

  function nextStep() {
    if (currentStep < totalSteps) {
      currentStep++;
      showStep(currentStep);
    }
  }

  function prevStep() {
    if (currentStep > 1) {
      currentStep--;
      showStep(currentStep);
    }
  }

  form.querySelectorAll('.feedback-btn-next').forEach(function (btn) {
    btn.addEventListener('click', nextStep);
  });
  form.querySelectorAll('.feedback-btn-prev').forEach(function (btn) {
    btn.addEventListener('click', prevStep);
  });

  /* --------- CONDITIONELE VELDEN --------- */
  // Problemen-detailveld
  var problemBoxes = form.querySelectorAll('input[name="problemen[]"]');
  var problemDetail = document.getElementById('problemDetail');
  problemBoxes.forEach(function (cb) {
    cb.addEventListener('change', function () {
      var checked = form.querySelectorAll('input[name="problemen[]"]:checked');
      var hasProblem = false;
      checked.forEach(function (c) {
        if (c.value !== 'geen') hasProblem = true;
      });

      // "geen" uitsluit logica
      if (cb.value === 'geen' && cb.checked) {
        problemBoxes.forEach(function (other) {
          if (other.value !== 'geen') other.checked = false;
        });
        hasProblem = false;
      } else if (cb.value !== 'geen' && cb.checked) {
        var geen = form.querySelector('input[name="problemen[]"][value="geen"]');
        if (geen) geen.checked = false;
      }

      if (problemDetail) {
        problemDetail.classList.toggle('is-visible', hasProblem);
      }
    });
  });

  // Klacht-detailveld
  var klachtRadios = form.querySelectorAll('input[name="klacht"]');
  var klachtDetail = document.getElementById('klachtDetail');
  klachtRadios.forEach(function (rb) {
    rb.addEventListener('change', function () {
      var show = rb.checked && rb.value !== 'nee';
      if (klachtDetail) klachtDetail.classList.toggle('is-visible', show);
    });
  });

  /* --------- SUBMIT --------- */
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    submitForm();
  });

  function showError(msg) {
    if (!errorBanner) return;
    errorBanner.innerHTML = msg || 'Er ging iets mis met versturen. Probeer het zo nog eens, of mail <a href="mailto:support@oculoo.com">support@oculoo.com</a>.';
    errorBanner.classList.add('is-visible');
    if (card && typeof card.scrollIntoView === 'function') {
      card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  function clearError() {
    if (errorBanner) errorBanner.classList.remove('is-visible');
  }

  function submitForm() {
    clearError();

    if (!consentBox || !consentBox.checked) {
      showError('Vink even de toestemming aan om door te kunnen.');
      return;
    }

    if (!submitBtn || !window.LSFeedback) {
      showError();
      return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="feedback-spinner"></span>Versturen…';

    // FormData rechtstreeks naar AJAX endpoint
    var fd = new FormData(form);
    fd.append('action', 'ls_feedback_submit');
    fd.append('nonce', window.LSFeedback.nonce);
    fd.append('consent', consentBox.checked ? '1' : '0');

    // Verzamel checkboxes (problemen[]) als comma-separated
    var problemen = [];
    form.querySelectorAll('input[name="problemen[]"]:checked').forEach(function (c) {
      problemen.push(c.value);
    });
    fd.set('problemen', problemen.join(', '));
    fd.delete('problemen[]');

    fd.append('user_agent', navigator.userAgent || '');

    fetch(window.LSFeedback.ajax_url, {
      method: 'POST',
      credentials: 'same-origin',
      body: fd
    })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        if (json && json.success) {
          if (progress) progress.style.display = 'none';
          currentStep = 5;
          showStep(5);
          setTimeout(function () {
            var check = document.getElementById('feedbackCheckmark');
            if (check) {
              check.style.transition = 'opacity 0.6s ease';
              check.style.opacity = '1';
            }
          }, 300);
        } else {
          var msg = (json && json.data && json.data.message) ? json.data.message : null;
          showError(msg);
          submitBtn.disabled = false;
          submitBtn.textContent = 'Versturen';
        }
      })
      .catch(function () {
        showError();
        submitBtn.disabled = false;
        submitBtn.textContent = 'Versturen';
      });
  }

})();
