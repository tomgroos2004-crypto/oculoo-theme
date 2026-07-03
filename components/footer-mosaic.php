<?php if (!defined('ABSPATH')) exit; ?>

<?php
$shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/winkel/');
$over_page = get_page_by_path('over-oculoo') ?: get_page_by_path('over-ons');
$over_url  = $over_page ? get_permalink($over_page->ID) : home_url('/over-ons/');

$support_email  = get_field('oculoo_support_email', 'option') ?: 'support@oculoo.nl';
$company_name   = get_field('oculoo_company_name', 'option') ?: '';
$address        = get_field('oculoo_address', 'option')      ?: '';
$email          = get_field('oculoo_email', 'option')        ?: $support_email;
$kvk            = get_field('oculoo_kvk', 'option')          ?: '';
$btw            = get_field('oculoo_btw', 'option')          ?: '';

$socials = [
  'linkedin'  => ['url' => get_field('oculoo_social_linkedin', 'option'),  'label' => 'LinkedIn',  'icon' => 'in'],
  'facebook'  => ['url' => get_field('oculoo_social_facebook', 'option'),  'label' => 'Facebook',  'icon' => 'f'],
  'instagram' => ['url' => get_field('oculoo_social_instagram', 'option'), 'label' => 'Instagram', 'icon' => 'ig'],
  'twitter'   => ['url' => get_field('oculoo_social_twitter', 'option'),   'label' => 'X',         'icon' => 'x'],
];

/* Niet-scroll state logo (witte/lichte versie, zichtbaar op donkere achtergrond) */
$footer_logo_url = get_field('oculoo_logo', 'option');
$footer_logo_alt = get_field('oculoo_logo_alt', 'option') ?: 'Oculoo';
if (!$footer_logo_url) {
  $footer_logo_url = get_stylesheet_directory_uri() . '/assets/img/oculoo-logo.png';
}
?>

<footer class="ls-footer">
  <div class="ls-container footer-inner">

    <div class="footer-top">
      <div>
        <a href="<?= esc_url(home_url('/')); ?>" class="f-logo" aria-label="Oculoo home">
          <img src="<?= esc_url($footer_logo_url); ?>" alt="<?= esc_attr($footer_logo_alt); ?>" loading="lazy" decoding="async">
        </a>
        <p class="f-tagline">De eerste oogdruppelbril die helpt bij de hele handeling, van flesje plaatsen tot rustig
druppelen.</p>
        <div class="f-socials">
          <?php foreach ($socials as $social) : if (!empty($social['url'])) : ?>
            <a href="<?= esc_url($social['url']); ?>" class="f-social" title="<?= esc_attr($social['label']); ?>" aria-label="<?= esc_attr($social['label']); ?>" target="_blank" rel="noopener"><?= esc_html($social['icon']); ?></a>
          <?php endif; endforeach; ?>
        </div>
      </div>

      <div>
        <p class="f-col-title">Product</p>
        <ul class="f-links">
          <li><a href="/product/oculoo-oogdruppelbril/">Oculoo oogdruppelbril</a></li>
          <li><a href="/product/oculoo-minim-bril/">Oculoo minim bril</a></li>
          <li><a href="<?= esc_url($shop_url); ?>">Bestellen</a></li>
          <li><a href="/feedback/">Feedback</a></li>
        </ul>
      </div>

      <div>
        <p class="f-col-title">Zakelijk</p>
        <ul class="f-links">
          <li><a href="<?= esc_url(home_url('/mijn-account')); ?>">Log in</a></li>
          <li><a href="<?= esc_url(home_url('/mijn-account')); ?>">Aanvragen</a></li>
          <li><a href="mailto:<?= esc_attr($support_email); ?>">Contact</a></li>
          <li><a href="<?= esc_url(home_url('/private-label')); ?>">Private label</a></li>
        </ul>
      </div>

      <div>
        <p class="f-col-title">Informatie</p>
        <ul class="f-links">
          <li><a href="<?= esc_url($over_url); ?>">Over Oculoo</a></li>
          <li><a href="<?= esc_url(get_post_type_archive_link('onderzoek')); ?>">Onderzoek</a></li>
          <li><a href="<?= esc_url(get_post_type_archive_link('blog')); ?>">Blog</a></li>
          <li><a href="<?= esc_url(home_url('/retour-aanmelden/')); ?>">Retour aanmelden</a></li>
        </ul>
      </div>
    </div>

    <?php
    $details = array_filter([
      $company_name,
      $address ? str_replace("\n", ', ', trim($address)) : '',
      $email   ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '',
      $kvk     ? 'KvK ' . esc_html($kvk) : '',
      $btw     ? 'BTW ' . esc_html($btw) : '',
    ]);
    if ($details) : ?>
      <div class="footer-company">
        <?php foreach ($details as $i => $item) : ?>
          <?php if ($i > 0) : ?><span class="f-sep">·</span><?php endif; ?>
          <span class="f-company-item"><?= $item; ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="footer-bottom">
      <span>&copy; <?= date('Y'); ?> Oculoo - Medisch hulpmiddel - Nederland</span>
      <div class="f-legal">
        <a href="<?= esc_url(home_url('/algemene-verkoop-en-leveringsvoorwaarden-oculoo-b-v/')); ?>">Algemene voorwaarden</a>
        <a href="<?= esc_url(home_url('/retourbeleid/')); ?>">Retourbeleid</a>
        <a href="<?= esc_url(home_url('/privacybeleid/')); ?>">Privacybeleid</a>
        <a href="<?= esc_url(home_url('/cookiebeleid/')); ?>">Cookiebeleid</a>
      </div>
    </div>

  </div>
</footer>
