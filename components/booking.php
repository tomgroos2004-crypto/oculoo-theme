<?php
if (!defined('ABSPATH')) exit;

$title = $settings['title'] ?? '';
$intro = $settings['intro'] ?? '';
$embed = $settings['embed'] ?? '';
?>

<section class="ls-booking">
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

    <?php if ($embed) : ?>
      <div class="ls-booking-embed">
        <?= wp_kses_post($embed); ?>
      </div>
    <?php endif; ?>

  </div>
</section>
