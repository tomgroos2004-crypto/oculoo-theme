<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main ls-shop-page">

  <!-- Shop hero -->
  <section class="ls-shop-hero section-sm">
    <div class="ls-container">
      <p class="ls-shop-hero__eyebrow">Shop</p>
      <h1 class="ls-shop-hero__title"><?php woocommerce_page_title(); ?></h1>
      <p class="ls-shop-hero__sub lead">Kies je product en stel eenvoudig samen wat je nodig hebt voor jouw event.</p>
    </div>
  </section>

  <!-- Product grid -->
  <section class="ls-shop-grid section-sm">
    <div class="ls-container">

      <?php if (woocommerce_product_loop()) : ?>

        <div class="ls-shop-grid__toolbar">
          <div class="ls-shop-grid__count"><?php woocommerce_result_count(); ?></div>
          <div class="ls-shop-grid__sort"><?php woocommerce_catalog_ordering(); ?></div>
        </div>

        <?php woocommerce_product_loop_start(); ?>
          <?php while (have_posts()) : the_post(); ?>
            <?php wc_get_template_part('content', 'product'); ?>
          <?php endwhile; ?>
        <?php woocommerce_product_loop_end(); ?>

        <div class="ls-shop-grid__pagination">
          <?php woocommerce_pagination(); ?>
        </div>

      <?php else : ?>
        <div class="ls-shop-empty">
          <p>Er zijn momenteel geen producten beschikbaar.</p>
        </div>
      <?php endif; ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
