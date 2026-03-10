<?php
if (!defined('ABSPATH')) exit;

$enabled = get_field('hero_enabled');
if (!$enabled) return;

$h1     = get_field('hero_h1');
$image  = get_field('hero_image');
$title  = get_field('hero_title_right');
$text   = get_field('hero_text');
$date   = get_field('hero_date');

$image_url = is_array($image) ? $image['url'] : $image;
?>

<section class="oculoo-hero">

<?php if($image_url): ?>
<div class="hero-image">
<img src="<?= esc_url($image_url); ?>" alt="">
</div>
<?php endif; ?>

<div class="ls-container hero-container">

<?php if($h1): ?>
<div class="hero-bg-word">
<?= esc_html($h1); ?>
</div>
<?php endif; ?>

<div class="hero-content">

<?php if($title): ?>
<h2 class="hero-title">
<?= esc_html($title); ?>
</h2>
<?php endif; ?>

<?php if($date): ?>
<div class="hero-date">
<?= esc_html(date_i18n('d F Y', strtotime($date))); ?>
</div>
<?php endif; ?>

<?php if($text): ?>
<p class="hero-text">
<?= esc_html($text); ?>
</p>
<?php endif; ?>

</div>

</div>

</section>
