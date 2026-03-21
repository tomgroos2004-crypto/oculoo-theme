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

  /* Main CSS — GEEN file_exists check */
  wp_enqueue_style(
    'oculoo-main',
    $uri . '/assets/css/main.css',
    [],
    filemtime($dir . '/assets/css/main.css')
  );

  /* Core JS */
  $scripts = [
    'reveal',
    'header',
    'how-steps-page',
    'animations',
    'gsap-hero',
    'case-showcase'
  ];

  foreach ($scripts as $script) {

    $path = $dir . "/assets/js/{$script}.js";

    if (file_exists($path)) {
      wp_enqueue_script(
        "es-{$script}",
        $uri . "/assets/js/{$script}.js",
        [],
        filemtime($path),
        true
      );
    }
  }

  /* GSAP */
  wp_enqueue_script(
    'gsap',
    'https://unpkg.com/gsap@3/dist/gsap.min.js',
    [],
    null,
    true
  );

  wp_enqueue_script(
    'gsap-scrolltrigger',
    'https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js',
    ['gsap'],
    null,
    true
  );

}
add_action('wp_enqueue_scripts', 'es_enqueue_assets');


/* =========================================================
   META DESCRIPTION
========================================================= */
function es_meta_description() {

  if (is_front_page()) {
    echo '<meta name="description" content="Oculoo — professionele evenementenproducten. Snel, schaalbaar en direct te bestellen.">' . "\n";
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
}
add_action('acf/init', 'es_register_acf_options_pages');


/* =========================================================
   EXTRA FILES
========================================================= */
$login_file = get_stylesheet_directory() . '/inc/login.php';
if (file_exists($login_file)) {
  require_once $login_file;
}

require_once get_stylesheet_directory() . '/inc/post-types.php';
require_once get_stylesheet_directory() . '/inc/acf-fields.php';
