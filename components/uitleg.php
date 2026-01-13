<?php
defined('ABSPATH') || exit;

if (!isset($settings) || !is_array($settings)) {
  return;
}

$title = $settings['title'] ?? '';
$intro = $settings['intro'] ?? '';
$items = is_array($settings['items'] ?? null) ? $settings['items'] : [];
?>

<section class="ls-uitleg ls-widget">
  <div class="ls-container--narrow ls-stack">

    <?php if ($title || $intro) : ?>
      <header class="ls-uitleg-header ls-stack">
        <?php if ($title) : ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($intro) : ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php if ($items) : ?>
      <div class="ls-uitleg-list ls-stack">

        <?php foreach ($items as $item) : ?>
          <div class="ls-uitleg-item ls-stack">

            <?php if (!empty($item['item_title'])) : ?>
              <h3 class="h4"><?= esc_html($item['item_title']); ?></h3>
            <?php endif; ?>

            <?php if (!empty($item['item_text'])) : ?>
              <p><?= esc_html($item['item_text']); ?></p>
            <?php endif; ?>

          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>
<div class="ls-case-showcase__cta ls-row">
  <a href="/cases" class="btn btn-secondary">
    Meer over ons
  </a>
  </div>
</section>
