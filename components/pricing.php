<?php
defined('ABSPATH') || exit;

$title    = $settings['title'] ?? '';
$intro    = $settings['intro'] ?? '';
$packages = is_array($settings['packages'] ?? null) ? $settings['packages'] : [];
?>

<section class="ls-pricing ls-widget">
  <div class="ls-container">

    <?php if ($title || $intro): ?>
      <header class="ls-pricing-header">
        <?php if ($title): ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($intro): ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php if ($packages): ?>
      <div class="ls-pricing-grid">

        <?php foreach ($packages as $pkg): 
          $is_featured = ($pkg['featured'] ?? '') === 'yes';
          $features = array_filter(array_map('trim', explode("\n", $pkg['features'] ?? '')));
        ?>

          <article class="ls-pricing-card <?= $is_featured ? 'is-featured' : ''; ?>">

            <header class="ls-pricing-card-header">
              <h3 class="h3"><?= esc_html($pkg['label'] ?? ''); ?></h3>
              <?php if (!empty($pkg['description'])): ?>
                <p><?= esc_html($pkg['description']); ?></p>
              <?php endif; ?>
            </header>

            <div class="ls-pricing-price">
              <?= esc_html($pkg['price'] ?? ''); ?>
            </div>

            <?php if ($features): ?>
              <ul class="ls-pricing-features">
                <?php foreach ($features as $feature): ?>
                  <li><?= esc_html($feature); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

            <?php if (!empty($pkg['button_url']['url'])): ?>
              <a
                class="btn btn-primary"
                href="<?= esc_url($pkg['button_url']['url']); ?>"
                <?= !empty($pkg['button_url']['is_external']) ? 'target="_blank" rel="noopener"' : ''; ?>
              >
                <?= esc_html($pkg['button_text'] ?? 'Meer info'); ?>
              </a>
            <?php endif; ?>

          </article>

        <?php endforeach; ?>

      </div>
    <?php endif; ?>

  </div>
</section>
