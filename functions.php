<?php
if (!defined('ABSPATH')) {
  exit;
}

/* =========================================================
   THEME SUPPORT
========================================================= */
function es_theme_setup() {

  add_theme_support('title-tag');
  add_theme_support('woocommerce');

  add_theme_support('post-thumbnails', [
    'post',
    'page',
    'product',
    'blog',
    'onderzoek',
  ]);

  add_theme_support('html5', [
    'search-form',
    'gallery',
    'caption',
    'style',
    'script',
  ]);

}
add_action('after_setup_theme', 'es_theme_setup');


/* =========================================================
   ASSETS
========================================================= */
function es_enqueue_assets() {

  if (is_admin()) return;

  $dir = get_stylesheet_directory();
  $uri = get_stylesheet_directory_uri();

  /* =========================================================
     CSS — alle modulaire bestanden samengevoegd tot één
     gecachte bundle (1 request i.p.v. ~40 render-blocking
     requests). De bundle staat in /uploads/oculoo-css/ en wordt
     alleen herbouwd als een bronbestand wijzigt. Valt terug op
     losse (parallelle) enqueues als schrijven niet lukt.
  ========================================================= */
  $css_files = [
    'colors', 'typography', 'layout', 'spacing', 'buttons',
    'header', 'header-home', 'card', 'case-breakdown', 'footer',
    'widgets/hero', 'widgets/hero-home', 'widgets/problem', 'widgets/how',
    'widgets/how-steps-page', 'widgets/how-tips-page', 'widgets/over-origin',
    'widgets/over-team', 'widgets/cta', 'widgets/cards', 'widgets/content',
    'widgets/contact', 'widgets/case-showcase', 'widgets/partners-slider',
    'widgets/testimonials', 'widgets/featured-products', 'widgets/popup',
    'widgets/feedback', 'widgets/private-label',
    'page/product-single', 'page/shop', 'page/blog', 'page/privacy',
    'page/account', 'page/checkout-terms', 'page/thankyou', 'page/retour',
  ];

  $bundle = es_build_css_bundle($css_files);

  if ($bundle) {
    wp_enqueue_style('oculoo-main', $bundle['url'], [], $bundle['version']);
  } else {
    /* Fallback: losse bestanden, parallel.
       GEEN dependency-ketting — WordPress behoudt de enqueue-volgorde
       vanzelf, en een ketting zorgt dat één gemiste schakel alle CSS
       erna laat wegvallen (oorzaak van eerder kapotte pagina's). */
    foreach ($css_files as $rel) {
      $path = $dir . "/assets/css/{$rel}.css";
      if (!file_exists($path)) continue;
      $handle = 'oculoo-css-' . str_replace('/', '-', $rel);
      wp_enqueue_style($handle, $uri . "/assets/css/{$rel}.css", [], filemtime($path));
    }
    wp_enqueue_style('oculoo-main', $uri . '/assets/css/main.css', [], filemtime($dir . '/assets/css/main.css'));
  }

  /* =========================================================
     JS — alleen laden waar nodig.
  ========================================================= */
  $enqueue = function ($handle, $rel, $deps = []) use ($dir, $uri) {
    $path = $dir . "/assets/js/{$rel}.js";
    if (!file_exists($path)) return;
    wp_enqueue_script($handle, $uri . "/assets/js/{$rel}.js", $deps, filemtime($path), true);
  };

  /* Sitebreed */
  $enqueue('es-reveal', 'reveal');
  $enqueue('es-header', 'header');

  /* GSAP + hero/content-animaties.
     Niet nodig op WooCommerce utility-pagina's (cart/checkout/account):
     daar staan geen [data-hero] of [data-content] secties. */
  $is_wc_utility = function_exists('is_woocommerce')
    && (is_cart() || is_checkout() || is_account_page());

  if (!$is_wc_utility) {
    /* Lokaal gehost i.p.v. unpkg.com — geen externe DNS/verbinding meer */
    wp_enqueue_script('gsap', $uri . '/assets/js/vendor/gsap.min.js', [], filemtime($dir . '/assets/js/vendor/gsap.min.js'), true);
    wp_enqueue_script('gsap-scrolltrigger', $uri . '/assets/js/vendor/ScrollTrigger.min.js', ['gsap'], filemtime($dir . '/assets/js/vendor/ScrollTrigger.min.js'), true);
    /* gsap-hero hangt af van gsap + scrolltrigger (anders draait het te vroeg) */
    $enqueue('es-gsap-hero', 'gsap-hero', ['gsap', 'gsap-scrolltrigger']);
  }

  /* Hoe-het-werkt: tab-stappen alleen op die pagina */
  if (is_page(['hoe-het-werkt', 'hoe-werkt-het'])) {
    $enqueue('es-how-steps-page', 'how-steps-page');
  }

  /* Single product */
  if (function_exists('is_product') && is_product()) {
    $enqueue('es-product-single', 'product-single');
  }

  /* Popup — alleen als ingeschakeld in Thema instellingen */
  if (function_exists('get_field') && get_field('oculoo_popup_enabled', 'option')) {
    $enqueue('es-popup', 'popup');
  }

  /* Feedback formulier — alleen op de feedback-pagina */
  if (is_page('feedback') || is_page_template('page-feedback.php')) {
    $fb_path = $dir . '/assets/js/feedback.js';
    if (file_exists($fb_path)) {
      wp_enqueue_script(
        'es-feedback',
        $uri . '/assets/js/feedback.js',
        [],
        filemtime($fb_path),
        true
      );
      wp_localize_script('es-feedback', 'LSFeedback', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('ls_feedback_nonce'),
      ]);
    }
  }

}
add_action('wp_enqueue_scripts', 'es_enqueue_assets');


