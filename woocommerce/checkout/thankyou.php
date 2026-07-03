<?php
/**
 * Oculoo — Thank You / Order Received
 * Override van woocommerce/templates/checkout/thankyou.php
 *
 * Custom layout in Oculoo design system:
 *  - Hero met bevestiging
 *  - Bestelling samenvatting
 *  - Klant + verzendgegevens
 *  - "Wat gebeurt er nu?" stappen
 *  - Contact (alleen e-mail)
 *
 * Beschikbare variabele: $order (WC_Order|false)
 *
 * @package Oculoo
 */

if (!defined('ABSPATH')) exit;

$support_email = apply_filters('oculoo_thankyou_support_email', 'info@oculoo.nl');
?>

<section class="oculoo-thankyou ls-section--default section-md">
  <div class="ls-container--narrow">

    <?php if (!$order) : ?>

      <div class="oculoo-thankyou__hero">
        <h1 class="oculoo-thankyou__title"><?php esc_html_e('Bedankt voor je bestelling.', 'oculoo'); ?></h1>
        <p class="oculoo-thankyou__lead">
          <?php esc_html_e('Je Oculoo komt eraan. We hebben je bestelling goed ontvangen en houden je per e-mail
op de hoogte', 'oculoo'); ?>
        </p>
      </div>

    <?php else :
      $order_id        = $order->get_id();
      $order_email     = $order->get_billing_email();
      $payment_method  = $order->get_payment_method_title();
      $items           = $order->get_items();
    ?>

      <?php if ($order->has_status('failed')) : ?>

        <div class="oculoo-thankyou__hero">
          <h1 class="oculoo-thankyou__title oculoo-thankyou__title--failed">
            <?php esc_html_e('Betaling mislukt.', 'oculoo'); ?>
          </h1>
          <p class="oculoo-thankyou__lead">
            <?php esc_html_e('Probeer het opnieuw of neem contact met ons op.', 'oculoo'); ?>
          </p>
          <div class="oculoo-thankyou__actions">
            <a class="btn btn-primary" href="<?php echo esc_url($order->get_checkout_payment_url()); ?>">
              <?php esc_html_e('Opnieuw betalen', 'oculoo'); ?>
            </a>
            <?php if (is_user_logged_in()) : ?>
              <a class="btn btn-secondary" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                <?php esc_html_e('Naar mijn account', 'oculoo'); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>

      <?php else : ?>

        <!-- HERO -->
        <header class="oculoo-thankyou__hero">
          <div class="oculoo-thankyou__check" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 12.5l4.5 4.5L19 7.5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <span class="oculoo-thankyou__eyebrow"><?php esc_html_e('Bestelling bevestigd', 'oculoo'); ?></span>
          <h1 class="oculoo-thankyou__title"><?php esc_html_e('Bedankt voor je bestelling.', 'oculoo'); ?></h1>
          <p class="oculoo-thankyou__lead">
            <?php
              printf(
                /* translators: %1$s: ordernummer, %2$s: e-mailadres */
                esc_html__('Bestelling %1$s is geplaatst. We sturen de bevestiging naar %2$s.', 'oculoo'),
                '<strong>#' . esc_html($order->get_order_number()) . '</strong>',
                '<strong>' . esc_html($order_email) . '</strong>'
              );
            ?>
          </p>
        </header>

        <!-- BESTELLING SAMENVATTING -->
        <div class="oculoo-thankyou__card">
          <h2 class="oculoo-thankyou__card-title"><?php esc_html_e('Je bestelling', 'oculoo'); ?></h2>

          <ul class="oculoo-thankyou__items">
            <?php foreach ($items as $item_id => $item) :
              $product   = $item->get_product();
              $thumb     = $product ? $product->get_image('thumbnail', ['class' => 'oculoo-thankyou__item-thumb']) : '';
              $name      = $item->get_name();
              $qty       = $item->get_quantity();
              $line_total = $order->get_formatted_line_subtotal($item);
            ?>
              <li class="oculoo-thankyou__item">
                <?php if ($thumb) : ?>
                  <div class="oculoo-thankyou__item-media"><?php echo $thumb; ?></div>
                <?php endif; ?>
                <div class="oculoo-thankyou__item-body">
                  <span class="oculoo-thankyou__item-name"><?php echo esc_html($name); ?></span>
                  <span class="oculoo-thankyou__item-qty"><?php printf(esc_html__('Aantal: %d', 'oculoo'), (int) $qty); ?></span>
                </div>
                <div class="oculoo-thankyou__item-price"><?php echo wp_kses_post($line_total); ?></div>
              </li>
            <?php endforeach; ?>
          </ul>

          <dl class="oculoo-thankyou__totals">
            <?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
              <div class="oculoo-thankyou__total-row <?php echo $key === 'order_total' ? 'is-grand' : ''; ?>">
                <dt><?php echo esc_html($total['label']); ?></dt>
                <dd><?php echo wp_kses_post($total['value']); ?></dd>
              </div>
            <?php endforeach; ?>
          </dl>
        </div>

        <!-- KLANT + VERZENDGEGEVENS -->
        <div class="oculoo-thankyou__grid">

          <div class="oculoo-thankyou__card oculoo-thankyou__card--sm">
            <h3 class="oculoo-thankyou__card-title"><?php esc_html_e('Verzendadres', 'oculoo'); ?></h3>
            <address>
              <?php
                $shipping = $order->get_formatted_shipping_address();
                echo $shipping ? wp_kses_post($shipping) : wp_kses_post($order->get_formatted_billing_address());
              ?>
            </address>
          </div>

          <div class="oculoo-thankyou__card oculoo-thankyou__card--sm">
            <h3 class="oculoo-thankyou__card-title"><?php esc_html_e('Factuuradres', 'oculoo'); ?></h3>
            <address><?php echo wp_kses_post($order->get_formatted_billing_address()); ?></address>
            <?php if ($payment_method) : ?>
              <p class="oculoo-thankyou__payment">
                <span><?php esc_html_e('Betaalmethode:', 'oculoo'); ?></span>
                <strong><?php echo esc_html($payment_method); ?></strong>
              </p>
            <?php endif; ?>
          </div>

        </div>

        <!-- WAT GEBEURT ER NU -->
        <div class="oculoo-thankyou__steps">
          <h2 class="oculoo-thankyou__card-title"><?php esc_html_e('Wat gebeurt er nu?', 'oculoo'); ?></h2>

          <ol class="oculoo-thankyou__steps-list">
            <li class="oculoo-thankyou__step">
              <span class="oculoo-thankyou__step-num">1</span>
              <div>
                <h4><?php esc_html_e('Bevestiging in je inbox, 'oculoo'); ?></h4>
                <p><?php esc_html_e('Je ontvangt zo een e-mail met alle gegevens van je bestelling.', 'oculoo'); ?></p>
              </div>
            </li>
            <li class="oculoo-thankyou__step">
              <span class="oculoo-thankyou__step-num">2</span>
              <div>
                <h4><?php esc_html_e('We maken je bestelling klaar', 'oculoo'); ?></h4>
                <p><?php esc_html_e('We pakken je Oculoo zorgvuldig in en maken hem klaar voor verzending.', 'oculoo'); ?></p>
              </div>
            </li>
            <li class="oculoo-thankyou__step">
              <span class="oculoo-thankyou__step-num">3</span>
              <div>
                <h4><?php esc_html_e('Je pakket gaat onderweg', 'oculoo'); ?></h4>
                <p><?php esc_html_e('Zodra je bestelling verzonden is ontvang je een track & trace per mail.', 'oculoo'); ?></p>
              </div>
            </li>
            <li class="oculoo-thankyou__step">
              <span class="oculoo-thankyou__step-num">4</span>
              <div>
                <h4><?php esc_html_e('Klaar om te druppelen', 'oculoo'); ?></h4>
                <p><?php esc_html_e('Je Oculoo is klaar voor gebruik. Volg de stappen op de verpakking of bekijk de uitleg op onze website.', 'oculoo'); ?></p>
              </div>
            </li>
          </ol>
        </div>

        <!-- CONTACT -->
        <div class="oculoo-thankyou__contact">
          <h3><?php esc_html_e('Vragen over je bestelling?', 'oculoo'); ?></h3>
          <p>
            <?php
              printf(
                /* translators: %s: support e-mail link */
                esc_html__('Mail ons gerust op %s — we helpen je graag.', 'oculoo'),
                '<a href="mailto:' . esc_attr($support_email) . '">' . esc_html($support_email) . '</a>'
              );
            ?>
          </p>
        </div>

      <?php endif; ?>

    <?php endif; ?>

  </div>
</section>
