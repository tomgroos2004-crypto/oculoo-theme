<div class="ls-header-wrap">
  <header class="ls-header">
    <div class="ls-container">
      <div class="ls-header-inner">

        <!-- Logo -->
        <a
          class="ls-header-brand"
          href="<?= esc_url(home_url('/')); ?>"
          aria-label="Oculoo home"
        >
          <img
            src="https://oculoo.com/wp-content/uploads/2026/03/LOGO-13-okt-1.png"
            alt="Oculoo"
            loading="eager"
            decoding="async"
          >
        </a>

        <!-- Desktop nav -->
        <nav class="ls-header-nav" aria-label="Hoofdmenu">
          <?php
          $shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/winkel/');
          ?>
          <a class="<?= (is_shop() || is_product_category() || is_product() ? 'is-active' : ''); ?>" href="<?= esc_url($shop_url); ?>">Producten</a>
          <a class="<?= (is_page('over-ons') ? 'is-active' : ''); ?>" href="<?= esc_url(home_url('/over-ons/')); ?>">Over ons</a>
          <a class="<?= (is_page('contact') ? 'is-active' : ''); ?>" href="<?= esc_url(home_url('/contact/')); ?>">Contact</a>
          <a class="ls-header-nav__secondary <?= (is_post_type_archive('blog') || is_singular('blog') ? 'is-active' : ''); ?>" href="<?= esc_url(get_post_type_archive_link('blog')); ?>">Blog</a>
          <a class="ls-header-nav__secondary <?= (is_post_type_archive('onderzoek') || is_singular('onderzoek') ? 'is-active' : ''); ?>" href="<?= esc_url(get_post_type_archive_link('onderzoek')); ?>">Onderzoeken</a>
          <?php
          $account_page_id = function_exists('wc_get_page_id') ? wc_get_page_id('myaccount') : 0;
          $account_url     = $account_page_id > 0 ? get_permalink($account_page_id) : home_url('/mijn-account/');
          ?>
          <a class="<?= (is_account_page() ? 'is-active' : ''); ?>" href="<?= esc_url($account_url); ?>">Log in</a>
        </nav>

        <?php
        if (function_exists('wc_get_page_id')) {
          $cart_page_id = wc_get_page_id('cart');
          $cart_url     = $cart_page_id > 0 ? get_permalink($cart_page_id) : home_url('/winkelwagen/');
        } else {
          $cart_url = home_url('/winkelwagen/');
        }
        $cart_count = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
        ?>
        <a class="ls-header-cart<?= $cart_count > 0 ? ' has-items' : ''; ?>" href="<?= esc_url($cart_url); ?>" aria-label="Winkelmandje<?= $cart_count > 0 ? ', ' . (int) $cart_count . ' item' . ($cart_count > 1 ? 's' : '') : ''; ?>">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M3 6h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <?php if ($cart_count > 0) : ?>
            <span class="ls-header-cart__count"><?= (int) $cart_count; ?></span>
          <?php endif; ?>
          <span class="ls-header-cart__label">Winkelmandje</span>
        </a>

        <!-- Burger -->
        <button
          class="ls-header-burger"
          aria-label="Menu openen"
          aria-expanded="false"
          data-header-toggle
        >
        </button>

      </div>
    </div>
  </header>
</div>