/* =========================================================
   CSS BUNDLE — voegt alle modulaire CSS samen tot één gecacht
   bestand in /uploads/oculoo-css/. Herbouwt alleen als een
   bronbestand nieuwer is dan de bundle. Retourneert
   ['url' => ..., 'version' => mtime] of false bij falen.
========================================================= */
function es_build_css_bundle(array $rel_files) {
  $dir = get_stylesheet_directory();

  /* Bronbestanden op volgorde + canvas-override (main.css) als laatste */
  $sources = [];
  foreach ($rel_files as $rel) {
    $p = $dir . "/assets/css/{$rel}.css";
    if (file_exists($p)) $sources[] = $p;
  }
  $main = $dir . '/assets/css/main.css';
  if (file_exists($main)) $sources[] = $main;

  if (empty($sources)) return false;

  /* Versie = nieuwste mtime van alle bronnen */
  $version = 0;
  foreach ($sources as $p) {
    $m = (int) filemtime($p);
    if ($m > $version) $version = $m;
  }

  $upload = wp_upload_dir();
  if (!empty($upload['error'])) return false;

  $bundle_dir  = trailingslashit($upload['basedir']) . 'oculoo-css';
  $bundle_file = $bundle_dir . '/bundle.css';
  $bundle_url  = trailingslashit($upload['baseurl']) . 'oculoo-css/bundle.css';

  /* Bestaande bundle teruggeven met zijn eigen mtime als versie. */
  $existing = function () use ($bundle_file, $bundle_url) {
    if (!file_exists($bundle_file)) return false;
    return ['url' => $bundle_url, 'version' => (int) filemtime($bundle_file)];
  };

  /* Bundle is actueel → direct teruggeven, geen herbouw nodig. */
  if (file_exists($bundle_file) && (int) filemtime($bundle_file) >= $version) {
    return ['url' => $bundle_url, 'version' => (int) filemtime($bundle_file)];
  }

  /* Herbouwen (ontbrekend of verouderd). Lukt een stap niet, val dan
     NOOIT terug op de canvas-only main.css: als er al een bundle staat,
     serveren we die (iets verouderd maar volledig gestyled). Alleen als
     er helemaal geen bundle is geven we false terug. */
  if (!wp_mkdir_p($bundle_dir)) return $existing();

  $css = '';
  foreach ($sources as $p) {
    $contents = file_get_contents($p);
    if ($contents === false) return $existing(); // niet half bundelen
    $css .= "\n/* " . basename($p) . " */\n" . $contents;
  }

  /* Atomisch schrijven: eerst naar temp, dan hernoemen. Voorkomt dat
     een gelijktijdig verzoek een half-geschreven bundel ophaalt. */
  $tmp = $bundle_file . '.' . getmypid() . '.tmp';
  if (file_put_contents($tmp, $css, LOCK_EX) === false) return $existing();
  if (!@rename($tmp, $bundle_file)) {
    @unlink($tmp);
    return $existing();
  }

  return ['url' => $bundle_url, 'version' => $version];
}


