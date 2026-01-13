<?php
defined('ABSPATH') || exit;

if (!isset($settings) || !is_array($settings)) {
  return;
}

$title = $settings['title'] ?? '';
$intro = $settings['intro'] ?? '';
$items = is_array($settings['items'] ?? null) ? $settings['items'] : [];
$cols  = $settings['columns'] ?? '3';
?>

<section class="ls-cases-list ls-widget">
  <div class="ls-container">

    <?php if ($title || $intro) : ?>
      <header class="ls-cases-header ls-stack">
        <?php if ($title) : ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($intro) : ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php if ($items) : ?>
      <div class="ls-cards ls-cards--cols-<?= esc_attr($cols); ?>">
        <div class="ls-cards-grid">

          <?php foreach ($items as $item) :

            $bg    = $item['case_image']['url'] ?? '';
            $style = $bg ? 'style="--card-bg:url(' . esc_url($bg) . ')"' : '';
            $class = 'ls-card ls-case-card' . ($bg ? ' has-bg' : '');
            $url   = $item['case_url']['url'] ?? '';
          ?>

            <article class="<?= esc_attr($class); ?>" <?= $style; ?>>

              <?php if (!empty($item['case_result'])) : ?>
                <div class="ls-case-result">
                  <?= esc_html($item['case_result']); ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($item['case_title'])) : ?>
                <h3 class="ls-card-title">
                  <?= esc_html($item['case_title']); ?>
                </h3>
              <?php endif; ?>

              <?php if (!empty($item['case_text'])) : ?>
                <p class="ls-card-text">
                  <?= esc_html($item['case_text']); ?>
                </p>
              <?php endif; ?>

              <div class="ls-case-meta">
                <?php if (!empty($item['case_service'])) : ?>
                  <span><?= esc_html($item['case_service']); ?></span>
                <?php endif; ?>
                <?php if (!empty($item['case_location'])) : ?>
                  <span>• <?= esc_html($item['case_location']); ?></span>
                <?php endif; ?>
              </div>

              <?php if ($url) : ?>
                <a class="ls-card-link" href="<?= esc_url($url); ?>" aria-label="<?= esc_attr($item['case_title'] ?? 'Bekijk case'); ?>"></a>
              <?php endif; ?>

            </article>

          <?php endforeach; ?>

        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
