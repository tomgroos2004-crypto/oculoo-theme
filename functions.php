<?php
// =========================================================
// LeadSprint – Assets (SINGLE SOURCE OF TRUTH)
// =========================================================
add_action('wp_enqueue_scripts', function () {

  $dir = get_stylesheet_directory();
  $uri = get_stylesheet_directory_uri();

  /* =========================
     Main CSS
  ========================= */
  wp_enqueue_style(
    'leadsprint-main',
    $uri . '/assets/css/main.css',
    [],
    filemtime($dir . '/assets/css/main.css')
  );

  /* =========================
     JavaScript
  ========================= */
  wp_enqueue_script(
    'leadsprint-reveal',
    $uri . '/assets/js/reveal.js',
    [],
    filemtime($dir . '/assets/js/reveal.js'),
    true
  );

  wp_enqueue_script(
    'leadsprint-header',
    $uri . '/assets/js/header.js',
    [],
    filemtime($dir . '/assets/js/header.js'),
    true
  );

  wp_enqueue_script(
    'leadsprint-design-system',
    $uri . '/assets/js/design-system.js',
    [],
    filemtime($dir . '/assets/js/design-system.js'),
    true
  );

});


// =========================================================
// Elementor widgets
// =========================================================
require_once get_stylesheet_directory() . '/elementor/elementor-init.php';


// =========================================================
// SEO – Core (plugin-loos, schaalbaar)
// =========================================================
add_theme_support('title-tag');


/**
 * Document title logic
 */
add_filter('document_title_parts', function ($title) {

  /* =========================
     Home
  ========================= */
  if (is_front_page()) {
    $title['title']   = 'LeadSprint';
    $title['tagline'] = 'Leadgeneratie & Online Marketing';
  }

  /* =========================
     Diensten overzicht
  ========================= */
  if (is_page('onze-diensten')) {
    $title['title']   = 'Onze diensten';
    $title['tagline'] = 'Leadgeneratie, websites en online marketing';
  }

  /* =========================
     Diensten – individueel
  ========================= */
  if (is_page('leadgeneratie')) {
    $title['title']   = 'Leadgeneratie';
    $title['tagline'] = 'Meer aanvragen via online marketing';
  }

  if (is_page('website-op-maat')) {
    $title['title']   = 'Websites & webshops';
    $title['tagline'] = 'Gebouwd voor conversie';
  }

  if (is_page('e-mailmarketing')) {
    $title['title']   = 'E-mailmarketing';
    $title['tagline'] = 'Blijf top-of-mind bij je doelgroep';
  }

  /* =========================
     Overig
     → WordPress default
  ========================= */

  return $title;
});


/**
 * Meta descriptions
 */
add_action('wp_head', function () {

  $description = '';

  if (is_front_page()) {
    $description = 'LeadSprint helpt bedrijven groeien met leadgeneratie, websites en online marketing. Gericht op resultaat en duidelijke keuzes.';
  }

  if (is_page('onze-diensten')) {
    $description = 'Overzicht van onze diensten: leadgeneratie, websites en online marketing. Alles gericht op meer aanvragen en groei.';
  }

  if (is_page('leadgeneratie')) {
    $description = 'Meer kwalitatieve leads via online marketing. Leadgeneratie die meetbaar bijdraagt aan bedrijfsgroei.';
  }

  if ($description) {
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
  }

});
