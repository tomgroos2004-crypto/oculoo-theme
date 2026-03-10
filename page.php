<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">

  <?php while (have_posts()) : the_post(); ?>

    <?php
    // 1. Hero
    get_template_part('template-parts/hero');
    ?>

    <?php
    // 2. ACF Flexible Content
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

    <?php
    // 3. Elementor fallback (tijdelijk)
    the_content();
    ?>

  <?php endwhile; ?>

</main>

<?php get_footer(); ?>