/* =========================================================
   FONTS — @font-face + preload dynamisch via wp_head.
   We genereren het font-pad met get_stylesheet_directory_uri()
   zodat het klopt ongeacht de naam van de theme-map (en zodat
   het preload-verzoek exact matcht). Preload laat de browser de
   fonts vroeg en parallel met de CSS ophalen → minder tekst-flits
   en snellere LCP voor de grote hero-titel.
========================================================= */
function es_fonts_head() {
  $uri    = get_stylesheet_directory_uri();
  $onest  = esc_url($uri . '/fonts/Onest-VariableFont_wght.ttf');
  $landour = esc_url($uri . '/fonts/Landour-MediumDisplay.ttf');

  echo '<link rel="preload" href="' . $landour . '" as="font" type="font/ttf" crossorigin>' . "\n";
  echo '<link rel="preload" href="' . $onest . '" as="font" type="font/ttf" crossorigin>' . "\n";

  echo '<style id="oculoo-fonts">'
    . "@font-face{font-family:'Landour';src:url('" . $landour . "') format('truetype');font-weight:500;font-style:normal;font-display:swap;}"
    . "@font-face{font-family:'Onest';src:url('" . $onest . "') format('truetype');font-weight:100 900;font-style:normal;font-display:swap;}"
    . '</style>' . "\n";
}
add_action('wp_head', 'es_fonts_head', 1);


/* =========================================================
   DEQUEUE — overbodige WooCommerce/plugin-scripts.
   Deze assets zijn alleen nodig op account/checkout/cart/shop:
   - password-strength-meter + zxcvbn  → registratie/account
   - jquery-ui-datepicker              → datumvelden (checkout/admin)
   - select2 / selectWoo               → keuzevelden (checkout)
   Op gewone pagina's (homepage, blog, info) zijn ze pure ballast.
   We dequeuen alleen (geen deregister) zodat geldige afhankelijk-
   heden elders niet breken. Shop/product/cart/checkout/account
   blijven volledig intact.
========================================================= */
function es_dequeue_unneeded_wc_assets() {
  if (is_admin()) return;

  $needs_wc = function_exists('is_woocommerce')
    && (is_woocommerce() || is_cart() || is_checkout() || is_account_page());

  if ($needs_wc) return;

  foreach ([
    'wc-password-strength-meter',
    'password-strength-meter',
    'zxcvbn-async',
    'jquery-ui-datepicker',
    'select2',
    'selectWoo',
  ] as $handle) {
    wp_dequeue_script($handle);
  }

  foreach (['select2', 'selectWoo'] as $handle) {
    wp_dequeue_style($handle);
  }
}
add_action('wp_enqueue_scripts', 'es_dequeue_unneeded_wc_assets', 99);


/* =========================================================
   ADMIN CSS — overzichtelijkere ACF-editor voor de redacteur
========================================================= */
function es_enqueue_admin_acf_css($hook) {

  // Alleen op post/pagina-bewerkschermen en ACF-optiepagina's.
  $allowed = in_array($hook, ['post.php', 'post-new.php'], true)
    || strpos($hook, 'oculoo-') !== false
    || strpos($hook, 'acf-options') !== false;

  if (!$allowed) return;

  $dir  = get_stylesheet_directory();
  $uri  = get_stylesheet_directory_uri();
  $path = $dir . '/assets/css/admin/acf-editor.css';

  if (file_exists($path)) {
    wp_enqueue_style(
      'oculoo-acf-editor',
      $uri . '/assets/css/admin/acf-editor.css',
      [],
      filemtime($path)
    );
  }
}
add_action('admin_enqueue_scripts', 'es_enqueue_admin_acf_css');


