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

    <?php
    $icon_value = $item['icon']['value'] ?? '';
    if (!empty($icon_value)) :
    ?>
      <div class="ls-card-icon" aria-hidden="true">
        <?php if (is_string($icon_value) && strpos($icon_value, '<svg') !== false) : ?>
          <?= wp_kses($icon_value, [
            'svg' => [
              'class' => true,
              'xmlns' => true,
              'width' => true,
              'height' => true,
              'viewbox' => true,
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
              'stroke-linecap' => true,
              'stroke-linejoin' => true,
              'aria-hidden' => true,
              'role' => true,
              'focusable' => true,
            ],
            'path' => [
              'd' => true,
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
              'stroke-linecap' => true,
              'stroke-linejoin' => true,
            ],
            'circle' => [
              'cx' => true,
              'cy' => true,
              'r' => true,
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
            ],
            'rect' => [
              'x' => true,
              'y' => true,
              'width' => true,
              'height' => true,
              'rx' => true,
              'ry' => true,
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
            ],
            'line' => [
              'x1' => true,
              'y1' => true,
              'x2' => true,
              'y2' => true,
              'stroke' => true,
              'stroke-width' => true,
              'stroke-linecap' => true,
            ],
            'polyline' => [
              'points' => true,
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
              'stroke-linecap' => true,
              'stroke-linejoin' => true,
            ],
            'polygon' => [
              'points' => true,
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
              'stroke-linecap' => true,
              'stroke-linejoin' => true,
            ],
            'g' => [
              'fill' => true,
              'stroke' => true,
              'stroke-width' => true,
            ],
          ]); ?>
        <?php else : ?>
          <i class="<?= esc_attr($icon_value); ?>"></i>
        <?php endif; ?>
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
