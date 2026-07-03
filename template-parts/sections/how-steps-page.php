<?php
defined('ABSPATH') || exit;

$enabled = get_field('how_steps_enabled');
if ((string) $enabled === '0') return;

$products = get_field('how_steps_products');
$global_eyebrow = get_field('how_steps_eyebrow') ?: 'Oculoo oogdruppelbril';
$global_title = get_field('how_steps_title') ?: 'Hoe gebruik je de Oogdruppelbril?';
$global_lead = get_field('how_steps_lead') ?: 'Haal het dopje van het flesje, zet de bril op, knijp zachtjes - en reinig na gebruik. Klaar.';
$global_chip = get_field('how_steps_chip') ?: '4 eenvoudige stappen';
$global_steps = get_field('how_steps_items');

$global_lead = is_string($global_lead) ? wp_strip_all_tags($global_lead) : '';

if (empty($products) || !is_array($products)) {
  $products = [
    [
      'title' => 'Oculoo Oogdruppelbril',
      'subtitle' => 'Universeel model',
      'active' => 1,
    ],
    [
      'title' => 'Oculoo Minim-bril',
      'subtitle' => 'Compact model',
      'active' => 0,
    ],
  ];
}

if (empty($global_steps) || !is_array($global_steps)) {
  $global_steps = [
    [
      'media_label' => '1 - Flesje plaatsen',
      'title' => 'Plaats het flesje',
      'text' => 'Haal het dopje van het oogdruppelflesje. Schuif het tuitje in de houder van de bril.',
    ],
    [
      'media_label' => '2 - Zet de bril op',
      'title' => 'Zet de bril op',
      'text' => 'Zet de bril op zoals een gewone bril. Kijk omhoog naar het plafond.',
    ],
    [
      'media_label' => '3 - Knijp zachtjes',
      'title' => 'Knijp zachtjes',
      'text' => 'Trek uw onderste ooglid licht omlaag. Knijp rustig in het knijpertje. De druppel valt op de juiste plek.',
    ],
    [
      'media_label' => '4 - Reinig de bril',
      'title' => 'Reinig na gebruik',
      'text' => 'Maak de bril en de houder schoon met een zachte doek of tissue.',
    ],
  ];
}

$normalized_products = [];
$active_index = 0;

$tab_count = count(array_filter(
  array_slice($products, 0, 2),
  fn($p) => trim((string) ($p['title'] ?? '')) !== '' || trim((string) ($p['subtitle'] ?? '')) !== ''
));

foreach (array_slice($products, 0, 2) as $index => $product) {
  $product_title    = isset($product['title'])    ? trim((string) $product['title'])    : '';
  $product_subtitle = isset($product['subtitle']) ? trim((string) $product['subtitle']) : '';
  $product_steps    = (isset($product['items']) && is_array($product['items'])) ? $product['items'] : [];

  if (empty($product_steps)) {
    $product_steps = $global_steps;
  }

  if ($product_title === '' && $product_subtitle === '') {
    continue;
  }

  $panel_eyebrow = $tab_count > 1 && $product_title !== '' ? $product_title : $global_eyebrow;
  $panel_title   = $tab_count > 1 && $product_title !== ''
    ? str_replace('{product}', $product_title, $global_title)
    : $global_title;

  $normalized_products[] = [
    'tab_title'    => $product_title,
    'tab_subtitle' => $product_subtitle,
    'eyebrow'      => $panel_eyebrow,
    'title'        => $panel_title,
    'lead'         => $global_lead,
    'chip'         => $global_chip,
    'steps'        => $product_steps,
  ];
}

if (empty($normalized_products)) {
  $normalized_products[] = [
    'tab_title' => 'Oculoo Oogdruppelbril',
    'tab_subtitle' => 'Universeel model',
    'eyebrow' => $global_eyebrow,
    'title' => $global_title,
    'lead' => $global_lead,
    'chip' => $global_chip,
    'steps' => $global_steps,
  ];
}

$has_tabs = count($normalized_products) > 1;
$section_id = 'how-steps-' . get_the_ID();
?>

