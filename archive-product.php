<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main ls-shop-page">

  <!-- Shop hero -->
  <section class="ls-shop-hero section-sm">
    <div class="ls-container">
      <p class="ls-shop-hero__eyebrow">Producten</p>
      <h1 class="ls-shop-hero__title">Onze oplossing</h1>
      <p class="ls-shop-hero__sub">Verkrijgbaar in 2 modellen. Op 90% van alle type oogdruppels toepasbaar.</p>
    </div>
  </section>

  <!-- Product grid -->
  <section class="ls-shop-grid section-sm">
    <div class="ls-container">

      <?php if (woocommerce_product_loop()) : ?>

        <?php woocommerce_product_loop_start(); ?>
          <?php while (have_posts()) : the_post(); ?>
            <?php wc_get_template_part('content', 'product'); ?>
          <?php endwhile; ?>
        <?php woocommerce_product_loop_end(); ?>

      <?php else : ?>
        <div class="ls-shop-empty">
          <p>Er zijn momenteel geen producten beschikbaar.</p>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <?php get_template_part('template-parts/sections/cta'); ?>

</main>

<?php get_footer(); ?>
