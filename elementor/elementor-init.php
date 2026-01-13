<?php
if (!defined('ABSPATH')) {
  exit;
}

add_action('elementor/widgets/register', function ($widgets_manager) {

  // Elementor moet echt beschikbaar zijn
  if (!class_exists('\Elementor\Widget_Base')) {
    return;
  }

  /**
   * =========================================================
   * Base widget (ALTIJD eerst)
   * =========================================================
   */
  $base = __DIR__ . '/base-widget.php';
  if (file_exists($base)) {
    require_once $base;
  }

  /**
   * =========================================================
   * Widgets – laden (alleen als bestand bestaat)
   * =========================================================
   */
  $widget_files = [
    __DIR__ . '/widgets/hero.php',
    __DIR__ . '/widgets/cta.php',
    __DIR__ . '/widgets/cards.php',
    __DIR__ . '/widgets/content.php',
    __DIR__ . '/widgets/class-ls-blog-list.php',
    __DIR__ . '/widgets/class-ls-cases-list.php',
    __DIR__ . '/widgets/class-ls-content-hub.php',
    __DIR__ . '/widgets/class-ls-uitleg.php',
    __DIR__ . '/widgets/class-ls-design-system.php',
    __DIR__ . '/widgets/class-ls-pricing.php',
    __DIR__ . '/widgets/class-ls-case-breakdown.php',
    __DIR__ . '/widgets/class-ls-case-showcase.php',
    __DIR__ . '/widgets/class-ls-team-cards.php',

  ];

  foreach ($widget_files as $file) {
    if (file_exists($file)) {
      require_once $file;
    }
  }

  /**
   * =========================================================
   * Widgets – registreren (alleen als class bestaat)
   * =========================================================
   */
$classes = [
  '\LS_Hero_Widget',
  '\LS_CTA_Widget',
  '\LS_Cards_Widget',
  '\LS_Content_Widget',
  '\LS_Blog_List_Widget',
  '\LS_Cases_List_Widget',
  '\LS_Content_Hub_Widget',
  '\LS_Uitleg_Widget',
  '\LS_Design_System_Widget',
  '\LS_Pricing_Widget',
  '\LS_Case_Breakdown_Widget',
  '\LS_Case_Showcase_Widget',
  '\LS_Team_Cards_Widget',
];


  foreach ($classes as $class) {
    if (class_exists($class)) {
      $widgets_manager->register(new $class());
    }
  }
});
