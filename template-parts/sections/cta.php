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
$cta_enabled_meta = get_post_meta(get_the_ID(), 'cta_enabled', true);
if ((string) $cta_enabled_meta === '0') return;

$eyebrow  = get_field('cta_eyebrow');
$title    = get_field('cta_title') ?: 'Vraag uw apotheek naar Oculoo';
$text     = get_field('cta_text') ?: 'Verkrijgbaar bij 230+ apotheken in Nederland. Of bestel direct online — gratis verzending, 30 dagen retourrecht.';

$btn1_text = get_field('cta_btn1_text') ?: 'Nu bestellen — €18,95';
$btn1_url  = get_field('cta_btn1_url') ?: home_url('/winkel/');
$btn2_text = get_field('cta_btn2_text') ?: 'Zakelijk inkopen';
$btn2_url  = get_field('cta_btn2_url') ?: home_url('/#zakelijk');

$variant = get_field('cta_variant') ?: 'dark';

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
