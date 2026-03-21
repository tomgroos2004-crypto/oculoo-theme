<?php if (!defined('ABSPATH')) exit; ?>

<?php
$shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/winkel/');
$over_page = get_page_by_path('over-oculoo') ?: get_page_by_path('over-ons');
$over_url  = $over_page ? get_permalink($over_page->ID) : home_url('/over-ons/');
?>

<footer class="ls-footer">
  <div class="ls-container footer-inner">

    <div class="footer-top">
      <div>
        <a href="<?= esc_url(home_url('/')); ?>" class="f-logo">Ocul<span>oo</span></a>
        <p class="f-tagline">De eerste oogdruppelbril die automatisch richt en krachtloos knijpt in een beweging.</p>
        <div class="f-socials">
          <a href="#" class="f-social" title="LinkedIn" aria-label="LinkedIn">in</a>
          <a href="#" class="f-social" title="Facebook" aria-label="Facebook">f</a>
        </div>
      </div>

      <div>
        <p class="f-col-title">Product</p>
        <ul class="f-links">
          <li><a href="<?= esc_url($shop_url); ?>">Oculoo oogdruppelbril</a></li>
          <li><a href="<?= esc_url(home_url('/#how')); ?>">Oculoo minim bril</a></li>
          <li><a href="<?= esc_url($shop_url); ?>">Bestellen</a></li>
        </ul>
      </div>

      <div>
        <p class="f-col-title">Zakelijk</p>
        <ul class="f-links">
          <li><a href="<?= esc_url(home_url('/#zakelijk')); ?>">log in</a></li>
          <li><a href="<?= esc_url(home_url('/#zakelijk')); ?>">Aanvragen</a></li>
          <li><a href="mailto:zakelijk@oculoo.nl">Contact</a></li>
        </ul>
      </div>

      <div>
        <p class="f-col-title">Informatie</p>
        <ul class="f-links">
          <li><a href="<?= esc_url($over_url); ?>">Over Oculoo</a></li>
          <li><a href="<?= esc_url(get_post_type_archive_link('onderzoek')); ?>">Onderzoek</a></li>
          <li><a href="<?= esc_url(get_post_type_archive_link('blog')); ?>">Blog</a></li>
          <li><a href="<?= esc_url(home_url('/faq/')); ?>">FAQ</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>&copy; <?= date('Y'); ?> Oculoo - Medisch hulpmiddel - Nederland</span>
      <div class="f-legal">
        <a href="<?= esc_url(home_url('/algemene-voorwaarden/')); ?>">Algemene voorwaarden</a>
        <a href="<?= esc_url(home_url('/privacybeleid/')); ?>">Privacybeleid</a>
        <a href="<?= esc_url(home_url('/cookiebeleid/')); ?>">Cookiebeleid</a>
      </div>
    </div>

  </div>
</footer>
