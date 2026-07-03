<?php
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main">

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('template-parts/sections/hero-home'); ?>
        <?php get_template_part('template-parts/sections/partners-slider'); ?>

        <?php if (get_field('show_featured_products')) : ?>
            <?php get_template_part('template-parts/sections/featured-products'); ?>
        <?php endif; ?>

        <?php get_template_part('template-parts/sections/problem'); ?>
        <?php get_template_part('template-parts/sections/how'); ?>

        <?php if (have_rows('page_sections')) : ?>
            <?php while (have_rows('page_sections')) : the_row(); ?>

                <?php if (get_row_layout() === 'content') : ?>
                    <?php get_template_part('template-parts/sections/content'); ?>
                <?php endif; ?>

                <?php if (get_row_layout() === 'tabs_met_afbeeldingen_en_tekst') : ?>
                    <?php get_template_part('template-parts/sections/case-breakdown'); ?>
                <?php endif; ?>

                <?php if (get_row_layout() === 'testimonials') : ?>
                    <?php get_template_part('template-parts/sections/testimonials'); ?>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

        <?php get_template_part('template-parts/sections/cta'); ?>

    <?php endwhile; ?>
<?php endif; ?>

</main>

<?php
get_footer();