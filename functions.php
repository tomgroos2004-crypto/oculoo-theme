<?php
if (!defined('ABSPATH')) {
  exit;
}

/* =========================================================
   THEME SUPPORT
========================================================= */
function es_theme_setup() {

  add_theme_support('title-tag');

  add_theme_support('post-thumbnails', [
    'post',
    'page',
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
    'eventsuper-main',
    $uri . '/assets/css/main.css',
    [],
    filemtime($dir . '/assets/css/main.css')
  );

  /* Core JS */
  $scripts = [
    'reveal',
    'header',
    'animations',
    'gsap-hero',
    'case-showcase',
    'partners-slider'
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
    echo '<meta name="description" content="Eventsuper is dé supermarkt op evenementen. Snel, schaalbaar en professioneel ingericht.">' . "\n";
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
   EXTRA FILES
========================================================= */
$login_file = get_stylesheet_directory() . '/inc/login.php';
if (file_exists($login_file)) {
  require_once $login_file;
}
