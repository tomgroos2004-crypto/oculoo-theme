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
 * - $variant (bv: "normal", "compact", "spacious text-only handshake")
 */

$title     = $title     ?? '';
$lead      = $lead      ?? '';
$text      = $text      ?? '';
$image_url = $image_url ?? '';
$image_alt = $image_alt ?? '';

$variant = strtolower(trim($variant ?? 'normal'));

/**
 * Tokenize variant string
 * "compact text-only handshake"
 */
$tokens = preg_split('/\s+/', $variant, -1, PREG_SPLIT_NO_EMPTY);
$tokens = array_map(function ($t) {
  return str_replace('_', '-', $t);
}, $tokens);

/**
 * Text-only alleen geldig zonder afbeelding
 */
$is_text_only = in_array('text-only', $tokens, true) && empty($image_url);

/* Base class */
$classes = ['ls-content'];

/* Variants */
foreach ($tokens as $t) {

  if ($t === 'text-only' && !$is_text_only) {
    continue;
  }

  if ($t === 'handshake') {
    $classes[] = 'ls-content--handshake';
    continue;
  }

  $classes[] = 'ls-content--' . esc_attr($t);
}

$class_attr = implode(' ', array_unique($classes));
?>

<section class="<?= esc_attr($class_attr); ?>" data-content>
  <div class="ls-container">
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
            <?= $text; ?>
          </div>
        <?php endif; ?>
		  <div class="ls-content-cta">
      <a href="/Bekijk onze oplossingen" class="btn btn-primary">
        Samenwerken?
      </a>
    </div>
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
