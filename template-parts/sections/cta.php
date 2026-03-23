<?php
defined('ABSPATH') || exit;

/* =============================
   ACF Fields

   cta_eyebrow    — text (optioneel, bv. "Gratis proberen")
   cta_title      — text (verplicht)
   cta_text       — textarea (optioneel)
   cta_btn1_text  — text
   cta_btn1_url   — url / link
   cta_btn2_text  — text (optioneel, tweede knop)
   cta_btn2_url   — url / link (optioneel)
   cta_variant    — select: light (default) | dark
============================= */

/* Per-page optional toggle. No value means enabled by default. */
$context_id = 0;

if (is_singular()) {
  $context_id = (int) get_the_ID();
} elseif (function_exists('is_shop') && is_shop()) {
  $context_id = (int) wc_get_page_id('shop');
} else {
  $context_id = (int) get_queried_object_id();
}

$cta_enabled_meta = $context_id > 0 ? get_post_meta($context_id, 'cta_enabled', true) : '';
if ((string) $cta_enabled_meta === '0') return;

$eyebrow  = $context_id > 0 ? get_field('cta_eyebrow', $context_id) : '';
$title    = ($context_id > 0 ? get_field('cta_title', $context_id) : '') ?: 'Vraag uw apotheek naar Oculoo';
$text     = ($context_id > 0 ? get_field('cta_text', $context_id) : '') ?: 'Verkrijgbaar bij 230+ apotheken in Nederland. Of bestel direct online.';

$btn1_text = ($context_id > 0 ? get_field('cta_btn1_text', $context_id) : '') ?: 'Nu bestellen — €18,95';
$btn1_url  = ($context_id > 0 ? get_field('cta_btn1_url', $context_id) : '') ?: home_url('/winkel/');
$btn2_text = ($context_id > 0 ? get_field('cta_btn2_text', $context_id) : '') ?: 'Zakelijk inkopen';
$btn2_url  = ($context_id > 0 ? get_field('cta_btn2_url', $context_id) : '') ?: home_url('/#zakelijk');

$variant = ($context_id > 0 ? get_field('cta_variant', $context_id) : '') ?: 'dark';

if (!$title) return;

/* Resolve link fields (ACF link field returns array, URL field returns string) */
$btn1_href = is_array($btn1_url) ? ($btn1_url['url'] ?? '#') : ($btn1_url ?: '#');
$btn2_href = is_array($btn2_url) ? ($btn2_url['url'] ?? '#') : ($btn2_url ?: '#');
?>

<section class="ls-cta ls-cta--<?= esc_attr($variant); ?> section-md" id="zakelijk">
  <div class="ls-container">

    <div class="ls-cta-card">

      <?php if ($eyebrow) : ?>
        <p class="ls-cta-eyebrow"><?= esc_html($eyebrow); ?></p>
      <?php endif; ?>

      <h2 class="ls-cta-title"><?= esc_html($title); ?></h2>

      <?php if ($text) : ?>
        <p class="ls-cta-text"><?= esc_html($text); ?></p>
      <?php endif; ?>

      <?php if ($btn1_text || $btn2_text) : ?>
        <div class="ls-cta-actions">

          <?php if ($btn1_text) : ?>
            <a href="<?= esc_url($btn1_href); ?>" class="ls-cta-btn ls-cta-btn--primary">
              <?= esc_html($btn1_text); ?>
            </a>
          <?php endif; ?>

          <?php if ($btn2_text) : ?>
            <a href="<?= esc_url($btn2_href); ?>" class="ls-cta-btn ls-cta-btn--secondary">
              <?= esc_html($btn2_text); ?>
            </a>
          <?php endif; ?>

        </div>
      <?php endif; ?>

    </div>

  </div>
</section>
