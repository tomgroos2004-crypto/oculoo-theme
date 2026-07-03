<?php
defined('ABSPATH') || exit;

$enabled = get_field('how_tips_enabled');
if ((string) $enabled === '0') return;

$eyebrow = get_field('how_tips_eyebrow') ?: 'Handige tips';
$title = get_field('how_tips_title') ?: 'Voor het beste resultaat';
$items = get_field('how_tips_items');

if (empty($items) || !is_array($items)) {
  $items = [
    [
      'title' => 'Kijk altijd omhoog',
      'text' => 'Kantel uw hoofd licht naar achteren en kijk naar het plafond. Dit zorgt ervoor dat de druppel direct op de juiste plek valt.',
    ],
    [
      'title' => 'Trek het ooglid licht omlaag',
      'text' => 'Trek uw onderste ooglid voorzichtig omlaag voor u knijpt. Dit vergroot het oppervlak en voorkomt dat de druppel wegloopt.',
    ],
    [
      'title' => 'Reinig na elk gebruik',
      'text' => 'Veeg de houder en het frame na gebruik schoon met een zachte doek of tissue. Dit houdt de bril hygienisch en betrouwbaar.',
    ],
  ];
}
?>

<section class="how-tips-page section-md">
  <div class="ls-container">
    <header class="how-tips-page__head">
      <?php if ($eyebrow) : ?>
        <p class="how-tips-page__eyebrow"><?= esc_html($eyebrow); ?></p>
      <?php endif; ?>

      <?php if ($title) : ?>
        <h2 class="how-tips-page__title"><?= esc_html($title); ?></h2>
      <?php endif; ?>
    </header>

    <div class="how-tips-page__grid">
      <?php foreach (array_slice($items, 0, 3) as $item) :
        $icon = $item['icon'] ?? null;
        $icon_url = is_array($icon) ? ($icon['url'] ?? '') : '';
        $icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
        $item_title = isset($item['title']) ? trim((string) $item['title']) : '';
        $item_text = isset($item['text']) ? trim((string) $item['text']) : '';
        if ($item_title === '' && $item_text === '') continue;
      ?>
        <article class="how-tip-card">
          <?php if ($icon_url !== '') : ?>
            <img class="how-tip-card__icon" src="<?= esc_url($icon_url); ?>" alt="<?= esc_attr($icon_alt ?: $item_title); ?>" loading="lazy" decoding="async">
          <?php endif; ?>

          <?php if ($item_title !== '') : ?>
            <h3><?= esc_html($item_title); ?></h3>
          <?php endif; ?>

          <?php if ($item_text !== '') : ?>
            <p><?= esc_html(wp_strip_all_tags($item_text)); ?></p>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
