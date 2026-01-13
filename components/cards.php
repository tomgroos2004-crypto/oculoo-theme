<?php
$variant = $variant ?? 'cols-3 filled';

$classes = 'ls-cards';
foreach (explode(' ', $variant) as $v) {
  $classes .= ' ls-cards--' . $v;
}
?>

<section class="<?= esc_attr($classes); ?>">

  <div class="ls-section-inner">

    <div class="ls-container">

      <?php if ($title || $intro) : ?>
        <header class="ls-cards-header">
          <?php if ($title) : ?>
            <h2 class="h2"><?= esc_html($title); ?></h2>
          <?php endif; ?>

          <?php if ($intro) : ?>
            <p class="lead"><?= esc_html($intro); ?></p>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <div class="ls-cards-grid">
        <?php foreach ($items as $item) : ?>
          <?php include __DIR__ . '/card.php'; ?>
        <?php endforeach; ?>
      </div>

    </div>

  </div>

</section>
