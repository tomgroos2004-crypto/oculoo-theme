<?php
defined('ABSPATH') || exit;

/* =============================
   ACF Fields
============================= */

$heading   = get_sub_field('testi_heading');
$highlight = get_sub_field('testi_highlight');
$items     = get_sub_field('testi_items');
$footer_quote = get_sub_field('testi_footer_quote') ?: 'Veel makkelijker dan bestaande hulpmiddelen. Eindelijk iets wat echt werkt.';
$footer_meta_title = get_sub_field('testi_footer_meta_title') ?: 'Gebruikerstests';
$footer_meta_text  = get_sub_field('testi_footer_meta_text') ?: '150+ ouderen getest';

if (is_array($items)) {
  $items = array_slice($items, 0, 2);
}

if (empty($items)) return;

/* Wrap highlight in a span, safely */
$heading_html = '';
if ($heading) {
  $heading_safe    = esc_html($heading);
  $highlight_safe  = $highlight ? esc_html($highlight) : '';

  if ($highlight_safe && str_contains($heading_safe, $highlight_safe)) {
    $heading_html = str_replace(
      $highlight_safe,
      '<mark class="ls-highlight">' . $highlight_safe . '</mark>',
      $heading_safe
    );
  } else {
    $heading_html = $heading_safe;
  }
}
?>

<section class="ls-testimonials section-sm">
  <div class="ls-container">

    <?php if ($heading_html) : ?>
      <h2 class="ls-testimonials-heading"><?= $heading_html; ?></h2>
    <?php endif; ?>

    <div class="ls-testimonials-grid">

      <?php foreach ($items as $item) :
        $name        = $item['testi_name']        ?? '';
        $role        = $item['testi_role']        ?? '';
        $photo       = $item['testi_photo']       ?? null;
        $quote_title = $item['testi_quote_title'] ?? '';
        $quote_text  = $item['testi_quote_text']  ?? '';

        $photo_url = '';
        $photo_alt = '';
        if (!empty($photo) && is_array($photo)) {
          $photo_url = $photo['url'] ?? '';
          $photo_alt = $photo['alt'] ?? $name;
        }
      ?>

        <article class="ls-testi-card <?= $photo_url ? 'has-photo' : ''; ?>">

          <?php if ($photo_url) : ?>
            <div class="ls-testi-photo">
              <img
                src="<?= esc_url($photo_url); ?>"
                alt="<?= esc_attr($photo_alt); ?>"
                loading="lazy"
                decoding="async"
                width="80"
                height="80"
              >
            </div>
          <?php endif; ?>

          <div class="ls-testi-body">

            <?php if ($name || $role) : ?>
              <div class="ls-testi-author">
                <?php if ($name) : ?>
                  <strong class="ls-testi-name"><?= esc_html($name); ?></strong>
                <?php endif; ?>
                <?php if ($role) : ?>
                  <span class="ls-testi-role"><?= esc_html($role); ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if ($quote_title) : ?>
              <p class="ls-testi-quote-title"><?= esc_html($quote_title); ?></p>
            <?php endif; ?>

            <?php if ($quote_text) : ?>
              <p class="ls-testi-quote-text"><?= esc_html($quote_text); ?></p>
            <?php endif; ?>

          </div>

        </article>

      <?php endforeach; ?>

    </div>

    <div class="ls-testi-quote-bar">
      <p class="ls-testi-quote-bar__text"><?= esc_html($footer_quote); ?></p>
      <div class="ls-testi-quote-bar__meta">
        <strong><?= esc_html($footer_meta_title); ?></strong>
        <span><?= esc_html($footer_meta_text); ?></span>
      </div>
    </div>

  </div>
</section>
