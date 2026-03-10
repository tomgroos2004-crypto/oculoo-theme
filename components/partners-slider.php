<?php
defined('ABSPATH') || exit;

$title = $settings['title'] ?? '';
$logos = is_array($settings['logos'] ?? null) ? $settings['logos'] : [];

if (empty($logos)) {
  return;
}
?>

<section class="ls-partners-slider">
  <div class="ls-container--wide">

      <?php if ($title) : ?>
        <header class="ls-partners-slider__header">
          <h2 class="h2"><?= esc_html($title); ?></h2>
        </header>
      <?php endif; ?>

      <div class="ls-partners-slider__viewport">
        <div class="ls-partners-slider__track" data-ls-marquee="true">
          <?php foreach ($logos as $logo) :
            $img = $logo['image']['url'] ?? '';
            $alt = $logo['alt'] ?? '';
            if (!$img) continue;
          ?>
            <div class="ls-partners-slider__item">
              <img src="<?= esc_url($img); ?>" alt="<?= esc_attr($alt); ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
</section>
