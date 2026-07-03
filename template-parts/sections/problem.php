<?php
if (!defined('ABSPATH')) exit;

$enabled = get_field('problem_enabled');
if (!$enabled) return;

$section_id      = get_field('problem_section_id') ?: 'probleem';
$eyebrow         = get_field('problem_eyebrow') ?: 'Het probleem';
$title_prefix    = get_field('problem_title_prefix') ?: 'Bestaande hulpmiddelen lossen slechts';
$title_highlight = get_field('problem_title_highlight') ?: 'de helft';
$title_suffix    = get_field('problem_title_suffix') ?: 'op';
$cards           = get_field('problem_cards');
$stat_number     = get_field('problem_stat_number') ?: '1,9';
$stat_highlight  = get_field('problem_stat_highlight') ?: 'M';
$stat_desc       = get_field('problem_stat_desc') ?: 'Nederlanders gebruiken dagelijks oogdruppels. Zij verdienen een oplossing die het volledig aanpakt.';
$stat_list       = get_field('problem_stat_list');

$section_id = sanitize_title($section_id);

if (empty($cards) || !is_array($cards)) {
  $cards = [
    [
      'icon'        => '',
      'title'       => 'Richten lukt niet',
      'text'        => '36% van de gebruikers krijgt de druppel niet goed in het oog. Trillende handen en gebrekkige coordinatie spelen daarin een grote rol.',
      'is_featured' => 1,
    ],
    [
      'icon'        => '',
      'title'       => 'Knijpen lukt niet',
      'text'        => '20% heeft onvoldoende kracht of controle in de vingers om het flesje in te drukken - ook met bestaande hulpmiddelen nog steeds een groot probleem.',
      'is_featured' => 0,
    ],
    [
      'icon'        => '',
      'title'       => 'Thuiszorg stopt ermee',
      'text'        => 'Vanaf 2026 stopt de thuiszorg grotendeels met het toedienen van oogdruppels. Ruim 1,9 miljoen Nederlanders moeten zelfstandig worden.',
      'is_featured' => 0,
    ],
  ];
}

if (empty($stat_list) || !is_array($stat_list)) {
  $stat_list = [
    ['text' => '76% heeft zelfs met bestaande hulpmiddelen nog problemen'],
    ['text' => '€24 miljoen jaarlijkse wijkzorgkosten'],
    ['text' => 'Bestaande oplossingen lossen slechts een deelprobleem op'],
  ];
}
?>

<section class="problem-section section-md" id="<?= esc_attr($section_id); ?>">
  <div class="ls-container section-inner">
    <?php if ($eyebrow) : ?>
      <span class="eyebrow"><?= esc_html($eyebrow); ?></span>
    <?php endif; ?>

    <h2 class="h2">
      <?php if ($title_prefix) : ?>
        <?= esc_html($title_prefix); ?>
      <?php endif; ?>
      <?php if ($title_highlight) : ?>
        <em><?= esc_html($title_highlight); ?></em>
      <?php endif; ?>
      <?php if ($title_suffix) : ?>
        <?= esc_html($title_suffix); ?>
      <?php endif; ?>
    </h2>

    <div class="problem-grid">
      <div>
        <?php foreach ($cards as $card) :
          $icon        = $card['icon'] ?? '';
          $title       = $card['title'] ?? '';
          $text        = $card['text'] ?? '';
          $is_featured = !empty($card['is_featured']);
        ?>
          <div class="problem-card<?= $is_featured ? ' is-featured' : ''; ?>">
            <?php if ($icon) : ?>
              <div class="pc-icon"><?= esc_html($icon); ?></div>
            <?php endif; ?>
            <div>
              <?php if ($title) : ?>
                <div class="pc-title"><?= esc_html($title); ?></div>
              <?php endif; ?>
              <?php if ($text) : ?>
                <div class="pc-text"><?= esc_html($text); ?></div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="stat-block">
        <div class="stat-num">
          <?= esc_html($stat_number); ?>
          <?php if ($stat_highlight) : ?>
            <em><?= esc_html($stat_highlight); ?></em>
          <?php endif; ?>
        </div>

        <?php if ($stat_desc) : ?>
          <p class="stat-desc"><?= esc_html($stat_desc); ?></p>
        <?php endif; ?>

        <?php if (!empty($stat_list) && is_array($stat_list)) : ?>
          <ul class="stat-list">
            <?php foreach ($stat_list as $item) :
              $text = $item['text'] ?? '';
              if (!$text) continue;
            ?>
              <li><?= esc_html($text); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
