<?php
$variant = $variant ?? 'variant-normal';

$classes = 'ls-cta';
foreach (explode(' ', $variant) as $v) {
  $classes .= ' ls-cta--' . $v;
}
?>

<section class="<?= esc_attr($classes); ?>">

  <div class="ls-container">

    <div class="ls-cta-inner">

      <?php if ($title) : ?>
        <h2 class="h2"><?= esc_html($title); ?></h2>
      <?php endif; ?>

      <?php if ($text) : ?>
        <p class="lead"><?= esc_html($text); ?></p>
      <?php endif; ?>

      <?php if ($button && $url) : ?>
        <a href="<?= esc_url($url); ?>" class="btn btn-primary">
          <?= esc_html($button); ?>
        </a>
      <?php endif; ?>

    </div>

  </div>

</section>
