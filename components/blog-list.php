<?php
defined('ABSPATH') || exit;

/**
 * Verwachte input via $settings (LS_Base_Widget contract)
 */
$posts = $settings['posts']   ?? [];
$title = $settings['title']   ?? '';
$intro = $settings['intro']   ?? '';
$cols  = $settings['columns'] ?? '3';
$ignore_slugs = ['alle-blogs', 'kennis'];




if (empty($posts)) return;
?>

<section class="ls-blog-list">
  <div class="ls-container">

    <?php if ($title || $intro) : ?>
      <header class="ls-blog-list-header ls-stack">
        <?php if ($title) : ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($intro) : ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="ls-cards ls-cards--cols-<?= esc_attr($cols); ?>">
      <div class="ls-cards-grid">

        <?php foreach ($posts as $post) : setup_postdata($post); ?>

          <?php
          $thumb = get_the_post_thumbnail_url($post, 'large');
          $style = $thumb ? 'style="--card-bg:url(' . esc_url($thumb) . ')"' : '';
          $class = 'ls-card ls-blog-card' . ($thumb ? ' has-bg' : '');
          ?>

          <article class="<?= esc_attr($class); ?>" <?= $style; ?>>

          <?php
$cat_name = '';

$categories = get_the_category($post);

if (!empty($categories)) {
  foreach ($categories as $c) {
    if (!in_array($c->slug, $ignore_slugs, true)) {
      $cat_name = $c->name;
      break;
    }
  }
}
?>



            <?php if ($cat_name) : ?>
              <span class="ls-blog-meta">
                <?= esc_html($cat_name); ?>
              </span>
            <?php endif; ?>

            <h3 class="ls-card-title">
              <?= esc_html(get_the_title($post)); ?>
            </h3>

            <p class="ls-card-text">
              <?= esc_html(wp_trim_words(get_the_excerpt($post), 26)); ?>
            </p>

            <a class="btn btn-secondary" href="<?= esc_url(get_permalink($post)); ?>">
              Lees artikel
            </a>

          </article>

        <?php endforeach; wp_reset_postdata(); ?>

      </div>
    </div>

  </div>
</section>
