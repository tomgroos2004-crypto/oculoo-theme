<?php
defined('ABSPATH') || exit;

$title = get_field('erkend_door_title', 'option') ?: 'Erkend door';
$items = get_field('erkend_door_logos', 'option');

if (empty($items) || !is_array($items)) {
  $items = [];

  if (have_rows('partners', 'option')) {
    while (have_rows('partners', 'option')) {
      the_row();
      $items[] = [
        'logo' => get_sub_field('logo'),
        'link' => get_sub_field('link'),
      ];
    }
  }
}

if (empty($items)) return;
?>

<section class="ls-partners-strip" data-partners>
  <div class="ls-container">
    <div class="ls-partners-strip__inner">
      <?php if ($title) : ?>
        <span class="ls-partners-strip__label"><?= esc_html($title); ?></span>
      <?php endif; ?>

      <div class="ls-partners-strip__logos">
        <?php foreach ($items as $item) :
          $logo = $item['logo'] ?? null;
          $link = $item['link'] ?? '';

          $logo_url = is_array($logo) ? ($logo['url'] ?? '') : (string) $logo;
          if (!$logo_url) continue;

          $logo_alt = is_array($logo) ? ($logo['alt'] ?? '') : '';
        ?>
          <div class="ls-partners-strip__item">
            <?php if ($link) : ?>
              <a href="<?= esc_url($link); ?>" target="_blank" rel="noopener">
            <?php endif; ?>

            <img src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($logo_alt); ?>" loading="lazy">

            <?php if ($link) : ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