/* =========================================================
   BODY CLASS — hero overlap + header achtergrond
========================================================= */
function es_body_class_hero_overlap($classes) {
  // Header is transparant en laat de hero erdoor lopen.
  $classes[] = 'has-hero-overlap';

  // Slug-class voor pagina-specifieke styling
  if (is_singular('page')) {
    $post = get_queried_object();
    if ($post && !empty($post->post_name)) {
      $classes[] = 'page-' . sanitize_html_class($post->post_name);
    }
  }

  /* Bepaal of de pagina een paarse/donkere hero heeft.
     Zo niet → voeg "has-solid-header" toe zodat de header een paarse
     achtergrond krijgt in plaats van transparant. */
  $has_dark_hero = false;

  // Pagina's die expliciet GEEN paarse hero hebben (lichte achtergrond)
  $light_pages = ['over-oculoo', 'over-ons'];

  // WooCommerce pagina's (cart, checkout, account) hebben geen hero
  // → altijd solide paarse header.
  $is_wc_utility_page = function_exists('is_woocommerce')
    && (is_cart() || is_checkout() || is_account_page());

  if ($is_wc_utility_page) {
    $has_dark_hero = false;
  } elseif (is_front_page()) {
    $has_dark_hero = true;
  } elseif (is_page($light_pages)) {
    $has_dark_hero = false;
  } elseif (is_page('feedback')) {
    $has_dark_hero = true; // eigen paarse feedback-hero
  } elseif (is_page('private-label')) {
    $has_dark_hero = true; // eigen paarse private-label hero
  } elseif (is_singular('page')) {
    // Statement-hero is paars; alleen tonen als hero_enabled = true
    if (get_field('hero_enabled', get_queried_object_id())) {
      $has_dark_hero = true;
    }
  }

  if (!$has_dark_hero) {
    $classes[] = 'has-solid-header';
  }

  return $classes;
}
add_filter('body_class', 'es_body_class_hero_overlap');


/* =========================================================
   META DESCRIPTION
========================================================= */
function es_meta_description() {

  if (is_front_page()) {
    echo '<meta name="description" content="Oculoo is de oogdruppelbril die ouderen helpt zelfstandig oogdruppels toe te dienen. Geen hulp nodig — simpel, veilig en direct te bestellen.">' . "\n";
} else {
    echo '<meta name="description" content="' . esc_attr(get_the_excerpt()) . '">' . "\n";
}

}
add_action('wp_head', 'es_meta_description');


/* =========================================================
   REWRITE FLUSH (bij activatie)
========================================================= */
function es_flush_rewrite() {
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'es_flush_rewrite');

/* =========================================================
   ACF OPTIONS PAGES
========================================================= */
function es_register_acf_options_pages() {
  if (!function_exists('acf_add_options_page')) return;

  acf_add_options_page([
    'page_title' => 'Thema instellingen',
    'menu_title' => 'Thema instellingen',
    'menu_slug'  => 'oculoo-theme-settings',
    'capability' => 'edit_posts',
    'redirect'   => false,
  ]);

  acf_add_options_sub_page([
    'page_title'  => 'Erkend door',
    'menu_title'  => 'Erkend door',
    'parent_slug' => 'oculoo-theme-settings',
    'menu_slug'   => 'oculoo-erkend-door',
    'capability'  => 'edit_posts',
  ]);

  acf_add_options_sub_page([
    'page_title'  => 'Checkout instellingen',
    'menu_title'  => 'Checkout instellingen',
    'parent_slug' => 'oculoo-theme-settings',
    'menu_slug'   => 'oculoo-checkout-settings',
    'capability'  => 'manage_options',
  ]);
}
add_action('acf/init', 'es_register_acf_options_pages');


