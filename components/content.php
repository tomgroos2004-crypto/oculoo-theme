<?php
/**
 * LeadSprint – Content component
 *
 * Verwachte variabelen:
 * - $title
 * - $lead
 * - $text (HTML toegestaan)
 * - $image_url
 * - $image_alt
 * - $variant (bv: "normal", "compact", "spacious text-only")
 */

$title     = $title     ?? '';
$lead      = $lead      ?? '';
$text      = $text      ?? '';
$image_url = $image_url ?? '';
$image_alt = $image_alt ?? '';

$variant = $variant ?? 'normal';
$variant = strtolower(trim($variant));

/**
 * Tokenize op spaties (BELANGRIJK):
 * "compact text-only" -> ["compact", "text-only"]
 * "text_only" -> ["text-only"]
 */
$tokens = preg_split('/\s+/', $variant, -1, PREG_SPLIT_NO_EMPTY);
$tokens = array_map(function($t){
  $t = str_replace('_', '-', $t);
  return $t;
}, $tokens);

/**
 * Text-only alleen geldig als er GEEN afbeelding is
 */
$is_text_only = in_array('text-only', $tokens, true) && empty($image_url);

/* Classes */
$classes = ['ls-content'];

foreach ($tokens as $t) {
  if ($t === 'text-only' && !$is_text_only) {
    // als er een image is: text-only negeren
    continue;
  }
  $classes[] = 'ls-content--' . esc_attr($t);
}
?>

<section class="<?= esc_attr(implode(' ', $classes)); ?>">
  <div class="ls-container">
    <div class="ls-content-inner">

      <div class="ls-content-text">
        <?php if ($title) : ?>
          <h2><?= esc_html($title); ?></h2>
          <span class="ls-content-divider" aria-hidden="true"></span>
        <?php endif; ?>

        <?php if ($lead) : ?>
          <p class="ls-content-lead"><?= esc_html($lead); ?></p>
        <?php endif; ?>

        <?php if ($text) : ?>
          <div class="ls-content-body">
            <?= $text; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($image_url) : ?>
        <div class="ls-content-visual">
          <img
            src="<?= esc_url($image_url); ?>"
            alt="<?= esc_attr($image_alt ?: $title); ?>"
            loading="lazy"
            decoding="async"
          >
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>
