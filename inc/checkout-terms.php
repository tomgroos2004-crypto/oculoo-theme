<?php
/**
 * Oculoo — Verplichte AV/Privacybeleid checkbox op WooCommerce Block Checkout
 *
 * - JS rendert checkbox in order summary (ExperimentalOrderMeta SlotFill)
 * - Op toggle POST naar custom REST endpoint → schrijft acceptatie naar WC session
 * - Server-side validatie bij order placement leest uit WC session
 * - Slaat acceptatie + datum op als order meta + toont in admin
 *
 * @package Oculoo
 */

if (!defined('ABSPATH')) exit;

/* =========================================================
   ENQUEUE — JS + CSS, alleen op checkout
========================================================= */
if (!function_exists('oculoo_checkout_terms_enqueue')) {
  function oculoo_checkout_terms_enqueue() {
    if (!function_exists('is_checkout') || !is_checkout()) return;

    $dir = get_stylesheet_directory();
    $uri = get_stylesheet_directory_uri();

    /* JS — block checkout integratie */
    $js_path = $dir . '/assets/js/checkout-terms.js';
    if (file_exists($js_path)) {
      wp_enqueue_script(
        'oculoo-checkout-terms',
        $uri . '/assets/js/checkout-terms.js',
        ['wc-blocks-checkout', 'wp-element', 'wp-data', 'wp-i18n', 'wp-plugins'],
        filemtime($js_path),
        true
      );

      /* Label uit ACF Options, fallback NL */
      $label_html = '';
      if (function_exists('get_field')) {
        $label_html = (string) get_field('checkout_terms_label', 'oculoo-checkout-settings');
      }
      if ($label_html === '') {
        $label_html = sprintf(
          /* translators: %1$s = link AV, %2$s = link Privacy */
          __('Ik ga akkoord met de %1$s en het %2$s.', 'oculoo'),
          '<a href="' . esc_url(home_url('/algemene-verkoop-en-leveringsvoorwaarden-oculoo-b-v/')) . '" target="_blank" rel="noopener">' .
          esc_html__('Algemene voorwaarden', 'oculoo') .
          '</a>',
          '<a href="' . esc_url(home_url('/privacybeleid')) . '" target="_blank" rel="noopener">' .
          esc_html__('Privacybeleid', 'oculoo') .
          '</a>'
        );
      }

      wp_localize_script('oculoo-checkout-terms', 'OculooTermsConfig', [
        'label'        => wp_kses_post($label_html),
        'errorMessage' => esc_html__('Je moet akkoord gaan met de Algemene voorwaarden en het Privacybeleid om verder te gaan.', 'oculoo'),
        'endpoint'     => esc_url_raw(rest_url('oculoo/v1/terms-accepted')),
        'nonce'        => wp_create_nonce('wp_rest'),
      ]);
    }

    /* CSS is al via main.css geladen — geen aparte enqueue nodig */
  }
  add_action('wp_enqueue_scripts', 'oculoo_checkout_terms_enqueue', 20);
}


/* =========================================================
   CUSTOM REST ENDPOINT — schrijft acceptatie naar WC session
========================================================= */
if (!function_exists('oculoo_checkout_terms_register_rest')) {
  function oculoo_checkout_terms_register_rest() {
    register_rest_route('oculoo/v1', '/terms-accepted', [
      'methods'             => 'POST',
      'permission_callback' => '__return_true',
      'callback'            => function (WP_REST_Request $request) {
        $accepted = (bool) $request->get_param('accepted');

        if (function_exists('WC')) {
          if (!WC()->session) {
            WC()->initialize_session();
          }
          if (WC()->session) {
            if (!WC()->session->has_session()) {
              WC()->session->set_customer_session_cookie(true);
            }
            WC()->session->set('oculoo_terms_accepted', $accepted ? 'yes' : 'no');
            if (method_exists(WC()->session, 'save_data')) {
              WC()->session->save_data();
            }
          }
        }

        return ['ok' => true, 'accepted' => $accepted];
      },
    ]);
  }
  add_action('rest_api_init', 'oculoo_checkout_terms_register_rest');
}


/* =========================================================
   SERVER-SIDE VALIDATIE — leest uit WC session bij order placement
========================================================= */
if (!function_exists('oculoo_checkout_terms_validate')) {
  function oculoo_checkout_terms_validate($order, $request) {
    /* Alleen valideren bij echte order placement, niet bij tussentijdse calls */
    if (empty($request['payment_data'])) {
      return;
    }

    $accepted = false;
    if (function_exists('WC') && WC()->session) {
      $accepted = WC()->session->get('oculoo_terms_accepted') === 'yes';
    }

    if (!$accepted) {
      throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException(
        'oculoo_terms_required',
        esc_html__('Je moet akkoord gaan met de Algemene voorwaarden en het Privacybeleid om de bestelling te plaatsen.', 'oculoo'),
        400
      );
    }

    /* Sla acceptatie + datum op als order meta + ruim session op */
    $order->update_meta_data('_terms_accepted', 'yes');
    $order->update_meta_data('_terms_accepted_date', current_time('mysql'));
    if (function_exists('WC') && WC()->session) {
      WC()->session->set('oculoo_terms_accepted', null);
    }
  }
  add_action('woocommerce_store_api_checkout_update_order_from_request', 'oculoo_checkout_terms_validate', 10, 2);
}


/* =========================================================
   ADMIN — toon acceptatie in order detail view
========================================================= */
if (!function_exists('oculoo_checkout_terms_admin_display')) {
  function oculoo_checkout_terms_admin_display($order) {
    if (!($order instanceof WC_Order)) return;

    $accepted = $order->get_meta('_terms_accepted');
    $date     = $order->get_meta('_terms_accepted_date');

    if ($accepted !== 'yes') return;

    $formatted_date = '';
    if ($date) {
      $timestamp      = strtotime($date);
      $formatted_date = $timestamp
        ? wp_date(get_option('date_format') . ' ' . get_option('time_format'), $timestamp)
        : esc_html($date);
    }

    echo '<p><strong>' . esc_html__('Algemene voorwaarden geaccepteerd', 'oculoo') . ':</strong><br>';
    echo esc_html__('Ja', 'oculoo');
    if ($formatted_date) {
      echo ' &mdash; <span style="color:#6b7683;">' . esc_html($formatted_date) . '</span>';
    }
    echo '</p>';
  }
  add_action('woocommerce_admin_order_data_after_billing_address', 'oculoo_checkout_terms_admin_display', 20);
}
