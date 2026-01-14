<?php
/**
 * LeadSprint – Booking component
 *
 * Verwachte variabelen:
 * - $settings
 */

$title  = $settings['title'] ?? '';
$intro  = $settings['intro'] ?? '';
$people = $settings['people'] ?? [];

if (empty($people)) {
  return;
}

$uid = wp_unique_id('ls-booking-');

$allowed = [
  'iframe' => [
    'src'             => true,
    'width'           => true,
    'frameborder'     => true,
    'allow'           => true,
    'allowfullscreen' => true,
    'loading'         => true,
    'title'           => true,
    'style'           => true,
  ],
  'div' => [
    'class'    => true,
    'style'    => true,
    'data-url' => true,
  ],
  'a' => [
    'href'   => true,
    'target' => true,
    'rel'    => true,
  ],
  'p' => [],
  'span' => [
    'class' => true,
  ],
  'script' => [
    'src'   => true,
    'async' => true,
    'type'  => true,
  ],
];
?>

<section class="ls-booking">

  <div class="ls-section-inner">
    <div class="ls-container">

      <?php if ($title || $intro) : ?>
        <header class="ls-booking-header">
          <?php if ($title) : ?>
            <h2 class="h2"><?= esc_html($title); ?></h2>
          <?php endif; ?>

          <?php if ($intro) : ?>
            <p class="lead"><?= esc_html($intro); ?></p>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <div class="ls-booking-tabs" role="tablist" aria-label="<?= esc_attr($title ?: 'Booking'); ?>">
        <?php foreach ($people as $index => $person) : ?>
          <?php
          $name = $person['name'] ?? '';
          $photo = $person['photo']['url'] ?? '';
          $input_id = $uid . '-' . $index;
          $checked = $index === 0 ? 'checked' : '';
          ?>

          <input
            class="ls-booking-input"
            type="radio"
            name="<?= esc_attr($uid); ?>"
            id="<?= esc_attr($input_id); ?>"
            <?= $checked; ?>
          >

          <label class="ls-booking-tab" for="<?= esc_attr($input_id); ?>">
            <?php if ($photo) : ?>
              <span class="ls-booking-avatar">
                <img src="<?= esc_url($photo); ?>" alt="<?= esc_attr($name); ?>" loading="lazy" decoding="async">
              </span>
            <?php endif; ?>
            <span class="ls-booking-name"><?= esc_html($name); ?></span>
          </label>

          <div class="ls-booking-content" role="tabpanel">
			   <div class="ls-booking-embed">
              <?= wp_kses($person['embed'] ?? '', $allowed); ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>

</section>
