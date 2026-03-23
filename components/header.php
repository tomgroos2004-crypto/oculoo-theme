<?php if (!defined('ABSPATH')) exit; ?>

<?php
$shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/winkel/');
$home_url = home_url('/');
$over_page = get_page_by_path('over-oculoo') ?: get_page_by_path('over-ons');
$over_url  = $over_page ? get_permalink($over_page->ID) : home_url('/over-ons/');
$how_url = home_url('/hoe-werkt-het');
$business_url = home_url('/mijn-account/');
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/winkelwagen/');
$cart_count = 0;

if (function_exists('WC') && WC()->cart) {
  $cart_count = (int) WC()->cart->get_cart_contents_count();
}
?>

<div class="ls-header-wrap">
  <div class="ls-announce" role="note" aria-label="Belangrijke melding">
    <div class="ls-container">
      <div class="ls-announce-inner">
        <span>Vraag uw apotheek naar de <strong>Oculoo oogdruppelbril</strong></span>
        <span class="ls-announce-sep">&middot;</span>
        <span>Bestel direct online.</span>
        <span class="ls-announce-sep">&middot;</span>
        <a href="<?= esc_url(home_url('/mijn-account/')); ?>">Zakelijke interesse →</a>
      </div>
    </div>
  </div>

  <header class="ls-header">
    <div class="ls-container">
      <div class="ls-header-inner">

        <a class="ls-header-brand" href="<?= esc_url($home_url); ?>" aria-label="Oculoo home">
          <img src="https://oculoo.com/wp-content/uploads/2026/03/oculoo-logo-new-e1774100196125.png" alt="Oculoo" loading="eager" decoding="async">
        </a>

        <nav class="ls-header-nav" aria-label="Hoofdmenu">
          <a class="<?= (is_shop() || is_product_category() || is_product() ? 'is-active' : ''); ?>" href="<?= esc_url($shop_url); ?>">Producten</a>
          <a href="<?= esc_url($how_url); ?>">Hoe het werkt</a>
          <a class="<?= (is_page('over-oculoo') || is_page('over-ons') ? 'is-active' : ''); ?>" href="<?= esc_url($over_url); ?>">Over Oculoo</a>
          <a href="<?= esc_url($business_url); ?>">Zakelijk</a>
        </nav>

        <div class="ls-header-actions">
          <button
            class="ls-header-toggle"
            type="button"
            aria-label="Open navigatie"
            aria-expanded="false"
            data-header-toggle
          >
            <span></span>
            <span></span>
            <span></span>
          </button>
          <button class="ls-header-lang" type="button" aria-label="Selecteer taal">NL</button>
          <a class="ls-header-cart" href="<?= esc_url($cart_url); ?>" aria-label="Winkelwagen">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <circle cx="9" cy="20" r="1.5"></circle>
              <circle cx="18" cy="20" r="1.5"></circle>
              <path d="M3 4h2l2.3 10.4a1 1 0 0 0 1 .8h9.6a1 1 0 0 0 1-.8L21 7H7"></path>
            </svg>
            <?php if ($cart_count > 0) : ?>
              <span class="ls-header-cart__count"><?= esc_html((string) $cart_count); ?></span>
            <?php endif; ?>
          </a>
          <a class="ls-header-cta" href="<?= esc_url($shop_url); ?>">Bestel nu</a>
        </div>

      </div>
    </div>

    <div class="ls-header-mobile" data-header-panel>
      <div class="ls-container">
        <nav class="ls-header-mobile-nav" aria-label="Mobiel hoofdmenu">
          <a class="<?= (is_shop() || is_product_category() || is_product() ? 'is-active' : ''); ?>" href="<?= esc_url($shop_url); ?>">Producten</a>
          <a href="<?= esc_url($how_url); ?>">Hoe het werkt</a>
          <a class="<?= (is_page('over-oculoo') || is_page('over-ons') ? 'is-active' : ''); ?>" href="<?= esc_url($over_url); ?>">Over Oculoo</a>
          <a href="<?= esc_url($business_url); ?>">Zakelijk</a>
          <a class="ls-header-mobile-cta" href="<?= esc_url($shop_url); ?>">Bestel nu</a>
        </nav>
      </div>
    </div>
  </header>
</div>
