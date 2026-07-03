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
$text     = ($context_id > 0 ? get_field('cta_text', $context_id) : '') ?: 'Verkrijgbaar bij 500+ apotheken in Nederland. Of bestel direct online.';

$btn1_text = ($context_id > 0 ? get_field('cta_btn1_text', $context_id) : '') ?: 'Nu bestellen';
$btn1_url  = ($context_id > 0 ? get_field('cta_btn1_url', $context_id) : '') ?: home_url('/winkel/');
$btn2_text = ($context_id > 0 ? get_field('cta_btn2_text', $context_id) : '') ?: 'Zakelijk inkopen';
$btn2_url  = ($context_id > 0 ? get_field('cta_btn2_url', $context_id) : '') ?: home_url('/mijn-account');

$variant = ($context_id > 0 ? get_field('cta_variant', $context_id) : '') ?: 'dark';

if (!$title) return;

/* Resolve link fields (ACF link field returns array, URL field returns string) */
$btn1_href = is_array($btn1_url) ? ($btn1_url['url'] ?? '#') : ($btn1_url ?: '#');
$btn2_href = is_array($btn2_url) ? ($btn2_url['url'] ?? '#') : ($btn2_url ?: '#');
?>

<section class="ls-cta ls-cta--<?= esc_attr($variant); ?> section-md" id="zakelijk">
  <div class="ls-container">

    <div class="ls-cta-card">

      <div class="ls-cta-mark" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 145.53 78.41">
          <defs>
            <linearGradient id="ls_cta_oo_grad_left" x1="41.25" y1="-208.39" x2="57.6" y2="-241.61" gradientTransform="translate(0 -166.79) scale(1 -1)" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#ec6528"/>
              <stop offset="1" stop-color="#ec6528" stop-opacity=".4"/>
            </linearGradient>
            <linearGradient id="ls_cta_oo_grad_right" x1="101.23" y1="-197.5" x2="89.39" y2="-171.74" xlink:href="#ls_cta_oo_grad_left"/>
          </defs>
          <g>
            <path fill="url(#ls_cta_oo_grad_left)" d="M0,39.27c0-5.9.97-11.25,2.9-16.04,1.93-4.79,4.64-8.9,8.14-12.31,3.49-3.5,7.73-6.18,12.69-8.02,4.97-1.94,10.44-2.9,16.42-2.9s11.4.97,16.28,2.9c4.88,1.84,9.06,4.52,12.55,8.02,3.59,3.41,6.35,7.51,8.28,12.31,2.02,4.79,3.04,10.14,3.04,16.04s-1.01,11.02-3.04,15.9c-1.93,4.79-4.69,8.9-8.28,12.31-3.49,3.41-7.68,6.08-12.55,8.02-4.88,1.94-10.3,2.9-16.28,2.9s-11.45-.97-16.42-2.9c-4.97-1.94-9.2-4.61-12.69-8.02-3.49-3.41-6.21-7.51-8.14-12.31-1.93-4.89-2.9-10.19-2.9-15.9ZM15.45,39.27c0,3.69.6,7.1,1.79,10.23,1.2,3.13,2.85,5.81,4.97,8.02,2.21,2.21,4.78,3.96,7.73,5.26,3.04,1.2,6.44,1.8,10.21,1.8s6.9-.6,9.93-1.8c3.04-1.29,5.61-3.04,7.73-5.26,2.21-2.21,3.91-4.89,5.1-8.02,1.2-3.13,1.79-6.55,1.79-10.23s-.6-7.24-1.79-10.37c-1.2-3.23-2.9-5.95-5.1-8.16-2.12-2.21-4.69-3.92-7.73-5.12s-6.35-1.8-9.93-1.8c-3.77,0-7.17.6-10.21,1.8-2.94,1.2-5.52,2.9-7.73,5.12-2.12,2.21-3.77,4.93-4.97,8.16-1.2,3.13-1.79,6.59-1.79,10.37Z"/>
            <path fill="url(#ls_cta_oo_grad_right)" d="M145.53,39.14c0,5.9-.97,11.25-2.92,16.04-1.95,4.79-4.68,8.9-8.2,12.31-3.52,3.5-7.79,6.18-12.79,8.02-5.01,1.94-10.52,2.9-16.55,2.9s-11.49-.97-16.41-2.9c-4.91-1.84-9.13-4.52-12.65-8.02-3.61-3.41-6.4-7.51-8.34-12.31-2.04-4.79-3.06-10.14-3.06-16.04s1.02-11.02,3.06-15.9c1.95-4.79,4.73-8.9,8.34-12.31,3.52-3.41,7.74-6.08,12.65-8.02C93.58.97,99.04,0,105.07,0s11.54.97,16.55,2.9c5.01,1.94,9.27,4.61,12.79,8.02,3.52,3.41,6.26,7.51,8.2,12.31,1.95,4.89,2.92,10.19,2.92,15.9ZM129.96,39.14c0-3.69-.6-7.1-1.81-10.23-1.21-3.13-2.87-5.81-5.01-8.02-2.23-2.21-4.82-3.96-7.79-5.25-3.06-1.2-6.49-1.8-10.29-1.8s-6.95.6-10.01,1.8c-3.06,1.29-5.65,3.04-7.79,5.25-2.22,2.21-3.94,4.89-5.14,8.02-1.21,3.13-1.81,6.55-1.81,10.23s.6,7.24,1.81,10.37c1.2,3.23,2.92,5.95,5.14,8.16,2.13,2.21,4.73,3.92,7.79,5.12,3.06,1.2,6.4,1.8,10.01,1.8,3.8,0,7.23-.6,10.29-1.8,2.97-1.2,5.56-2.9,7.79-5.12,2.13-2.21,3.8-4.93,5.01-8.16,1.2-3.13,1.81-6.59,1.81-10.37Z"/>
          </g>
        </svg>
      </div>

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
