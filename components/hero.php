<?php
/**
 * LeadSprint – Hero component
 */

/* =====================
   Data (veilig ophalen)
===================== */

$title  = $title  ?? '';
$text   = $text   ?? '';

$button_primary        = $button_primary        ?? '';
$button_primary_url    = $button_primary_url    ?? '';

$button_secondary      = $button_secondary      ?? '';
$button_secondary_url  = $button_secondary_url  ?? '';

$image   = $image   ?? '';
$variant = $variant ?? 'split normal';

/* =====================
   Classes opbouwen
   "split normal" → ls-hero--split ls-hero--normal
===================== */

$classes = trim(
  'ls-hero ' .
  ($variant ? 'ls-hero--' . str_replace(' ', ' ls-hero--', $variant) : '')
);

/* =====================
   Background style (alleen bij background hero)
===================== */

$bg_style = '';
if (strpos($variant, 'background') !== false && $image) {
  $bg_style = 'style="background-image:url(' . esc_url($image) . ');"';
}
?>

<section class="<?= esc_attr($classes); ?>" <?= $bg_style; ?>>

  <div class="ls-container">
    <div class="ls-hero-inner">

      <div class="ls-hero-content">

        <?php if ($title) : ?>
          <h1 class="h1"><?= esc_html($title); ?></h1>
        <?php endif; ?>

        <?php if ($text) : ?>
          <p class="lead"><?= esc_html($text); ?></p>
        <?php endif; ?>

        <?php if ($button_primary || $button_secondary) : ?>
          <div class="ls-row">

            <?php if ($button_primary && $button_primary_url) : ?>
              <a
                href="<?= esc_url($button_primary_url); ?>"
                class="btn btn-primary"
              >
                <?= esc_html($button_primary); ?>
              </a>
            <?php endif; ?>

            <?php if ($button_secondary && $button_secondary_url) : ?>
              <a
                href="<?= esc_url($button_secondary_url); ?>"
                class="btn btn-secondary"
              >
                <?= esc_html($button_secondary); ?>
              </a>
            <?php endif; ?>

          </div>
        <?php endif; ?>

      </div>

      <?php if (strpos($variant, 'background') === false && $image) : ?>
        <div class="ls-hero-visual">
          <img
            src="<?= esc_url($image); ?>"
            alt="<?= esc_attr($title ?: 'Hero afbeelding'); ?>"
            loading="eager"
            decoding="async"
          >
        </div>
      <?php endif; ?>

    </div>
  </div>

</section>
