<?php
if (!defined('ABSPATH')) exit;

$enabled = get_field('how_enabled');
if (!$enabled) return;

$section_id = sanitize_title(get_field('how_section_id') ?: 'how');
$eyebrow    = get_field('how_eyebrow') ?: 'Hoe het werkt';
$title      = get_field('how_title') ?: 'Een beweging. Een druppel.';
$lead       = get_field('how_lead') ?: 'Oculoo combineert automatisch richten en krachtloos knijpen in een simpele handeling. Geen coordinatie, geen kracht, geen contact met het oog.';
$steps      = get_field('how_steps');

$lead = is_string($lead) ? wp_strip_all_tags($lead) : '';

if (empty($steps) || !is_array($steps)) {
  $steps = [
    [
      'title' => 'Zet de bril op',
      'text'  => 'Klik het oogdruppelflesje in het universele houdsysteem. Werkt met vrijwel alle standaard flesjes.',
    ],
    [
      'title' => 'Automatisch gericht',
      'text'  => 'De bril positioneert het flesje automatisch boven het juiste oog. Mikken en coordineren is niet meer nodig.',
    ],
    [
      'title' => 'Lichte druk, druppel',
      'text'  => 'Via het hefboommechanisme doe je een lichte beweging. Het systeem knijpt krachtloos voor je.',
    ],
  ];
}
?>

<section class="how-section section-md" id="<?= esc_attr($section_id); ?>">
  <div class="ls-container section-inner">
    <div class="how-header">
      <?php if ($eyebrow) : ?>
        <span class="eyebrow"><?= esc_html($eyebrow); ?></span>
      <?php endif; ?>

      <?php if ($title) : ?>
        <h2 class="h2"><?= esc_html($title); ?></h2>
      <?php endif; ?>

      <?php if ($lead) : ?>
        <p class="lead"><?= esc_html($lead); ?></p>
      <?php endif; ?>
    </div>

    <?php if (!empty($steps) && is_array($steps)) : ?>
      <div class="steps">
        <?php foreach ($steps as $index => $step) :
          $step_title = $step['title'] ?? '';
          $step_text  = isset($step['text']) && is_string($step['text']) ? wp_strip_all_tags($step['text']) : '';
          if (!$step_title && !$step_text) continue;
          $step_number = (string) ($index + 1);
        ?>
          <article class="step">
            <div class="step-n"><?= esc_html($step_number); ?></div>
            <?php if ($step_title) : ?>
              <h3 class="step-title"><?= esc_html($step_title); ?></h3>
            <?php endif; ?>
            <?php if ($step_text) : ?>
              <p class="step-text"><?= esc_html($step_text); ?></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