/* =========================================================
   WOOCOMMERCE TEXT OVERRIDES (Blocks cart/checkout)
========================================================= */
function es_wc_blocks_text_overrides() {
  if (!is_cart() && !is_checkout()) return;

  ?>
  <script>
  (function(){
    var map = { 'Geschat totaal': 'Totaal', 'Estimated total': 'Totaal' };
    var obs = new MutationObserver(function(){
      document.querySelectorAll('.wc-block-components-totals-item__label').forEach(function(el){
        var t = el.textContent.trim();
        if (map[t]) el.textContent = map[t];
      });
    });
    obs.observe(document.body, { childList: true, subtree: true, characterData: true });
  })();
  </script>
  <?php
}
add_action('wp_footer', 'es_wc_blocks_text_overrides');


/* =========================================================
   WOOCOMMERCE — Branded empty cart UI
   ---------------------------------------------------------
   Injecteert een conversiegericht hero-blok bovenin het
   wp-block-woocommerce-empty-cart-block. De default emoji,
   tekst en separator worden via CSS verborgen. De
   "Nieuw in de winkel" producten blijven onderaan staan.
========================================================= */
function ls_wc_branded_empty_cart($block_content, $block) {
  if (empty($block['blockName']) || $block['blockName'] !== 'woocommerce/empty-cart-block') {
    return $block_content;
  }

  $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/winkel/');
  $how_url  = home_url('/hoe-het-werkt/');

  ob_start(); ?>
  <div class="ls-empty-cart">
    <div class="ls-empty-cart__hero">
      <div class="ls-empty-cart__icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="9" cy="20" r="1.5"/>
          <circle cx="17" cy="20" r="1.5"/>
          <path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.5L21 8H6"/>
        </svg>
      </div>

      <h2 class="ls-empty-cart__title">Je winkelwagen is nog leeg</h2>
      <p class="ls-empty-cart__lead">
        Geen zorgen — Oculoo helpt je in een paar seconden weer op weg.
        Voor 17:00 besteld? Morgen in huis.
      </p>

      <div class="ls-empty-cart__actions">
        <a href="<?php echo esc_url($shop_url); ?>" class="btn btn--purple">Bekijk de producten</a>
        <a href="<?php echo esc_url($how_url); ?>" class="btn btn--purple-outline">Hoe het werkt</a>
      </div>

      <ul class="ls-empty-cart__usps">
        <li>
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Voor 17:00 besteld, morgen in huis</span>
        </li>
        <li>
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <span>30 dagen niet goed, geld terug</span>
        </li>
        <li>
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Direct van de maker</span>
        </li>
      </ul>
    </div>
  </div>
  <?php
  $custom = ob_get_clean();

  // Inject vlak binnen de wrapper-div van het empty-cart blok.
  $pattern = '/(<div\b[^>]*class="[^"]*\bwp-block-woocommerce-empty-cart-block\b[^"]*"[^>]*>)/i';
  if (preg_match($pattern, $block_content)) {
    return preg_replace($pattern, '$1' . $custom, $block_content, 1);
  }

  // Fallback: prepend
  return $custom . $block_content;
}
add_filter('render_block', 'ls_wc_branded_empty_cart', 10, 2);


/* =========================================================
   EXTRA FILES
========================================================= */
$login_file = get_stylesheet_directory() . '/inc/login.php';
if (file_exists($login_file)) {
  require_once $login_file;
}

require_once get_stylesheet_directory() . '/inc/post-types.php';
require_once get_stylesheet_directory() . '/inc/acf-fields.php';
require_once get_stylesheet_directory() . '/inc/feedback.php';
require_once get_stylesheet_directory() . '/inc/checkout-terms.php';
require_once get_stylesheet_directory() . '/inc/retour-form.php';


