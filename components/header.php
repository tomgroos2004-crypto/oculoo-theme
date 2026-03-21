<?php if (!defined('ABSPATH')) exit; ?>

<?php
$shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/winkel/');
$home_url = home_url('/');
$over_page = get_page_by_path('over-oculoo') ?: get_page_by_path('over-ons');
$over_url  = $over_page ? get_permalink($over_page->ID) : home_url('/over-ons/');
$how_url = home_url('/hoe-werkt-het');
$business_url = home_url('/#zakelijk');
?>

<div class="ls-header-wrap">
  <div class="ls-announce" role="note" aria-label="Belangrijke melding">
    <div class="ls-container">
      <div class="ls-announce-inner">
        <span>Vraag uw apotheek naar de <strong>Oculoo oogdruppelbril</strong></span>
        <span class="ls-announce-sep">&middot;</span>
        <span>Gratis verzending vanaf €25</span>
        <span class="ls-announce-sep">&middot;</span>
        <a href="<?= esc_url(home_url('/#zakelijk')); ?>">Zakelijke interesse →</a>
      </div>
    </div>
  </div>

  <header class="ls-header">
    <div class="ls-container">
      <div class="ls-header-inner">

        <a class="ls-header-brand" href="<?= esc_url($home_url); ?>" aria-label="Oculoo home">
          <img src="https://oculoo.com/wp-content/uploads/2026/03/LOGO-13-okt-1.png" alt="Oculoo" loading="eager" decoding="async">
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
