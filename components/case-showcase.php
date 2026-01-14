<?php
defined('ABSPATH') || exit;

/**
 * Verwachte settings vanuit widget:
 * - title
 * - intro
 * - cases (repeater)
 * - cta_text
 * - cta_link
 */

$title    = $settings['title'] ?? '';
$intro    = $settings['intro'] ?? '';
$items    = is_array($settings['cases'] ?? null) ? $settings['cases'] : [];
$cta_text = $settings['cta_text'] ?? '';
$cta_link = $settings['cta_link']['url'] ?? '';
?>

<section class="ls-case-showcase ls-case-showcase--amplifier ls-widget">
  <div class="ls-container--wide ls-stack">

    <?php if ($title || $intro) : ?>
      <header class="ls-case-showcase__header ls-stack">
        <?php if ($title) : ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($intro) : ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="ls-case-showcase__viewport" data-case-showcase>
      <div class="ls-case-showcase__track">
        <?php foreach ($items as $item) :
          $img = $item['image']['url'] ?? '';
          $txt = $item['title'] ?? '';
          $url = $item['link']['url'] ?? '#';
        ?>
          <a class="ls-case-showcase__item" href="<?= esc_url($url); ?>">
            <figure class="ls-case-showcase__frame">
              <?php if ($img) : ?>
                <img src="<?= esc_url($img); ?>" alt="">
              <?php else : ?>
                <div style="aspect-ratio:16/10;background:#eee;"></div>
              <?php endif; ?>
            </figure>

            <?php if ($txt) : ?>
              <h3 class="ls-case-showcase__title"><?= esc_html($txt); ?></h3>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="ls-case-showcase__cta ls-row">
      <?php if ($cta_text && $cta_link) : ?>
        <a href="<?= esc_url($cta_link); ?>" class="btn btn-secondary">
          <?= esc_html($cta_text); ?>
        </a>
      <?php endif; ?>

      <a href="/cases" class="btn btn-secondary">
        Bekijk alle cases
      </a>
    </div>

  </div>
</section>


