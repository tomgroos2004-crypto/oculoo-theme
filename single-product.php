<?php
defined('ABSPATH') || exit;

if (!function_exists('wc_get_product')) {
  get_header();
  while (have_posts()) : the_post();
    the_content();
  endwhile;
  get_footer();
  return;
}

get_header();
?>

<main id="primary" class="site-main ls-product-page">
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      $wc_product       = wc_get_product(get_the_ID());
      if (!$wc_product) continue;

      $gallery_ids      = $wc_product->get_gallery_image_ids();
      $sku              = $wc_product->get_sku();
      $categories       = wc_get_product_category_list($wc_product->get_id(), ', ');
      $short_desc       = $wc_product->get_short_description();
      $price_html       = $wc_product->get_price_html();
      $in_stock         = $wc_product->is_in_stock();
      $on_sale          = $wc_product->is_on_sale();

      $product_intro    = get_field('product_intro');
      $product_usps     = get_field('product_usps');
      $product_cta      = get_field('product_cta_link');

      $GLOBALS['product'] = $wc_product;
  ?>

  <!-- ====================================================
       HERO
  ==================================================== -->

  <section class="ls-ph section-md">
    <div class="ls-container">

      <nav class="ls-ph__breadcrumb" aria-label="Kruimelpad">
        <?php
        if (function_exists('woocommerce_breadcrumb')) {
          woocommerce_breadcrumb([
            'delimiter'   => '<span aria-hidden="true"> / </span>',
            'wrap_before' => '<ol class="ls-breadcrumb">',
            'wrap_after'  => '</ol>',
            'before'      => '<li>',
            'after'       => '</li>',
          ]);
        }
        ?>
      </nav>

      <div class="ls-ph__grid">

        <!-- Visueel: hoofd + galerij -->
        <div class="ls-ph__visual">

          <?php if ($on_sale) : ?>
            <span class="ls-ph__sale-badge">Sale</span>
          <?php endif; ?>

          <div class="ls-ph__main-image">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', [
                'loading'  => 'eager',
                'decoding' => 'async',
                'class'    => 'ls-ph__img',
              ]); ?>
            <?php else : ?>
              <div class="ls-ph__no-image"></div>
            <?php endif; ?>
          </div>

          <?php if (!empty($gallery_ids)) : ?>
            <div class="ls-ph__thumbs">
              <?php foreach (array_slice($gallery_ids, 0, 4) as $gid) : ?>
                <div class="ls-ph__thumb">
                  <?= wp_get_attachment_image($gid, 'thumbnail', false, [
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                  ]); ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        </div>

        <!-- Inhoud: titel, prijs, USP's, acties -->
        <div class="ls-ph__content">

          <?php if (!empty($categories)) : ?>
            <p class="ls-ph__cat"><?= wp_kses_post($categories); ?></p>
          <?php endif; ?>

          <h1 class="ls-ph__title"><?php the_title(); ?></h1>

          <?php if (!empty($price_html)) : ?>
            <div class="ls-ph__price"><?= wp_kses_post($price_html); ?></div>
          <?php endif; ?>

          <div class="ls-ph__divider" aria-hidden="true"></div>

          <?php if (!empty($product_intro)) : ?>
            <p class="ls-ph__intro lead"><?= esc_html($product_intro); ?></p>
          <?php elseif (!empty($short_desc)) : ?>
            <div class="ls-ph__intro lead"><?= wp_kses_post($short_desc); ?></div>
          <?php endif; ?>

          <?php if (!empty($product_usps) && is_array($product_usps)) : ?>
            <ul class="ls-ph__usps">
              <?php foreach ($product_usps as $usp) :
                $txt = $usp['text'] ?? '';
                if (!$txt) continue;
              ?>
                <li class="ls-ph__usp">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M3 8.5l3.5 3.5 6.5-7" stroke="#2E6DA4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <?= esc_html($txt); ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <div class="ls-ph__stock <?= $in_stock ? 'is-in' : 'is-out'; ?>">
            <span class="ls-ph__stock-dot"></span>
            <?= $in_stock ? 'Op voorraad — direct leverbaar' : 'Tijdelijk niet op voorraad'; ?>
          </div>

          <div class="ls-ph__actions">
            <?php
            if (function_exists('woocommerce_template_single_add_to_cart')) {
              woocommerce_template_single_add_to_cart();
            }
            ?>
            <?php if (!empty($product_cta['url'])) : ?>
              <a class="ls-ph__secondary-cta" href="<?= esc_url($product_cta['url']); ?>" target="<?= esc_attr($product_cta['target'] ?: '_self'); ?>">
                <?= esc_html($product_cta['title'] ?: 'Meer informatie'); ?>
              </a>
            <?php endif; ?>
          </div>

          <?php if (!empty($sku)) : ?>
            <p class="ls-ph__sku">Artikelnummer: <span><?= esc_html($sku); ?></span></p>
          <?php endif; ?>

        </div>

      </div>
    </div>
  </section>

  <!-- ====================================================
       INHOUD
  ==================================================== -->

  <?php $content = get_the_content(); ?>
  <?php if (!empty(trim(strip_tags($content)))) : ?>
    <section class="ls-product-content section-sm">
      <div class="ls-container ls-container--narrow">
        <div class="ls-product-content__inner">
          <?= apply_filters('the_content', $content); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       GERELATEERDE PRODUCTEN
  ==================================================== -->

  <section class="ls-product-related section-sm">
    <div class="ls-container">
      <?php
      if (function_exists('woocommerce_output_related_products')) {
        woocommerce_output_related_products([
          'posts_per_page' => 2,
          'columns'        => 2,
        ]);
      }
      ?>
    </div>
  </section>

    <?php endwhile;
  endif; ?>

</main>

<?php get_footer(); ?>
