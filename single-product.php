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

      $short_desc       = $wc_product->get_short_description();
      $price_html       = $wc_product->get_price_html();
      $review_count     = (int) $wc_product->get_review_count();
      $average_rating   = (float) $wc_product->get_average_rating();

      $product_intro    = get_field('product_intro');
      $product_usps     = get_field('product_usps');
      $product_cta      = get_field('product_cta_link');
      $product_how_link = get_field('product_how_link');
      $product_price_note = get_field('product_price_note') ?: 'Incl. btw - Gratis verzending vanaf €25';
      $product_faqs     = get_field('product_faqs');
      $product_reviews  = get_field('product_reviews');
      $product_specs    = get_field('product_specs');
      $related_title    = get_field('product_related_title') ?: 'Mensen kochten ook';

      if (empty($product_cta) || !is_array($product_cta) || empty($product_cta['url'])) {
        $product_cta = [
          'title'  => 'Direct bestellen',
          'url'    => wc_get_checkout_url() . '?add-to-cart=' . $wc_product->get_id(),
          'target' => '_self',
        ];
      }

      if (empty($product_faqs) || !is_array($product_faqs)) {
        $product_faqs = [
          ['question' => 'Wat maakt Oculoo uniek?', 'answer' => 'Oculoo combineert richten en krachtloos knijpen in een handeling.'],
          ['question' => 'Voor wie is de Oculoo Minim?', 'answer' => 'Voor mensen met trillende handen, weinig kracht of slecht zicht.'],
          ['question' => 'Verzending & retour', 'answer' => 'Snelle levering en 30 dagen retourrecht.'],
        ];
      }

      if (empty($product_reviews) || !is_array($product_reviews)) {
        $product_reviews = [
          ['quote' => 'Eindelijk kan ik mijn oogdruppels zelf doen. Het werkt precies zoals beloofd.', 'name' => 'Truus van der Berg', 'role' => 'Gebruiker', 'stars' => 5],
          ['quote' => 'Mijn moeder doet het nu helemaal zelf. Een geweldig hulpmiddel.', 'name' => 'Pieter Jansen', 'role' => 'Familie van gebruiker', 'stars' => 5],
          ['quote' => 'Als apotheker beveel ik dit product vaak aan. Veel makkelijker dan alternatieven.', 'name' => 'Dr. Bakker', 'role' => 'Apotheker', 'stars' => 5],
        ];
      }

      if (empty($product_specs) || !is_array($product_specs)) {
        $product_specs = [
          ['label' => 'Model', 'value' => get_the_title()],
          ['label' => 'Compatibiliteit', 'value' => 'Vrijwel alle standaardflesjes'],
          ['label' => 'Hygiene', 'value' => '100% geen oogcontact'],
          ['label' => 'Materiaal', 'value' => 'Medisch-grade kunststof'],
          ['label' => 'Mechanisme', 'value' => 'Hefboom (krachtloos)'],
          ['label' => 'Gewicht', 'value' => 'Lichtgewicht'],
        ];
      }

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

        </div>

        <!-- Inhoud: titel, prijs, USP's, acties -->
        <div class="ls-ph__content">

          <p class="ls-ph__stock-pill is-in">dit is een pre sale - levering Q3</p>

          <h1 class="ls-ph__title"><?php the_title(); ?></h1>

          <?php if (!empty($product_intro)) : ?>
            <p class="ls-ph__intro lead"><?= esc_html($product_intro); ?></p>
          <?php elseif (!empty($short_desc)) : ?>
            <div class="ls-ph__intro lead"><?= wp_kses_post($short_desc); ?></div>
          <?php endif; ?>

          <?php if ($review_count > 0) : ?>
            <p class="ls-ph__rating"><?= esc_html(str_repeat('★', 5)); ?> <span><?= esc_html(number_format_i18n($average_rating, 1)); ?> - <?= esc_html($review_count); ?> beoordelingen</span></p>
          <?php endif; ?>

          <?php if (!empty($price_html)) : ?>
            <div class="ls-ph__price"><?= wp_kses_post($price_html); ?></div>
          <?php endif; ?>
          <p class="ls-ph__price-note"><?= esc_html($product_price_note); ?></p>

          <div class="ls-ph__divider" aria-hidden="true"></div>

          <div class="ls-ph__actions">
            <?php
            if (function_exists('woocommerce_template_single_add_to_cart')) {
              woocommerce_template_single_add_to_cart();
            }
            ?>
            <?php if (!empty($product_cta['url'])) : ?>
              <a class="ls-ph__secondary-cta" href="<?= esc_url($product_cta['url']); ?>" target="<?= esc_attr($product_cta['target'] ?: '_self'); ?>">
                <?= esc_html($product_cta['title'] ?: 'Direct bestellen'); ?>
              </a>
            <?php endif; ?>

            <?php
            $how_link_url = is_array($product_how_link) ? ($product_how_link['url'] ?? '') : '';
            $how_link_title = is_array($product_how_link) ? ($product_how_link['title'] ?? '') : '';
            $how_link_target = is_array($product_how_link) ? ($product_how_link['target'] ?? '_self') : '_self';

            if (empty($how_link_url)) {
              $how_link_url = home_url('/hoe-werkt-het/');
              $how_link_title = 'Hoe werkt het?';
              $how_link_target = '_self';
            }
            ?>
            <a class="ls-ph__how-link" href="<?= esc_url($how_link_url); ?>" target="<?= esc_attr($how_link_target); ?>">
              <?= esc_html($how_link_title ?: 'Hoe werkt het?'); ?>
            </a>
          </div>

          <?php if (!empty($product_usps) && is_array($product_usps)) : ?>
            <ul class="ls-ph__mini-usps">
              <?php foreach (array_slice($product_usps, 0, 2) as $usp) :
                $txt = $usp['text'] ?? '';
                if (!$txt) continue;
              ?>
                <li><?= esc_html($txt); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php if (!empty($product_faqs)) : ?>
            <div class="ls-ph__accordion" data-product-accordion>
              <?php foreach ($product_faqs as $i => $item) :
                $q = isset($item['question']) ? trim((string) $item['question']) : '';
                $a = isset($item['answer']) ? trim((string) $item['answer']) : '';
                if ($q === '' && $a === '') continue;
                $open = $i === 0;
              ?>
                <details class="ls-ph__acc-item" <?= $open ? 'open' : ''; ?>>
                  <summary><?= esc_html($q); ?></summary>
                  <?php if ($a !== '') : ?><p><?= esc_html($a); ?></p><?php endif; ?>
                </details>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

        </div>

      </div>
    </div>
  </section>

  <?php if (!empty($product_reviews) && is_array($product_reviews)) : ?>
    <section class="ls-product-reviews section-sm">
      <div class="ls-container">
        <p class="ls-product-reviews__eyebrow"><?= esc_html(get_field('product_reviews_eyebrow') ?: 'Beoordelingen'); ?></p>
        <h2 class="ls-product-reviews__title"><?= esc_html(get_field('product_reviews_title') ?: 'Wat gebruikers zeggen'); ?></h2>

        <div class="ls-product-reviews__grid">
          <?php foreach (array_slice($product_reviews, 0, 3) as $review) :
            $quote = isset($review['quote']) ? trim((string) $review['quote']) : '';
            $name  = isset($review['name']) ? trim((string) $review['name']) : '';
            $role  = isset($review['role']) ? trim((string) $review['role']) : '';
            $stars = isset($review['stars']) ? max(1, min(5, (int) $review['stars'])) : 5;
            if ($quote === '' && $name === '') continue;
          ?>
            <article class="ls-product-review-card">
              <p class="ls-product-review-card__stars"><?= esc_html(str_repeat('★', $stars)); ?></p>
              <?php if ($quote !== '') : ?><p class="ls-product-review-card__quote"><?= esc_html($quote); ?></p><?php endif; ?>
              <?php if ($name !== '') : ?><p class="ls-product-review-card__name"><?= esc_html($name); ?></p><?php endif; ?>
              <?php if ($role !== '') : ?><p class="ls-product-review-card__role"><?= esc_html($role); ?></p><?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php if (!empty($product_specs) && is_array($product_specs)) : ?>
    <section class="ls-product-specs section-sm">
      <div class="ls-container ls-container--narrow">
        <p class="ls-product-specs__eyebrow"><?= esc_html(get_field('product_specs_eyebrow') ?: 'Specificaties'); ?></p>
        <h2 class="ls-product-specs__title"><?= esc_html(get_field('product_specs_title') ?: (get_the_title() . ' - details')); ?></h2>

        <div class="ls-product-specs__table-wrap">
          <table class="ls-product-specs__table">
            <tbody>
              <?php foreach (array_slice($product_specs, 0, 12) as $spec) :
                $label = isset($spec['label']) ? trim((string) $spec['label']) : '';
                $value = isset($spec['value']) ? trim((string) $spec['value']) : '';
                if ($label === '' && $value === '') continue;
              ?>
                <tr>
                  <th><?= esc_html($label); ?></th>
                  <td><?= esc_html($value); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  <?php endif; ?>

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
      <h2 class="ls-product-related__title"><?= esc_html($related_title); ?></h2>

      <?php
      $related_ids = wc_get_related_products($wc_product->get_id(), 3);
      if (!empty($related_ids)) :
      ?>
        <div class="ls-related-grid">
          <?php foreach ($related_ids as $related_id) :
            $related_product = wc_get_product($related_id);
            if (!$related_product) continue;
          ?>
            <article class="ls-related-card">
              <a class="ls-related-card__img" href="<?= esc_url(get_permalink($related_id)); ?>">
                <?= get_the_post_thumbnail($related_id, 'medium_large'); ?>
              </a>
              <div class="ls-related-card__body">
                <h3><a href="<?= esc_url(get_permalink($related_id)); ?>"><?= esc_html(get_the_title($related_id)); ?></a></h3>
                <p class="ls-related-card__price"><?= wp_kses_post($related_product->get_price_html()); ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

    <?php endwhile;
  endif; ?>

</main>

<?php get_footer(); ?>
