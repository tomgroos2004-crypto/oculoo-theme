<?php
defined('ABSPATH') || exit;

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();

    $hero      = get_field('blog_hero');
    $intro     = get_field('blog_intro');
    $content   = get_field('blog_content');
    $author    = get_field('blog_author');
    $read_time = get_field('blog_read_time');
    $related   = get_field('blog_related');
    $cta       = get_field('blog_cta');
    $cats      = get_the_terms(get_the_ID(), 'blog_categorie');
?>

<main id="primary" class="site-main ls-blog-single">

  <!-- ====================================================
       HERO
  ==================================================== -->

  <section class="ls-blog-hero section-md">
    <?php if (!empty($hero['url'])) : ?>
      <div class="ls-blog-hero__image">
        <img
          src="<?= esc_url($hero['sizes']['large'] ?? $hero['url']); ?>"
          alt="<?= esc_attr($hero['alt'] ?? get_the_title()); ?>"
          loading="eager"
          decoding="async"
        >
      </div>
    <?php endif; ?>

    <div class="ls-container ls-container--narrow">

      <nav class="ls-blog-hero__breadcrumb" aria-label="Kruimelpad">
        <a href="<?= esc_url(home_url('/')); ?>">Home</a>
        <span aria-hidden="true">/</span>
        <a href="<?= esc_url(get_post_type_archive_link('blog')); ?>">Blog</a>
        <span aria-hidden="true">/</span>
        <span><?php the_title(); ?></span>
      </nav>

      <?php if (!empty($cats) && !is_wp_error($cats)) : ?>
        <p class="ls-blog-hero__cat">
          <?= esc_html($cats[0]->name); ?>
        </p>
      <?php endif; ?>

      <h1 class="ls-blog-hero__title"><?php the_title(); ?></h1>

      <div class="ls-blog-hero__meta">
        <?php if (!empty($author)) : ?>
          <span class="ls-blog-hero__author"><?= esc_html($author); ?></span>
        <?php endif; ?>
        <?php if (!empty($read_time)) : ?>
          <span class="ls-blog-hero__read-time"><?= (int) $read_time; ?> min leestijd</span>
        <?php endif; ?>
        <time class="ls-blog-hero__date" datetime="<?= get_the_date('c'); ?>">
          <?= get_the_date('j F Y'); ?>
        </time>
      </div>

    </div>
  </section>

  <!-- ====================================================
       INTRO
  ==================================================== -->

  <?php if (!empty($intro)) : ?>
    <section class="ls-blog-intro section-sm">
      <div class="ls-container ls-container--narrow">
        <p class="ls-blog-intro__text lead"><?= wp_kses_post($intro); ?></p>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       INHOUD
  ==================================================== -->

  <?php if (!empty($content)) : ?>
    <section class="ls-blog-content section-sm">
      <div class="ls-container ls-container--narrow">
        <div class="ls-blog-content__inner">
          <?= wp_kses_post($content); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       CTA
  ==================================================== -->

  <?php if (!empty($cta['title']) || !empty($cta['text'])) : ?>
    <section class="ls-blog-cta section-sm">
      <div class="ls-container ls-container--narrow">
        <div class="ls-blog-cta__box">
          <?php if (!empty($cta['title'])) : ?>
            <h2 class="ls-blog-cta__title"><?= esc_html($cta['title']); ?></h2>
          <?php endif; ?>
          <?php if (!empty($cta['text'])) : ?>
            <p class="ls-blog-cta__text"><?= esc_html($cta['text']); ?></p>
          <?php endif; ?>
          <?php if (!empty($cta['btn_url']) && !empty($cta['btn_text'])) : ?>
            <a class="ls-blog-cta__btn btn btn--primary" href="<?= esc_url($cta['btn_url']); ?>">
              <?= esc_html($cta['btn_text']); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       GERELATEERDE BLOGS
  ==================================================== -->

  <?php if (!empty($related)) : ?>
    <section class="ls-blog-related section-md">
      <div class="ls-container">
        <h2 class="ls-blog-related__heading">Gerelateerde blogs</h2>
        <div class="ls-blog-grid">
          <?php foreach ($related as $rel_post) :
            $rel_hero  = get_field('blog_hero', $rel_post->ID);
            $rel_intro = get_field('blog_intro', $rel_post->ID);
            $rel_cats  = get_the_terms($rel_post->ID, 'blog_categorie');
            $rel_time  = get_field('blog_read_time', $rel_post->ID);
          ?>
            <a href="<?= esc_url(get_permalink($rel_post->ID)); ?>" class="ls-blog-card">
              <div class="ls-blog-card__media">
                <?php if (!empty($rel_hero['sizes']['medium_large'])) : ?>
                  <img src="<?= esc_url($rel_hero['sizes']['medium_large']); ?>" alt="<?= esc_attr($rel_hero['alt'] ?? $rel_post->post_title); ?>" loading="lazy" decoding="async">
                <?php elseif (has_post_thumbnail($rel_post->ID)) : ?>
                  <?= get_the_post_thumbnail($rel_post->ID, 'medium_large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
                <?php else : ?>
                  <div class="ls-blog-card__no-image"></div>
                <?php endif; ?>
              </div>
              <div class="ls-blog-card__body">
                <?php if (!empty($rel_cats) && !is_wp_error($rel_cats)) : ?>
                  <span class="ls-blog-card__cat"><?= esc_html($rel_cats[0]->name); ?></span>
                <?php endif; ?>
                <h3 class="ls-blog-card__title"><?= esc_html($rel_post->post_title); ?></h3>
                <?php if (!empty($rel_intro)) : ?>
                  <p class="ls-blog-card__excerpt"><?= esc_html(wp_trim_words($rel_intro, 20)); ?></p>
                <?php endif; ?>
                <div class="ls-blog-card__footer">
                  <?php if (!empty($rel_time)) : ?>
                    <span class="ls-blog-card__read-time"><?= (int) $rel_time; ?> min</span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php
  endwhile;
endif;

get_footer();
