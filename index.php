<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">

  <?php if (have_posts()) : ?>

    <section class="ls-section section-md">
      <div class="ls-container ls-container--narrow">

        <?php while (have_posts()) : the_post(); ?>

          <article <?php post_class('ls-article'); ?>>

            <header class="ls-article-header">
              <h2 class="h2">
                <a href="<?php the_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </h2>
            </header>

            <div class="ls-article-excerpt">
              <?php the_excerpt(); ?>
            </div>

          </article>

        <?php endwhile; ?>

        <div class="ls-pagination">
          <?php
          the_posts_pagination([
            'prev_text' => 'Vorige',
            'next_text' => 'Volgende',
          ]);
          ?>
        </div>

      </div>
    </section>

  <?php else : ?>

    <section class="ls-section section-md">
      <div class="ls-container ls-container--narrow">
        <p>Geen berichten gevonden.</p>
      </div>
    </section>

  <?php endif; ?>

</main>

<?php get_footer(); ?>