<section class="how-steps-page section-md" id="how" data-how-steps>
  <div class="ls-container">
    <?php if ($has_tabs) : ?>
      <div class="how-steps-page__switch" role="tablist" aria-label="Productvariant">
        <?php foreach ($normalized_products as $index => $product) :
          $is_active = $index === $active_index;
          $tab_id = $section_id . '-tab-' . ($index + 1);
          $panel_id = $section_id . '-panel-' . ($index + 1);
        ?>
          <button
            type="button"
            class="how-steps-page__switch-item<?= $is_active ? ' is-active' : ''; ?>"
            id="<?= esc_attr($tab_id); ?>"
            role="tab"
            aria-selected="<?= $is_active ? 'true' : 'false'; ?>"
            aria-controls="<?= esc_attr($panel_id); ?>"
            data-how-steps-tab
          >
            <?php if ($product['tab_title'] !== '') : ?>
              <p class="how-steps-page__switch-title"><?= esc_html($product['tab_title']); ?></p>
            <?php endif; ?>
            <?php if ($product['tab_subtitle'] !== '') : ?>
              <p class="how-steps-page__switch-subtitle"><?= esc_html($product['tab_subtitle']); ?></p>
            <?php endif; ?>
          </button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php foreach ($normalized_products as $index => $product) :
      $is_active = $index === $active_index;
      $panel_id = $section_id . '-panel-' . ($index + 1);
      $tab_id = $has_tabs ? ($section_id . '-tab-' . ($index + 1)) : '';
      $panel_steps = (isset($product['steps']) && is_array($product['steps'])) ? $product['steps'] : [];
    ?>
      <div
        class="how-steps-page__panel<?= $is_active ? ' is-active' : ''; ?>"
        id="<?= esc_attr($panel_id); ?>"
        role="tabpanel"
        <?= $tab_id !== '' ? 'aria-labelledby="' . esc_attr($tab_id) . '"' : ''; ?>
        <?= $is_active ? '' : 'hidden'; ?>
        data-how-steps-panel
      >
        <div class="how-steps-page__head">
          <div>
            <?php if ($product['eyebrow']) : ?>
              <p class="how-steps-page__eyebrow"><?= esc_html($product['eyebrow']); ?></p>
            <?php endif; ?>

            <?php if ($product['title']) : ?>
              <h2 class="how-steps-page__title"><?= esc_html($product['title']); ?></h2>
            <?php endif; ?>

            <?php if ($product['lead']) : ?>
              <p class="how-steps-page__lead"><?= esc_html($product['lead']); ?></p>
            <?php endif; ?>
          </div>

          <?php if ($product['chip']) : ?>
            <div class="how-steps-page__chip">✓ <?= esc_html($product['chip']); ?></div>
          <?php endif; ?>
        </div>

        <?php if (!empty($panel_steps)) : ?>
          <div class="how-steps-page__grid">
            <?php foreach (array_slice($panel_steps, 0, 4) as $step_index => $step) :
              $number = $step_index + 1;
              $media_label = isset($step['media_label']) ? trim((string) $step['media_label']) : '';
              $step_title = isset($step['title']) ? trim((string) $step['title']) : '';
              $step_text = isset($step['text']) ? trim((string) $step['text']) : '';
              $step_image = $step['image'] ?? null;
              $step_image_url = is_array($step_image) ? ($step_image['url'] ?? '') : '';
              $step_image_alt = is_array($step_image) ? ($step_image['alt'] ?? '') : '';
              if ($step_title === '' && $step_text === '' && $media_label === '' && $step_image_url === '') continue;
            ?>
              <article class="how-step-card">
                <div class="how-step-card__media">
                  <span class="how-step-card__badge"><?= esc_html((string) $number); ?></span>
                  <?php if ($step_image_url !== '') : ?>
                    <img src="<?= esc_url($step_image_url); ?>" alt="<?= esc_attr($step_image_alt ?: $step_title); ?>" loading="lazy" decoding="async">
                  <?php elseif ($media_label !== '') : ?>
                    <p class="how-step-card__media-label"><?= esc_html($media_label); ?></p>
                  <?php endif; ?>
                </div>
                <div class="how-step-card__body">
                  <?php if ($step_title !== '') : ?>
                    <h3><?= esc_html($step_title); ?></h3>
                  <?php endif; ?>
                  <?php if ($step_text !== '') : ?>
                    <p><?= esc_html(wp_strip_all_tags($step_text)); ?></p>
                  <?php endif; ?>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>
