<?php
/**
 * LeadSprint – Booking component (SIMPEL)
 *
 * Verwachte variabelen:
 * - $settings['title']
 * - $settings['intro']
 * - $settings['embed']
 */

defined('ABSPATH') || exit;

$title = $settings['title'] ?? '';
$intro = $settings['intro'] ?? '';
$embed = $settings['embed'] ?? '';

if (!$embed) {
  return;
}

/**
 * Toegestane embed HTML
 */
$allowed = [
  'iframe' => [
    'src'             => true,
    'width'           => true,
    'height'          => true,
    'frameborder'     => true,
    'allow'           => true,
    'allowfullscreen' => true,
    'loading'         => true,
    'title'           => true,
    'style'           => true,
  ],
  'div' => [
    'id'    => true,
    'class' => true,
    'style' => true,
  ],
  'script' => [
    'src'   => true,
    'async' => true,
    'type'  => true,
  ],
];
?>

<section class="ls-booking">

  <div class="ls-section-inner">
    <div class="ls-container">

      <?php if ($title || $intro) : ?>
        <header class="ls-booking-header">
          <?php if ($title) : ?>
            <h2 class="h2"><?= esc_html($title); ?></h2>
          <?php endif; ?>

          <?php if ($intro) : ?>
            <p class="lead"><?= esc_html($intro); ?></p>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <div class="ls-booking-embed">
        <?= wp_kses($embed, $allowed); ?>
      </div>

    </div>
  </div>

</section>
