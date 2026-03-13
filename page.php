<?php
defined('ABSPATH') || exit;

get_header();

// WooCommerce-pagina's (cart, checkout, my account, etc.) hebben eigen templates
// via the_content() — geef ze een simpele wrapper en stap uit.
if (function_exists('is_woocommerce') && (is_cart() || is_checkout() || is_account_page())) :
?>
<main id="primary" class="site-main ls-wc-page">
  <div class="ls-container section-md">
    <?php while (have_posts()) : the_post(); ?>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</main>
<?php
  get_footer();
  return;
endif;
?>

<main id="primary" class="site-main">

  <?php while (have_posts()) : the_post(); ?>

    <?php
    // 1. Hero
    get_template_part('template-parts/hero');
    ?>

    <?php
    // 2. Uitgelichte producten (direct na hero)
    if (is_front_page() && get_field('show_featured_products')) {
      get_template_part('template-parts/sections/featured-products');
    }
    ?>

    <?php
    // 3. ACF Flexible Content
    if (have_rows('page_sections')) :

      while (have_rows('page_sections')) : the_row();

        if (get_row_layout() === 'content') {
          get_template_part('template-parts/sections/content');
        }

        if (get_row_layout() === 'partners_slider') {
          get_template_part('template-parts/sections/partners-slider');
        }

        if (get_row_layout() === 'tabs_met_afbeeldingen_en_tekst') {
          get_template_part('template-parts/sections/case-breakdown');
        }

        if (get_row_layout() === 'testimonials') {
          get_template_part('template-parts/sections/testimonials');
        }

      endwhile;

    endif;
    ?>



  <?php
    // 1. Hero
    get_template_part('template-parts/sections/cta');
    ?>

  <?php endwhile; ?>

</main>

<?php get_footer(); ?>
