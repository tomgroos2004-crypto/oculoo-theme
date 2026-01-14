<?php
/**
 * LeadSprint – Booking component
 *
 * Verwachte variabelen:
 * - $settings
 */

$title  = $settings['title'] ?? '';
$intro  = $settings['intro'] ?? '';
$embed = $settings['embed'] ?? '';

if (empty($embed)) {
  return;
}

$embed = preg_replace('/overflow\s*:\s*(auto|scroll)\s*;?/i', 'overflow:hidden;', $embed);
$embed = preg_replace('/height\s*:\s*100%\s*;?/i', '', $embed);

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
    'class'    => true,
    'style'    => true,
    'data-url' => true,
  ],
  'a' => [
    'href'   => true,
    'target' => true,
    'rel'    => true,
  ],
  'p' => [],
  'span' => [
    'class' => true,
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
