<?php
/**
 * LeadSprint – Shortcodes
 *
 * Architectuur:
 * - Elementor = compositie (plaatsen van shortcodes)
 * - Child theme = structuur & gedrag
 * - Shortcodes renderen PHP partials
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/* =========================================================
   HERO
   Shortcode: [leadsprint_hero]
========================================================= */
add_shortcode( 'leadsprint_hero', function ( $atts ) {

  $atts = shortcode_atts( [
    'title'     => '',
    'text'      => '',
    'cta_label' => '',
    'cta_url'   => '',
    'image_url' => '',
    'image_alt' => '',
  ], $atts );

  // Variabelen beschikbaar maken voor partial
  $title     = sanitize_text_field( $atts['title'] );
  $text      = sanitize_text_field( $atts['text'] );
  $cta_label = sanitize_text_field( $atts['cta_label'] );
  $cta_url   = esc_url( $atts['cta_url'] );
  $image_url = esc_url( $atts['image_url'] );
  $image_alt = sanitize_text_field( $atts['image_alt'] );

  ob_start();
  include get_stylesheet_directory() . '/partials/hero.php';
  return ob_get_clean();
} );


/* =========================================================
   GLOBAL CTA
   Shortcode: [leadsprint_cta]
========================================================= */
add_shortcode( 'leadsprint_cta', function ( $atts ) {

  $atts = shortcode_atts( [
    'title'   => 'Klaar voor voorspelbare leadgeneratie?',
    'text'    => 'Plan een vrijblijvend gesprek en ontdek waar je kansen laat liggen.',
    'button'  => 'Plan een sprint call',
    'url'     => '/contact',
    'variant' => '',   // bijv. "centered"
    'class'   => '',   // extra classes
    'image'   => '',
  ], $atts );

  $title   = sanitize_text_field( $atts['title'] );
  $text    = sanitize_text_field( $atts['text'] );
  $button  = sanitize_text_field( $atts['button'] );
  $url     = esc_url( $atts['url'] );
  $variant = ! empty( $atts['variant'] ) ? sanitize_html_class( $atts['variant'] ) : '';
  $class   = ! empty( $atts['class'] ) ? sanitize_html_class( $atts['class'] ) : '';
  $image   = ! empty( $atts['image'] ) ? esc_url( $atts['image'] ) : '';

  ob_start();
  include get_stylesheet_directory() . '/partials/cta.php';
  return ob_get_clean();
} );
