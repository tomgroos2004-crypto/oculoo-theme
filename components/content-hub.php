<?php
defined('ABSPATH') || exit;

if (!isset($settings) || !is_array($settings)) {
  return;
}

$title = $settings['title'] ?? '';
$intro = $settings['intro'] ?? '';
?>

<section class="ls-content-hub ls-widget">
  <div class="ls-container ls-stack">

    <?php if ($title || $intro) : ?>
      <header class="ls-content-hub-header ls-stack">
        <?php if ($title) : ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($intro) : ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <!-- SLOT: Kennis / Blogs -->
    <div class="ls-content-hub-section">
      <?php
      // Elementor inner section (hier plaats je blog widget)
      echo do_shortcode('[elementor-template id="BLOG_WIDGET"]');
      ?>
    </div>

    <!-- SLOT: Cases -->
    <div class="ls-content-hub-section">
      <?php
      // Elementor inner section (hier plaats je cases widget)
      echo do_shortcode('[elementor-template id="CASES_WIDGET"]');
      ?>
    </div>

    <!-- SLOT: Lokale links (optioneel) -->
    <div class="ls-content-hub-section">
      <?php
      // later: lokale links widget
      ?>
    </div>

  </div>
</section>
