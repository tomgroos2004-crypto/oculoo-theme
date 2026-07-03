<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main ls-blog-archive ls-oz-archive">

  <!-- Hero -->
  <section class="ls-blog-archive-hero section-md">
    <div class="ls-container">
      <p class="ls-blog-archive-hero__eyebrow">Onderzoek</p>
      <h1 class="ls-blog-archive-hero__title">Onderzoeken</h1>
      <p class="ls-blog-archive-hero__sub lead">Verdiepende onderzoeken en analyses van Oculoo.</p>
    </div>
  </section>

  <!-- Filter + Grid -->
  <section class="ls-blog-archive-grid section-sm">
    <div class="ls-container">

      <?php
      $terms = get_terms([
        'taxonomy'   => 'onderzoek_categorie',
        'hide_empty' => true,
      ]);
      if (!empty($terms) && !is_wp_error($terms)) :
        $current_term = get_queried_object();
      ?>
        <div class="ls-blog-archive-grid__filter">
          <a class="ls-blog-filter__tag <?= !is_tax('onderzoek_categorie') ? 'is-active' : ''; ?>" href="<?= esc_url(get_post_type_archive_link('onderzoek')); ?>">Alles</a>
          <?php foreach ($terms as $term) : ?>
            <a class="ls-blog-filter__tag <?= (isset($current_term->term_id) && $current_term->term_id === $term->term_id) ? 'is-active' : ''; ?>" href="<?= esc_url(get_term_link($term)); ?>">
              <?= esc_html($term->name); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (have_posts()) : ?>
        <div class="ls-blog-grid">
          <?php while (have_posts()) : the_post();
            $hero      = get_field('onderzoek_hero');
            $intro     = get_field('onderzoek_intro');
            $author    = get_field('onderzoek_author');
            $read_time = get_field('onderzoek_read_time');
            $date      = get_field('onderzoek_date');
            $pdf       = get_field('onderzoek_pdf');
            $cats      = get_the_terms(get_the_ID(), 'onderzoek_categorie');
          ?>
            <a href="<?= esc_url(get_permalink()); ?>" class="ls-blog-card">
              <div class="ls-blog-card__media">
                <?php if (!empty($hero['sizes']['medium_large'])) : ?>
                  <img src="<?= esc_url($hero['sizes']['medium_large']); ?>" alt="<?= esc_attr($hero['alt'] ?? get_the_title()); ?>" loading="lazy" decoding="async">
                <?php elseif (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
                <?php else : ?>
                  <div class="ls-blog-card__no-image"></div>
                <?php endif; ?>
              </div>
              <div class="ls-blog-card__body">
                <?php if (!empty($cats) && !is_wp_error($cats)) : ?>
                  <span class="ls-blog-card__cat"><?= esc_html($cats[0]->name); ?></span>
                <?php endif; ?>
                <h2 class="ls-blog-card__title"><?php the_title(); ?></h2>
                <?php if (!empty($intro)) : ?>
                  <p class="ls-blog-card__excerpt"><?= esc_html(wp_trim_words($intro, 20)); ?></p>
                <?php endif; ?>
                <div class="ls-blog-card__footer">
                  <?php if (!empty($date)) : ?>
                    <span class="ls-blog-card__date"><?= esc_html($date); ?></span>
                  <?php endif; ?>
                  <?php if (!empty($author)) : ?>
                    <span class="ls-blog-card__author"><?= esc_html($author); ?></span>
                  <?php endif; ?>
                  <?php if (!empty($pdf)) : ?>
                    <span class="ls-blog-card__pdf-badge">PDF</span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endwhile; ?>
        </div>

        <div class="ls-blog-archive-grid__pagination">
          <?php
          the_posts_pagination([
            'mid_size'  => 1,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
          ]);
          ?>
        </div>

      <?php else : ?>
        <div class="ls-blog-empty">
          <p>Er zijn nog geen onderzoeken gepubliceerd.</p>
        </div>
      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