/* =========================================================
   PRIVATE LABEL — form handler (admin-post)
========================================================= */
function ls_pl_contact_submit() {
  // Honeypot
  if (!empty($_POST['pl_website'])) {
    wp_safe_redirect(home_url('/private-label/?pl_status=success#contact'));
    exit;
  }

  if (!isset($_POST['pl_nonce']) || !wp_verify_nonce($_POST['pl_nonce'], 'pl_contact_form')) {
    wp_die('Beveiligingscheck mislukt. Probeer het opnieuw.');
  }

  $name    = isset($_POST['pl_name'])    ? sanitize_text_field(wp_unslash($_POST['pl_name']))    : '';
  $company = isset($_POST['pl_company']) ? sanitize_text_field(wp_unslash($_POST['pl_company'])) : '';
  $email   = isset($_POST['pl_email'])   ? sanitize_email(wp_unslash($_POST['pl_email']))        : '';
  $phone   = isset($_POST['pl_phone'])   ? sanitize_text_field(wp_unslash($_POST['pl_phone']))   : '';
  $type    = isset($_POST['pl_type'])    ? sanitize_text_field(wp_unslash($_POST['pl_type']))    : '';
  $volume  = isset($_POST['pl_volume'])  ? sanitize_text_field(wp_unslash($_POST['pl_volume']))  : '';
  $message = isset($_POST['pl_message']) ? sanitize_textarea_field(wp_unslash($_POST['pl_message'])) : '';

  if (!$name || !$company || !$email || !$type) {
    wp_safe_redirect(home_url('/private-label/?pl_status=error#contact'));
    exit;
  }

  // E-mailadres uit ACF op de Private Label pagina (met fallback)
  $pl_page = get_page_by_path('private-label');
  $pl_to   = $pl_page ? get_field('pl_contact_email', $pl_page->ID) : '';
  if (!$pl_to || !is_email($pl_to)) {
    $pl_to = 'contact@oculoo.com';
  }
  $to      = apply_filters('ls_pl_contact_to', $pl_to);
  $subject = sprintf('[Private label] Aanvraag van %s (%s)', $name, $company);

  $body  = "Nieuwe private label aanvraag\n\n";
  $body .= "Naam:    {$name}\n";
  $body .= "Bedrijf: {$company}\n";
  $body .= "E-mail:  {$email}\n";
  $body .= "Telefoon: " . ($phone ?: '-') . "\n";
  $body .= "Type:    {$type}\n";
  $body .= "Afname:  " . ($volume ?: '-') . "\n\n";
  $body .= "Bericht:\n" . ($message ?: '-') . "\n";

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    'Reply-To: ' . $name . ' <' . $email . '>',
  ];

  wp_mail($to, $subject, $body, $headers);

  wp_safe_redirect(home_url('/private-label/?pl_status=success#contact'));
  exit;
}
add_action('admin_post_nopriv_pl_contact_submit', 'ls_pl_contact_submit');
add_action('admin_post_pl_contact_submit',        'ls_pl_contact_submit');


/* =========================================================
   LABEL FILTERS
========================================================= */
add_filter('gettext', function($translated, $text, $domain) {
    if ($translated === 'Type gebruiker') {
        return 'Bedrijfstype';
    }
    return $translated;
}, 20, 3);

add_action('wp_footer', function () {
    if (!is_checkout()) {
        return;
    }
    ?>
    <script>
    (function () {
        function shouldShowTaxNote() {
            const body = document.body;
            return (
                body.classList.contains('logged-in') &&
                (
                    body.classList.contains('b2bking_b2b_group_221') ||
                    body.classList.contains('b2bking_b2b_group_222') ||
                    body.classList.contains('b2bking_b2b_group_223') ||
					body.classList.contains('b2bking_b2b_group_409') ||
					body.classList.contains('b2bking_b2b_group_410') ||
					body.classList.contains('b2bking_b2b_group_411')
                )
            );
        }

        function updateTaxNoteVisibility() {
            const taxNote = document.querySelector('.wc-block-components-totals-footer-item-tax');
            if (!taxNote) return;

            if (!shouldShowTaxNote()) {
                taxNote.remove();
            }
        }

        // Eerste keer
        updateTaxNoteVisibility();

        // Voor het geval WooCommerce Blocks het opnieuw rendert
        const observer = new MutationObserver(() => {
            updateTaxNoteVisibility();
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    })();
    </script>
    <?php
});