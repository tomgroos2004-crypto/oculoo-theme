<?php
// Eventsuper CTA – simpel & vast
?>

<section class="es-cta section-md">

  <div class="ls-container ls-container--narrow">

    <div class="es-cta-inner">

      <?php if (!empty($title)) : ?>
        <h2 class="h2 es-cta-title">
          <?= esc_html($title); ?>
        </h2>
      <?php endif; ?>

      <?php if (!empty($text)) : ?>
        <p class="lead es-cta-text">
          <?= esc_html($text); ?>
        </p>
      <?php endif; ?>

      <?php if (!empty($button) && !empty($url)) : ?>
        <div class="es-cta-action">
          <a href="<?= esc_url($url); ?>" class="btn btn-primary">
            <?= esc_html($button); ?>
          </a>
        </div>
      <?php endif; ?>

    </div>

  </div>

</section>
