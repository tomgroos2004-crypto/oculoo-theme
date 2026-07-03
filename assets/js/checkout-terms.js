/**
 * Oculoo — Verplichte AV/Privacybeleid checkbox
 * WooCommerce Block Checkout integratie
 *
 * Gebruikt wp.plugins.registerPlugin met ExperimentalOrderMeta SlotFill
 * om de checkbox in de order-summary te renderen. Server-side validatie
 * gebeurt via setExtensionData → Store API.
 */
(function () {
  'use strict';

  if (typeof window === 'undefined') return;

  function boot() {
    var wc = window.wc || {};
    var wpEl = window.wp && window.wp.element;
    var wpData = window.wp && window.wp.data;
    var wpPlugins = window.wp && window.wp.plugins;

    if (!wpEl || !wpData || !wpPlugins) {
      console.warn('[oculoo-terms] wp.element/data/plugins ontbreekt');
      return;
    }
    if (!wc.blocksCheckout || !wc.blocksCheckout.ExperimentalOrderMeta) {
      console.warn('[oculoo-terms] wc.blocksCheckout.ExperimentalOrderMeta ontbreekt');
      return;
    }

    var createElement = wpEl.createElement;
    var useState = wpEl.useState;
    var useEffect = wpEl.useEffect;
    var ExperimentalOrderMeta = wc.blocksCheckout.ExperimentalOrderMeta;
    var CheckboxControl =
      (wc.blocksComponents && wc.blocksComponents.CheckboxControl) ||
      (window.wp.components && window.wp.components.CheckboxControl);

    if (!CheckboxControl) {
      console.warn('[oculoo-terms] CheckboxControl ontbreekt');
      return;
    }

    var VALIDATION_STORE_KEY = 'wc/store/validation';
    var VALIDATION_ERROR_KEY = 'oculoo-terms-required';
    var TERMS_ENDPOINT = (window.OculooTermsConfig && window.OculooTermsConfig.endpoint) || '/wp-json/oculoo/v1/terms-accepted';
    var TERMS_NONCE    = (window.OculooTermsConfig && window.OculooTermsConfig.nonce) || '';

    /* Helper: post acceptatie naar onze eigen REST endpoint (gaat naar WC session) */
    function syncAcceptance(accepted) {
      try {
        fetch(TERMS_ENDPOINT, {
          method: 'POST',
          credentials: 'same-origin',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': TERMS_NONCE
          },
          body: JSON.stringify({ accepted: !!accepted })
        });
      } catch (e) {
        console.warn('[oculoo-terms] sync failed', e);
      }
    }

    var config = window.OculooTermsConfig || {};
    var labelHtml =
      config.label || 'Ik ga akkoord met de Algemene voorwaarden en het Privacybeleid.';
    var errorMessage = config.errorMessage || 'Je moet akkoord gaan om verder te gaan.';

    function OculooTermsCheckbox() {
      var s = useState(false);
      var checked = s[0];
      var setChecked = s[1];

      useEffect(function () {
        var validationDispatch = wpData.dispatch(VALIDATION_STORE_KEY);

        /* Sync acceptatie naar WC session via eigen REST endpoint */
        syncAcceptance(checked);

        /* Validation error sync */
        if (validationDispatch) {
          if (!checked) {
            validationDispatch.setValidationErrors({
              [VALIDATION_ERROR_KEY]: {
                message: errorMessage,
                hidden: true
              }
            });
          } else {
            validationDispatch.clearValidationError(VALIDATION_ERROR_KEY);
          }
        }
      }, [checked]);

      /* Cleanup on unmount */
      useEffect(function () {
        return function () {
          var v = wpData.dispatch(VALIDATION_STORE_KEY);
          if (v) v.clearValidationError(VALIDATION_ERROR_KEY);
        };
      }, []);

      var labelEl = createElement('span', {
        className: 'oculoo-terms__label',
        dangerouslySetInnerHTML: {
          __html: labelHtml + '<span class="oculoo-terms__required" aria-hidden="true">&nbsp;*</span>'
        }
      });

      return createElement(
        'div',
        { className: 'oculoo-terms', 'data-checked': checked ? 'true' : 'false' },
        createElement(CheckboxControl, {
          id: 'oculoo-terms-accepted',
          className: 'oculoo-terms__checkbox',
          checked: checked,
          onChange: function (value) {
            setChecked(!!value);
          },
          label: labelEl
        })
      );
    }

    function PluginRender() {
      return createElement(
        ExperimentalOrderMeta,
        null,
        createElement(OculooTermsCheckbox, null)
      );
    }

    wpPlugins.registerPlugin('oculoo-checkout-terms', {
      render: PluginRender,
      scope: 'woocommerce-checkout'
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
