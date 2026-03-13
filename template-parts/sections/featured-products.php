<?php
defined('ABSPATH') || exit;

if (!function_exists('wc_get_product')) {
  return;
}

$title = get_field('featured_products_title') ?: 'Onze producten';
$intro = get_field('featured_products_intro');
$items = get_field('featured_products_items');

if (empty($items) || !is_array($items)) {
  return;
}
?>

<section class="ls-featured-products section-md">
  <div class="ls-container">

    <header class="ls-featured-products__header">
      <p class="ls-featured-products__eyebrow">Shop</p>
      <h2 class="ls-featured-products__title"><?= esc_html($title); ?></h2>
      <?php if (!empty($intro)) : ?>
        <p class="ls-featured-products__intro"><?= esc_html($intro); ?></p>
      <?php endif; ?>
    </header>

    <div class="ls-featured-products__grid">
      <?php foreach ($items as $item) :
        $product_id  = is_object($item) ? (int) $item->ID : (int) $item;
        if (!$product_id) continue;

        $wc_product = wc_get_product($product_id);
        if (!$wc_product) continue;

        $link        = get_permalink($product_id);
        $name        = get_the_title($product_id);
        $excerpt     = get_the_excerpt($product_id);
        $intro_field = get_field('product_intro', $product_id);
        if (empty($excerpt) && !empty($intro_field)) $excerpt = $intro_field;
        $price_html  = $wc_product->get_price_html();
        $on_sale     = $wc_product->is_on_sale();
        $in_stock    = $wc_product->is_in_stock();
        $cats        = get_the_terms($product_id, 'product_cat');
        $cat_name    = (!empty($cats) && !is_wp_error($cats)) ? $cats[0]->name : '';
      ?>

        <article class="ls-fp-card">

          <a class="ls-fp-card__media" href="<?= esc_url($link); ?>" tabindex="-1" aria-hidden="true">
            <?php if ($on_sale) : ?>
              <span class="ls-fp-card__sale">Sale</span>
            <?php endif; ?>
            <?php if (has_post_thumbnail($product_id)) : ?>
              <?= get_the_post_thumbnail($product_id, 'large', [
                'loading'  => 'lazy',
                'decoding' => 'async',
                'alt'      => esc_attr($name),
              ]); ?>
            <?php else : ?>
              <div class="ls-fp-card__no-image"></div>
            <?php endif; ?>
          </a>

          <div class="ls-fp-card__body">

            <?php if (!empty($cat_name)) : ?>
              <p class="ls-fp-card__cat"><?= esc_html($cat_name); ?></p>
            <?php endif; ?>

            <h3 class="ls-fp-card__name">
              <a href="<?= esc_url($link); ?>"><?= esc_html($name); ?></a>
            </h3>

            <?php if (!empty($excerpt)) : ?>
              <p class="ls-fp-card__excerpt"><?= esc_html(wp_trim_words($excerpt, 20)); ?></p>
            <?php endif; ?>

            <div class="ls-fp-card__footer">

              <div class="ls-fp-card__meta">
                <?php if (!empty($price_html)) : ?>
                  <div class="ls-fp-card__price"><?= wp_kses_post($price_html); ?></div>
                <?php endif; ?>
                <div class="ls-fp-card__stock <?= $in_stock ? 'is-in' : 'is-out'; ?>">
                  <span class="ls-fp-card__dot"></span>
                  <?= $in_stock ? 'Op voorraad' : 'Niet op voorraad'; ?>
                </div>
              </div>

              <a class="ls-fp-card__cta" href="<?= esc_url($link); ?>">
                Bekijk product
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>

            </div>

          </div>

        </article>

      <?php endforeach; ?>
    </div>

    <div class="ls-featured-products__footer">
      <a class="ls-featured-products__all" href="<?= esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>">
        Bekijk alle producten
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>

  </div>
</section>
