<?php
$variant = $item['variant'] ?? '';
$is_cta  = !empty($item['is_cta']);

$classes = 'ls-card';

/* CTA = altijd hoogste prioriteit */
if ($is_cta) {
  $classes .= ' ls-card--cta';
}

/* Semantische context */
if ($variant === 'problem') {
  $classes .= ' ls-card--problem';
}

if ($variant === 'trust') {
  $classes .= ' ls-card--trust ls-card--centered';
}

/* USP / Feature = primaire hiërarchie */
if ($variant === 'feature') {
  $classes .= ' ls-card--usp ls-card--centered';
}
?>

<article class="<?= esc_attr($classes); ?>">

  <?php if ($variant === 'trust') : ?>

    <?php if (!empty($item['image'])) :
      $img_url = is_array($item['image']) ? ($item['image']['url'] ?? '') : $item['image'];
    ?>
      <div class="ls-card-avatar">
        <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($item['name'] ?? ''); ?>">
      </div>
    <?php endif; ?>

    <?php if (!empty($item['name'])) : ?>
      <h3 class="ls-card-name"><?= esc_html($item['name']); ?></h3>
    <?php endif; ?>

    <?php if (!empty($item['role'])) : ?>
      <p class="ls-card-role"><?= esc_html($item['role']); ?></p>
    <?php endif; ?>

    <div class="ls-card-stars" aria-label="5 sterren beoordeling">
      <?php $stars = intval($item['stars'] ?? 5); ?>
      <?php for ($i = 0; $i < $stars; $i++) : ?>
        <span class="ls-card-star" aria-hidden="true">★</span>
      <?php endfor; ?>
    </div>

    <?php if (!empty($item['title'])) : ?>
      <h4 class="ls-card-title"><?= esc_html($item['title']); ?></h4>
    <?php endif; ?>

    <?php if (!empty($item['text'])) : ?>
      <p class="ls-card-text"><?= esc_html($item['text']); ?></p>
    <?php endif; ?>

  <?php else : ?>

    <?php if (!empty($item['icon']['value'])) : ?>
      <div class="ls-card-icon">
        <?php \Elementor\Icons_Manager::render_icon($item['icon']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($item['title'])) : ?>
      <h3 class="ls-card-title"><?= esc_html($item['title']); ?></h3>
    <?php endif; ?>

    <?php if (!empty($item['text'])) : ?>
      <p class="ls-card-text"><?= esc_html($item['text']); ?></p>
    <?php endif; ?>

    <?php if (!empty($item['button_text']) && !empty($item['button_url']['url'])) : ?>
      <div class="ls-card-action">
        <a href="<?= esc_url($item['button_url']['url']); ?>"
           class="btn btn-<?= esc_attr($item['button_style']); ?>">
          <?= esc_html($item['button_text']); ?>
        </a>
      </div>
    <?php endif; ?>

  <?php endif; ?>

</article>
