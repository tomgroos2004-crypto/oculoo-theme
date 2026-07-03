<?php
if (!defined('ABSPATH')) exit;

/* =========================================================
   HOME HERO — "Easy as that"
   Renders a full-bleed purple hero with the giant "oo" brand
   mark, review row, large headline and CTA pills.
   ACF group: group_ls_hero_home
========================================================= */

$enabled = get_field('hero_home_enabled');
if ($enabled === false) {
  $enabled = true;
}
if (!$enabled) return;

$review_text = get_field('hero_home_review_text');
if ($review_text === '' || $review_text === null) {
  $review_text = '200+ positieve reviews';
}

$headline = get_field('hero_home_headline');
if ($headline === '' || $headline === null) {
  $headline = 'Easy as that';
}

$btn_primary   = get_field('hero_home_btn_primary');
$btn_secondary = get_field('hero_home_btn_secondary');
?>

<section class="oculoo-hero-home" data-screen-label="01 Hero">

  <div class="oculoo-hero-home__rings" aria-hidden="true">
    <svg class="oculoo-hero-home__mark" id="Laag_2" data-name="Laag 2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 145.53 78.41">
      <defs>
        <style>
          .oculoo-hero-home__mark .cls-1 { fill: url(#oculoo_oo_grad_right); }
          .oculoo-hero-home__mark .cls-2 { fill: url(#oculoo_oo_grad_left); }
        </style>
        <linearGradient id="oculoo_oo_grad_left" data-name="Naamloos verloop 6" x1="41.25" y1="-208.39" x2="57.6" y2="-241.61" gradientTransform="translate(0 -166.79) scale(1 -1)" gradientUnits="userSpaceOnUse">
          <stop offset="0" stop-color="#ec6528"/>
          <stop offset="1" stop-color="#ec6528" stop-opacity=".4"/>
        </linearGradient>
        <linearGradient id="oculoo_oo_grad_right" data-name="Naamloos verloop 6" x1="101.23" y1="-197.5" x2="89.39" y2="-171.74" xlink:href="#oculoo_oo_grad_left"/>
      </defs>
      <g id="Laag_1-2" data-name="Laag 1">
        <g>
          <path class="cls-2" d="M0,39.27c0-5.9.97-11.25,2.9-16.04,1.93-4.79,4.64-8.9,8.14-12.31,3.49-3.5,7.73-6.18,12.69-8.02,4.97-1.94,10.44-2.9,16.42-2.9s11.4.97,16.28,2.9c4.88,1.84,9.06,4.52,12.55,8.02,3.59,3.41,6.35,7.51,8.28,12.31,2.02,4.79,3.04,10.14,3.04,16.04s-1.01,11.02-3.04,15.9c-1.93,4.79-4.69,8.9-8.28,12.31-3.49,3.41-7.68,6.08-12.55,8.02-4.88,1.94-10.3,2.9-16.28,2.9s-11.45-.97-16.42-2.9c-4.97-1.94-9.2-4.61-12.69-8.02-3.49-3.41-6.21-7.51-8.14-12.31-1.93-4.89-2.9-10.19-2.9-15.9ZM15.45,39.27c0,3.69.6,7.1,1.79,10.23,1.2,3.13,2.85,5.81,4.97,8.02,2.21,2.21,4.78,3.96,7.73,5.26,3.04,1.2,6.44,1.8,10.21,1.8s6.9-.6,9.93-1.8c3.04-1.29,5.61-3.04,7.73-5.26,2.21-2.21,3.91-4.89,5.1-8.02,1.2-3.13,1.79-6.55,1.79-10.23s-.6-7.24-1.79-10.37c-1.2-3.23-2.9-5.95-5.1-8.16-2.12-2.21-4.69-3.92-7.73-5.12s-6.35-1.8-9.93-1.8c-3.77,0-7.17.6-10.21,1.8-2.94,1.2-5.52,2.9-7.73,5.12-2.12,2.21-3.77,4.93-4.97,8.16-1.2,3.13-1.79,6.59-1.79,10.37Z"/>
          <path class="cls-1" d="M145.53,39.14c0,5.9-.97,11.25-2.92,16.04-1.95,4.79-4.68,8.9-8.2,12.31-3.52,3.5-7.79,6.18-12.79,8.02-5.01,1.94-10.52,2.9-16.55,2.9s-11.49-.97-16.41-2.9c-4.91-1.84-9.13-4.52-12.65-8.02-3.61-3.41-6.4-7.51-8.34-12.31-2.04-4.79-3.06-10.14-3.06-16.04s1.02-11.02,3.06-15.9c1.95-4.79,4.73-8.9,8.34-12.31,3.52-3.41,7.74-6.08,12.65-8.02C93.58.97,99.04,0,105.07,0s11.54.97,16.55,2.9c5.01,1.94,9.27,4.61,12.79,8.02,3.52,3.41,6.26,7.51,8.2,12.31,1.95,4.89,2.92,10.19,2.92,15.9ZM129.96,39.14c0-3.69-.6-7.1-1.81-10.23-1.21-3.13-2.87-5.81-5.01-8.02-2.23-2.21-4.82-3.96-7.79-5.25-3.06-1.2-6.49-1.8-10.29-1.8s-6.95.6-10.01,1.8c-3.06,1.29-5.65,3.04-7.79,5.25-2.22,2.21-3.94,4.89-5.14,8.02-1.21,3.13-1.81,6.55-1.81,10.23s.6,7.24,1.81,10.37c1.2,3.23,2.92,5.95,5.14,8.16,2.13,2.21,4.73,3.92,7.79,5.12,3.06,1.2,6.4,1.8,10.01,1.8,3.8,0,7.23-.6,10.29-1.8,2.97-1.2,5.56-2.9,7.79-5.12,2.13-2.21,3.8-4.93,5.01-8.16,1.2-3.13,1.81-6.59,1.81-10.37Z"/>
        </g>
      </g>
    </svg>
  </div>

  <div class="oculoo-hero-home__content">

    <?php if ($review_text) : ?>
      <div class="oculoo-hero-home__reviews">
        <span class="oculoo-hero-home__stars" aria-hidden="true">
          <?php for ($i = 0; $i < 5; $i++) : ?>
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 .8l3.1 7.2 7.7.7-5.8 5.1 1.7 7.5L12 17.5 5.3 21.3 7 13.8 1.2 8.7l7.7-.7L12 .8z"/></svg>
          <?php endfor; ?>
        </span>
        <span class="oculoo-hero-home__review-text"><?= esc_html($review_text); ?></span>
      </div>
    <?php endif; ?>

    <h1 class="oculoo-hero-home__headline"><?= esc_html($headline); ?></h1>

    <?php if (!empty($btn_primary['url']) || !empty($btn_secondary['url'])) : ?>
      <div class="oculoo-hero-home__actions">

        <?php if (!empty($btn_primary['url'])) : ?>
          <a
            class="oculoo-hero-home__btn oculoo-hero-home__btn--primary"
            href="<?= esc_url($btn_primary['url']); ?>"
            target="<?= esc_attr($btn_primary['target'] ?: '_self'); ?>"
          >
            <?= esc_html($btn_primary['title'] ?: 'Bestel online'); ?>
          </a>
        <?php endif; ?>

        <?php if (!empty($btn_secondary['url'])) : ?>
          <a
            class="oculoo-hero-home__btn oculoo-hero-home__btn--ghost"
            href="<?= esc_url($btn_secondary['url']); ?>"
            target="<?= esc_attr($btn_secondary['target'] ?: '_self'); ?>"
          >
            <?= esc_html($btn_secondary['title'] ?: 'Vind jouw apotheker'); ?>
          </a>
        <?php endif; ?>

      </div>
    <?php endif; ?>

  </div>

  <img
    class="oculoo-hero-home__model"
    src="<?= esc_url(get_stylesheet_directory_uri() . '/assets/img/hero-model.png'); ?>"
    alt=""
    aria-hidden="true"
    loading="eager"
    fetchpriority="high"
    width="1077"
    height="896"
  />

</section>
