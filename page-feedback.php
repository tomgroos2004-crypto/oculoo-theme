<?php
/**
 * Template Name: Feedback formulier
 *
 * Wordt automatisch gebruikt voor de pagina met slug "feedback".
 * Je kunt ook handmatig kiezen via Pagina-attributen → Sjabloon.
 */
defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main feedback-page">

  <?php
  while (have_posts()) :
    the_post();
    get_template_part('template-parts/sections/feedback-form');
  endwhile;
  ?>

</main>

<?php get_footer(); ?>
