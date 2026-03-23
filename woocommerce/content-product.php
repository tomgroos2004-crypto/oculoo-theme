<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
  return;
}

$intro_field = get_field('product_intro', get_the_ID());
?>

<li <?php wc_product_class('ls-sc', $product); ?>>

  <a class="ls-sc__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
    <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('woocommerce_thumbnail', [
        'loading'  => 'lazy',
        'decoding' => 'async',
      ]); ?>
    <?php else : ?>
      <div class="ls-sc__no-image"></div>
    <?php endif; ?>

  </a>

  <div class="ls-sc__body">
    <h2 class="ls-sc__name woocommerce-loop-product__title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>

    <?php if (!empty($intro_field)) : ?>
      <p class="ls-sc__excerpt"><?= esc_html(wp_trim_words($intro_field, 14)); ?></p>
    <?php elseif (get_the_excerpt()) : ?>
      <p class="ls-sc__excerpt"><?= esc_html(wp_trim_words(get_the_excerpt(), 14)); ?></p>
    <?php endif; ?>

    <div class="ls-sc__footer">

      <div class="ls-sc__price-wrap">
        <div class="ls-sc__price-label">Consumentenprijs</div>
        <div class="ls-sc__price"><?= wp_kses_post($product->get_price_html()); ?></div>
      </div>

      <a class="ls-sc__cta" href="<?php the_permalink(); ?>">
        Bestel nu
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>

    </div>

  </div>

</li>
