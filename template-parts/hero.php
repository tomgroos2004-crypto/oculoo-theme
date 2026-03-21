<?php
if (!defined('ABSPATH')) exit;

$enabled = get_field('hero_enabled');
if (!$enabled) return;

$variant          = get_field('hero_variant') ?: 'auto';
$eyebrow          = get_field('hero_eyebrow');
$title_prefix     = get_field('hero_title_prefix');
$title_highlight  = get_field('hero_title_highlight');
$title_suffix     = get_field('hero_title_suffix');
$intro            = get_field('hero_intro');
$usps             = get_field('hero_usps');
$primary_button   = get_field('hero_primary_button');
$secondary_button = get_field('hero_secondary_button');
$image            = get_field('hero_image');

$legacy_h1   = get_field('hero_h1');
$legacy_text = get_field('hero_text');

if (empty($title_prefix) && empty($title_highlight) && empty($title_suffix) && !empty($legacy_h1)) {
  $title_prefix = $legacy_h1;
}

if (empty($intro) && !empty($legacy_text)) {
  $intro = $legacy_text;
}

if ($variant === 'auto') {
  $variant = is_front_page() ? 'split' : 'statement';
}

if ($variant !== 'split' && $variant !== 'statement') {
  $variant = is_front_page() ? 'split' : 'statement';
}

if ($variant === 'statement') {
  if (!$eyebrow) {
    $eyebrow = is_page('over-oculoo') || is_page('over-ons') ? 'Over Oculoo' : get_the_title();
  }

  if (!$title_prefix && !$title_highlight && !$title_suffix) {
    $title_prefix = 'Zelfstandigheid begint bij';
    $title_highlight = 'de kleine dingen';
  }

  if (!$intro) {
    $intro = 'Wij geloven dat elke patient recht heeft op een hulpmiddel dat het volledig oplost. Niet half, niet bijna - volledig.';
  }

  if (empty($usps) || !is_array($usps)) {
    $usps = [
      ['label' => 'Opgericht 2024'],
      ['label' => 'Medisch hulpmiddel'],
      ['label' => 'Made in Nederland'],
    ];
  }
}

$image_url = is_array($image) ? $image['url'] : $image;
$image_alt = is_array($image) ? ($image['alt'] ?? '') : '';
?>

<section class="oculoo-hero oculoo-hero--<?= esc_attr($variant); ?> section-sm">
  <div class="ls-container">
    <div class="oculoo-hero__grid">
      <div class="oculoo-hero__content">
        <?php if ($eyebrow) : ?>
          <p class="oculoo-hero__eyebrow"><?= esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($title_prefix || $title_highlight || $title_suffix) : ?>
          <h1 class="oculoo-hero__title">
            <?php if ($title_prefix) : ?>
              <span class="oculoo-hero__title-part"><?= esc_html($title_prefix); ?></span>
            <?php endif; ?>
            <?php if ($title_highlight) : ?>
              <span class="oculoo-hero__title-highlight"><?= esc_html($title_highlight); ?></span>
            <?php endif; ?>
            <?php if ($title_suffix) : ?>
              <span class="oculoo-hero__title-part"><?= esc_html($title_suffix); ?></span>
            <?php endif; ?>
          </h1>
        <?php endif; ?>

        <?php if ($intro) : ?>
          <p class="oculoo-hero__intro"><?= esc_html($intro); ?></p>
        <?php endif; ?>

        <?php if (!empty($usps) && is_array($usps)) : ?>
          <ul class="oculoo-hero__usp-list" aria-label="USP's">
            <?php foreach (array_slice($usps, 0, 4) as $usp) :
              $label = $usp['label'] ?? '';
              if (!$label) continue;
            ?>
              <li class="oculoo-hero__usp-item"><?= esc_html($label); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php if ($variant === 'split' && (!empty($primary_button['url']) || !empty($secondary_button['url']))) : ?>
          <div class="oculoo-hero__actions">
            <?php if (!empty($primary_button['url'])) : ?>
              <a
                class="oculoo-hero__button oculoo-hero__button--primary"
                href="<?= esc_url($primary_button['url']); ?>"
                target="<?= esc_attr($primary_button['target'] ?: '_self'); ?>"
              >
                <?= esc_html($primary_button['title'] ?: 'Lees meer'); ?>
              </a>
            <?php endif; ?>

            <?php if (!empty($secondary_button['url'])) : ?>
              <a
                class="oculoo-hero__button oculoo-hero__button--secondary"
                href="<?= esc_url($secondary_button['url']); ?>"
                target="<?= esc_attr($secondary_button['target'] ?: '_self'); ?>"
              >
                <?= esc_html($secondary_button['title'] ?: 'Neem contact op'); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($variant === 'split' && $image_url) : ?>
        <div class="oculoo-hero__media">
          <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($image_alt); ?>">
        </div>
      <?php endif; ?>
    </div>
  </div>

</section>
