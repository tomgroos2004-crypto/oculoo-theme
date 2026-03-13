<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
  return;
}

$cats     = get_the_terms(get_the_ID(), 'product_cat');
$cat_name = (!empty($cats) && !is_wp_error($cats)) ? $cats[0]->name : '';
?>

<li <?php wc_product_class('ls-sc', $product); ?>>

  <a class="ls-sc__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">

    <?php if ($product->is_on_sale()) : ?>
      <span class="ls-sc__sale">Sale</span>
    <?php endif; ?>

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

    <?php if (!empty($cat_name)) : ?>
      <p class="ls-sc__cat"><?= esc_html($cat_name); ?></p>
    <?php endif; ?>

    <h2 class="ls-sc__name woocommerce-loop-product__title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>

    <?php if (get_the_excerpt()) : ?>
      <p class="ls-sc__excerpt"><?= esc_html(wp_trim_words(get_the_excerpt(), 16)); ?></p>
    <?php endif; ?>

    <div class="ls-sc__footer">

      <div class="ls-sc__price-wrap">
        <div class="ls-sc__price"><?= wp_kses_post($product->get_price_html()); ?></div>
        <div class="ls-sc__stock <?= $product->is_in_stock() ? 'is-in' : 'is-out'; ?>">
          <span class="ls-sc__dot"></span>
          <?= $product->is_in_stock() ? 'Op voorraad' : 'Uitverkocht'; ?>
        </div>
      </div>

      <a class="ls-sc__cta" href="<?php the_permalink(); ?>">
        Bekijk
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>

    </div>

  </div>

</li>
