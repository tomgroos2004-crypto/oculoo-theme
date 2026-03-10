<section class="ls-hero ls-hero--werkenbij">
  <div class="ls-container">
    <h1 class="h1"><?php the_title(); ?></h1>

    <?php if (has_excerpt()) : ?>
      <p class="lead"><?php the_excerpt(); ?></p>
    <?php endif; ?>
  </div>
</section>
