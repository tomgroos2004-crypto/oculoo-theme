<?php
/**
 * Template Name: Retour aanmelden
 *
 * Wordt automatisch gebruikt voor de pagina met slug "retour-aanmelden".
 */
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main retour-page-main">

  <?php
  while (have_posts()) :
    the_post();
    get_template_part('template-parts/sections/retour-form');
  endwhile;
  ?>

</main>

<?php get_footer(); ?>
