<?php
defined('ABSPATH') || exit;

/* =============================
   ACF Fields
============================= */

$title = get_sub_field('content_titel');
$lead  = get_sub_field('content_lead');
$text  = get_sub_field('content_text');

/* =============================
   Visual type (NEW)
============================= */

$visual_type = get_sub_field('content_visual_type') ?: 'image';

/* =============================
   Single image
============================= */

$image = get_sub_field('image');
$image_url = '';
$image_alt = '';

if (!empty($image) && is_array($image)) {
  $image_url = $image['url'] ?? '';
  $image_alt = $image['alt'] ?? '';
}

/* =============================
   Collage images
============================= */

$collage_main   = get_sub_field('collage_main');
$collage_top    = get_sub_field('collage_top');
$collage_bottom = get_sub_field('collage_bottom');

$collage_main_url = '';
$collage_top_url = '';
$collage_bottom_url = '';

if (!empty($collage_main) && is_array($collage_main)) {
  $collage_main_url = $collage_main['url'] ?? '';
}

if (!empty($collage_top) && is_array($collage_top)) {
  $collage_top_url = $collage_top['url'] ?? '';
}

if (!empty($collage_bottom) && is_array($collage_bottom)) {
  $collage_bottom_url = $collage_bottom['url'] ?? '';
}

$collage_badge_title = get_sub_field('collage_badge_title');
$collage_badge_text  = get_sub_field('collage_badge_text');

$collage_breakout = get_sub_field('collage_breakout');
if ($collage_breakout === null) {
  $collage_breakout = true;
}

/* Optional: breakout value */
$collage_breakout_value = get_sub_field('collage_breakout_value') ?: 140;

/* =============================
   Section classes
============================= */



$content_classes = ['ls-content'];

$has_image = (!empty($image_url));
$has_collage = (!empty($collage_main_url) || !empty($collage_top_url) || !empty($collage_bottom_url));

if ($visual_type === 'collage' && $has_collage) {
  $content_classes[] = 'ls-content--collage';
}

if ($visual_type === 'image' && !$has_image) {
  $content_classes[] = 'ls-content--text-only';
}

if ($visual_type === 'collage' && !$has_collage) {
  $content_classes[] = 'ls-content--text-only';
}
?>

<section class="section-md">
  <div class="ls-container">
    <div class="<?= esc_attr(implode(' ', $content_classes)); ?>">

      <div class="ls-content-inner">

        <div class="ls-content-text">

          <?php if ($title) : ?>
            <h2 class="h2"><?= esc_html($title); ?></h2>
            <span class="ls-content-divider" aria-hidden="true"></span>
          <?php endif; ?>

          <?php if ($lead) : ?>
            <p class="ls-content-lead lead"><?= esc_html($lead); ?></p>
          <?php endif; ?>

          <?php if ($text) : ?>
            <div class="ls-content-body">
              <?= wp_kses_post($text); ?>
            </div>
          <?php endif; ?>

          <div class="ls-content-cta">
            <a href="/samenwerken" class="btn btn-primary">
              Bekijk onze oplossingen
            </a>
          </div>

        </div>

        <?php if ($visual_type === 'image' && $has_image) : ?>
          <div class="ls-content-visual">
            <img
              src="<?= esc_url($image_url); ?>"
              alt="<?= esc_attr($image_alt ?: $title); ?>"
              loading="lazy"
              decoding="async"
            >
          </div>
        <?php endif; ?>

        <?php if ($visual_type === 'collage' && $has_collage) : ?>
          <div
            class="ls-content-visual ls-content-visual--collage <?= $collage_breakout ? 'is-breakout' : ''; ?>"
            style="--collage-breakout: <?= esc_attr((int)$collage_breakout_value); ?>px;"
          >

            <div class="ls-collage">

              <?php if ($collage_main_url) : ?>
                <div
                  class="ls-collage-photo ls-photo-main"
                  style="background-image:url('<?= esc_url($collage_main_url); ?>');"
                ></div>
              <?php endif; ?>

              <?php if ($collage_top_url) : ?>
                <div
                  class="ls-collage-photo ls-photo-top"
                  style="background-image:url('<?= esc_url($collage_top_url); ?>');"
                ></div>
              <?php endif; ?>

              <?php if ($collage_bottom_url) : ?>
                <div
                  class="ls-collage-photo ls-photo-bottom"
                  style="background-image:url('<?= esc_url($collage_bottom_url); ?>');"
                ></div>
              <?php endif; ?>

              <?php if ($collage_badge_title || $collage_badge_text) : ?>
                <div class="ls-collage-badge">
                  <?php if ($collage_badge_title) : ?>
                    <strong><?= esc_html($collage_badge_title); ?></strong>
                  <?php endif; ?>
                  <?php if ($collage_badge_text) : ?>
                    <span><?= esc_html($collage_badge_text); ?></span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

            </div>

          </div>
        <?php endif; ?>

      </div>

    </div>
  </div>
</section>