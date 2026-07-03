<?php
if (!defined('ABSPATH')) exit;

$popup_enabled = get_field('oculoo_popup_enabled', 'option');
if (!$popup_enabled) return;

$popup_title     = get_field('oculoo_popup_title', 'option');
$popup_text      = get_field('oculoo_popup_text', 'option');
$popup_image     = get_field('oculoo_popup_image', 'option');
$popup_cta_text  = get_field('oculoo_popup_cta_text', 'option');
$popup_cta_url   = get_field('oculoo_popup_cta_url', 'option');
$popup_trigger   = get_field('oculoo_popup_trigger', 'option') ?: 'delay';
$popup_delay     = get_field('oculoo_popup_delay', 'option') ?: 3;
$popup_scroll    = get_field('oculoo_popup_scroll', 'option') ?: 50;
$popup_frequency = get_field('oculoo_popup_frequency', 'option') ?: 'once';

$has_image = !empty($popup_image) && !empty($popup_image['url']);
?>

<div
  class="oculoo-popup"
  id="oculoo-popup"
  role="dialog"
  aria-modal="true"
  aria-label="<?= esc_attr($popup_title ?: 'Popup'); ?>"
  data-trigger="<?= esc_attr($popup_trigger); ?>"
  data-delay="<?= esc_attr($popup_delay); ?>"
  data-scroll="<?= esc_attr($popup_scroll); ?>"
  data-frequency="<?= esc_attr($popup_frequency); ?>"
  hidden
>
  <div class="oculoo-popup__overlay"></div>

  <div class="oculoo-popup__modal<?= $has_image ? ' oculoo-popup__modal--has-image' : ''; ?>">

    <button class="oculoo-popup__close" type="button" aria-label="Sluiten">
      <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false">
        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <?php if ($has_image) : ?>
      <div class="oculoo-popup__image">
        <img
          src="<?= esc_url($popup_image['url']); ?>"
          alt="<?= esc_attr($popup_image['alt'] ?? ''); ?>"
          loading="lazy"
        >
      </div>
    <?php endif; ?>

    <div class="oculoo-popup__content">
      <?php if ($popup_title) : ?>
        <h2 class="oculoo-popup__title"><?= esc_html($popup_title); ?></h2>
      <?php endif; ?>

      <?php if ($popup_text) : ?>
        <p class="oculoo-popup__text"><?= nl2br(esc_html($popup_text)); ?></p>
      <?php endif; ?>

      <?php if ($popup_cta_text && $popup_cta_url) : ?>
        <a href="<?= esc_url($popup_cta_url); ?>" class="btn btn-primary oculoo-popup__cta" target="_blank" rel="noopener">
          <?= esc_html($popup_cta_text); ?>
        </a>
      <?php endif; ?>
    </div>

  </div>
</div>
