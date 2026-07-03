<?php if (!defined('ABSPATH')) exit; ?>

<?php
/* =========================================================
   HOME HEADER — Oculoo "Easy as that" hero variant
   Logo left, nav links + cart + "Bestel nu" CTA right.
   Fully transparent over the purple hero. Becomes a floating
   white glass pill with branded colors once the user scrolls.
   Logo is pulled from theme settings (ACF option).
========================================================= */

$home_url     = home_url('/');
$shop_url     = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/winkel/');
$over_page    = get_page_by_path('over-oculoo') ?: get_page_by_path('over-ons');
$over_url     = $over_page ? get_permalink($over_page->ID) : home_url('/over-ons/');
$how_url      = home_url('/hoe-werkt-het');
$business_url = home_url('/mijn-account/');
$private_label_url = home_url('/private-label/');
$cart_url     = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/winkelwagen/');
$cart_count   = 0;
if (function_exists('WC') && WC()->cart) {
  $cart_count = (int) WC()->cart->get_cart_contents_count();
}

$logo_url          = get_field('oculoo_logo', 'option');
$logo_scrolled_url = get_field('oculoo_logo_scrolled', 'option');
$logo_alt          = get_field('oculoo_logo_alt', 'option') ?: 'Oculoo';
if (!$logo_url) {
  $logo_url = get_stylesheet_directory_uri() . '/assets/img/oculoo-logo.png';
}
$has_scrolled_logo = !empty($logo_scrolled_url);
?>

<div class="ls-header-wrap ls-header-wrap--home">
  <header class="ls-header ls-header--home" aria-label="Hoofdnavigatie">
    <div class="ls-container">
      <div class="ls-header-inner ls-header-inner--home">

        <a class="ls-header-brand<?= $has_scrolled_logo ? ' ls-header-brand--dual' : ''; ?>" href="<?= esc_url($home_url); ?>" aria-label="Oculoo home">
          <img class="ls-header-brand__logo ls-header-brand__logo--default" src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($logo_alt); ?>" loading="eager" decoding="async">
          <?php if ($has_scrolled_logo) : ?>
            <img class="ls-header-brand__logo ls-header-brand__logo--scrolled" src="<?= esc_url($logo_scrolled_url); ?>" alt="<?= esc_attr($logo_alt); ?>" loading="eager" decoding="async" aria-hidden="true">
          <?php endif; ?>
        </a>

        <nav class="ls-header-nav ls-header-nav--home" aria-label="Hoofdmenu">
          <a class="link" href="<?= esc_url($shop_url); ?>">Producten</a>
          <a class="link" href="<?= esc_url($how_url); ?>">Hoe het werkt</a>
          <a class="link" href="<?= esc_url($over_url); ?>">Over Oculoo</a>
          <div class="ls-header-dropdown" data-dropdown>
            <a
              class="link ls-header-dropdown__trigger"
              href="<?= esc_url($business_url); ?>"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Zakelijk
              <svg class="ls-header-dropdown__caret" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                <path d="M2.5 4.5L6 8l3.5-3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <div class="ls-header-dropdown__menu" role="menu">
              <a role="menuitem" href="<?= esc_url($business_url); ?>">Zakelijk</a>
              <a role="menuitem" class="<?= (is_page('private-label') ? 'is-active' : ''); ?>" href="<?= esc_url($private_label_url); ?>">Private label</a>
            </div>
          </div>
        </nav>

        <div class="ls-header-actions ls-header-actions--home">
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

          <button
            class="ls-header-toggle ls-header-toggle--home"
            type="button"
            aria-label="Open navigatie"
            aria-expanded="false"
            data-header-toggle
          >
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>

      </div>
    </div>

    <div class="ls-header-mobile ls-header-mobile--home" data-header-panel>
      <div class="ls-container">
        <nav class="ls-header-mobile-nav" aria-label="Mobiel hoofdmenu">
          <a href="<?= esc_url($shop_url); ?>">Producten</a>
          <a href="<?= esc_url($how_url); ?>">Hoe het werkt</a>
          <a href="<?= esc_url($over_url); ?>">Over Oculoo</a>
          <a href="<?= esc_url($business_url); ?>">Zakelijk</a>
          <a class="<?= (is_page('private-label') ? 'is-active' : ''); ?>" href="<?= esc_url($private_label_url); ?>">Private label</a>
          <a class="ls-header-mobile-cta" href="<?= esc_url($shop_url); ?>">Bestel nu</a>
        </nav>
      </div>
    </div>
  </header>
</div>
