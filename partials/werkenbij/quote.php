<?php
$quote = new WP_Query([
  'post_type'      => 'testimonial',
  'posts_per_page' => 1,
  'orderby'        => 'rand',
]);

if ($quote->have_posts()) :
  $quote->the_post();
?>
<section class="ls-section ls-section--soft">
  <div class="ls-container ls-container--narrow">
    <blockquote class="ls-quote">
      <p class="lead">"<?php the_content(); ?>"</p>
      <footer><strong><?php the_title(); ?></strong></footer>
    </blockquote>
  </div>
</section>
<?php
wp_reset_postdata();
endif;
