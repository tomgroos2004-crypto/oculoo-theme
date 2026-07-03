(function () {
  'use strict';

  var popup = document.getElementById('oculoo-popup');
  if (!popup) return;

  var trigger   = popup.dataset.trigger   || 'delay';
  var delay     = parseInt(popup.dataset.delay, 10) || 3;
  var scroll    = parseInt(popup.dataset.scroll, 10) || 50;
  var frequency = popup.dataset.frequency || 'once';
  var storageKey = 'oculoo_popup_dismissed';

  /* ── Frequency check ── */

  function shouldShow() {
    if (frequency === 'always') return true;

    if (frequency === 'once') {
      try { return !localStorage.getItem(storageKey); } catch (e) { return true; }
    }

    if (frequency === 'session') {
      try { return !sessionStorage.getItem(storageKey); } catch (e) { return true; }
    }

    return true;
  }

  if (!shouldShow()) return;

  /* ── Show / Hide ── */

  function show() {
    popup.removeAttribute('hidden');
    document.body.classList.add('oculoo-popup-open');
    popup.querySelector('.oculoo-popup__close').focus();
  }

  function hide() {
    popup.setAttribute('hidden', '');
    document.body.classList.remove('oculoo-popup-open');

    try {
      if (frequency === 'once') localStorage.setItem(storageKey, '1');
      if (frequency === 'session') sessionStorage.setItem(storageKey, '1');
    } catch (e) { /* storage unavailable */ }
  }

  /* ── Close handlers ── */

  popup.querySelector('.oculoo-popup__overlay').addEventListener('click', hide);
  popup.querySelector('.oculoo-popup__close').addEventListener('click', hide);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !popup.hasAttribute('hidden')) {
      hide();
    }
  });

  /* ── Triggers ── */

  if (trigger === 'page_load') {
    show();

  } else if (trigger === 'delay') {
    setTimeout(show, delay * 1000);

  } else if (trigger === 'scroll') {
    var fired = false;

    function onScroll() {
      if (fired) return;

      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      var docHeight = document.documentElement.scrollHeight - window.innerHeight;

      if (docHeight > 0 && (scrollTop / docHeight) * 100 >= scroll) {
        fired = true;
        window.removeEventListener('scroll', onScroll);
        show();
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
  }
})();
